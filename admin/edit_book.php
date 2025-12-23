<?php
// admin/edit_book.php
require '../db.php';
$page_title = "Edit Buku";

$success_message = '';
$error_message = '';
$book_id = null;
$book = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = $_GET['id'];
    $stmt_select = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt_select->bind_param("i", $book_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        $error_message = "Buku tidak ditemukan.";
    }
    $stmt_select->close();
} else {
    $error_message = "ID Buku tidak valid.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $page_count = $_POST['page_count'];
    $stock = $_POST['stock']; 
    $tag = $_POST['tag'];
    $synopsis = $_POST['synopsis'];
    
    // --- LOGIKA KATEGORI BARU ---
    $category_id = $_POST['category_id'];
    $new_category = trim($_POST['new_category']);

    if (!empty($new_category)) {
        // Cek duplikat kategori
        $check_cat = $conn->prepare("SELECT id FROM categories WHERE name = ?");
        $check_cat->bind_param("s", $new_category);
        $check_cat->execute();
        $res_cat = $check_cat->get_result();

        if ($res_cat->num_rows > 0) {
            $category_id = $res_cat->fetch_assoc()['id'];
        } else {
            $stmt_cat = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt_cat->bind_param("s", $new_category);
            if ($stmt_cat->execute()) {
                $category_id = $stmt_cat->insert_id;
            }
            $stmt_cat->close();
        }
    }

    $is_popular = $_POST['is_popular'];
    $is_hidden = $_POST['is_hidden'];
    $existing_cover = $_POST['existing_cover']; 

    // Handle Cover
    $cover_image_path = $existing_cover; 
    $cover_url = trim($_POST['cover_url']);

    if (!empty($cover_url)) {
        if (filter_var($cover_url, FILTER_VALIDATE_URL)) {
            $cover_image_path = $cover_url; 
            if (!empty($existing_cover) && strpos($existing_cover, 'http') !== 0 && file_exists("../" . $existing_cover)) {
                unlink("../" . $existing_cover); 
            }
        } else {
            $error_message = "Link URL cover tidak valid.";
        }
    } elseif (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0 && $_FILES['cover_image']['size'] > 0) {
        $target_dir = "../images/";
        $file_name = time() . '_' . basename($_FILES["cover_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            $cover_image_path = "images/" . $file_name; 
            if (!empty($existing_cover) && strpos($existing_cover, 'http') !== 0 && file_exists("../" . $existing_cover)) {
                unlink("../" . $existing_cover); 
            }
        } else {
            $error_message = "Gagal upload cover baru.";
        }
    }

    if (empty($error_message)) {
        $stmt_update = $conn->prepare("UPDATE books SET 
            title = ?, author = ?, publisher = ?, publish_year = ?, page_count = ?, stock = ?, 
            synopsis = ?, cover_image = ?, category_id = ?, is_popular = ?, is_hidden = ?, tag = ?
            WHERE id = ?");
        
        $stmt_update->bind_param("sssiiississsi", 
            $title, $author, $publisher, $publish_year, $page_count, $stock, $synopsis, 
            $cover_image_path, $category_id, $is_popular, $is_hidden, $tag, $book_id);

        if ($stmt_update->execute()) {
            header('Location: manage_books.php?status=edited');
            exit;
        } else {
            $error_message = "Database error: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}

include 'admin_templates/header.php';

if (!$book && $_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<main class='container' style='padding-top: 30px;'><div class='contact-error'>$error_message</div></main>";
    include 'admin_templates/footer.php';
    exit;
}
?>

<main class="form-content">
    <h1 class="page-title">Edit Buku: <?php echo htmlspecialchars($book['title']); ?></h1>

    <?php if ($error_message): ?>
        <div class="contact-error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form class="admin-form" method="POST" action="edit_book.php?id=<?php echo $book_id; ?>" enctype="multipart/form-data">
        
        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
        <input type="hidden" name="existing_cover" value="<?php echo $book['cover_image']; ?>">

        <div class="form-group">
            <label for="title">Judul Buku</label>
            <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($book['title']); ?>">
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" id="author" name="author" required value="<?php echo htmlspecialchars($book['author']); ?>">
        </div>
        
        <div class="form-group">
            <label>Cover Saat Ini</label>
            <?php
            if (strpos($book['cover_image'], 'http') === 0) {
                $cover_path_edit = htmlspecialchars($book['cover_image']);
            } else {
                $cover_path_edit = '../' . htmlspecialchars($book['cover_image']);
            }
            ?>
            <img src="<?php echo $cover_path_edit; ?>" alt="Cover" style="width: 100px; height: auto; border-radius: 4px; display: block; margin-bottom: 10px;">
            
            <p style="font-size: 1em; color: var(--text-color); margin-top: 10px; font-weight: 600;">Ganti Cover</p>
            <label for="cover_url">Link URL Cover Baru</label>
            <input type="url" id="cover_url" name="cover_url" placeholder="https://...">
            <p style="font-size: 0.9em; color: var(--light-text-color); margin: 5px 0;">Atau upload file baru:</p>
            <input type="file" id="cover_image" name="cover_image" accept="image/*">
        </div>

        <div class="form-group" style="background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
            <label for="category_id">Kategori (Pilih Salah Satu)</label>
            <select id="category_id" name="category_id">
                <option value="">-- Pilih dari Daftar --</option>
                <?php
                $result_cat = $conn->query("SELECT id, name FROM categories ORDER BY name");
                while ($cat = $result_cat->fetch_assoc()) {
                    $selected = ($cat['id'] == $book['category_id']) ? 'selected' : '';
                    echo "<option value=\"{$cat['id']}\" $selected>".htmlspecialchars($cat['name'])."</option>";
                }
                ?>
            </select>
            
            <p style="text-align: center; margin: 10px 0; font-weight: bold; color: #aaa;">- ATAU -</p>
            
            <label for="new_category">Buat Kategori Baru</label>
            <input type="text" id="new_category" name="new_category" placeholder="Isi ini jika ingin ganti ke kategori baru">
        </div>

        <div class="form-group">
            <label for="tag">Tag (Genre)</label>
            <input type="text" id="tag" name="tag" value="<?php echo htmlspecialchars($book['tag']); ?>">
        </div>

        <div class="form-group">
            <label for="synopsis">Sinopsis</label>
            <textarea id="synopsis" name="synopsis" rows="6"><?php echo htmlspecialchars($book['synopsis']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="publisher">Penerbit</label>
            <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
        </div>

        <div class="form-group">
            <label for="publish_year">Tahun Terbit</label>
            <input type="number" id="publish_year" name="publish_year" value="<?php echo htmlspecialchars($book['publish_year']); ?>">
        </div>

        <div class="form-group">
            <label for="page_count">Jumlah Halaman</label>
            <input type="number" id="page_count" name="page_count" value="<?php echo htmlspecialchars($book['page_count']); ?>">
        </div>

        <div class="form-group">
            <label for="stock">Stok Buku</label>
            <input type="number" id="stock" name="stock" required min="0" value="<?php echo htmlspecialchars($book['stock']); ?>">
        </div>
        
        <div class="form-group">
            <label for="is_popular">Populer?</label>
            <select id="is_popular" name="is_popular">
                <option value="No" <?php echo ($book['is_popular'] == 'No') ? 'selected' : ''; ?>>No</option>
                <option value="Yes" <?php echo ($book['is_popular'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_hidden">Sembunyikan?</label>
            <select id="is_hidden" name="is_hidden">
                <option value="No" <?php echo ($book['is_hidden'] == 'No') ? 'selected' : ''; ?>>No (Tampilkan)</option>
                <option value="Yes" <?php echo ($book['is_hidden'] == 'Yes') ? 'selected' : ''; ?>>Yes (Sembunyikan)</option>
            </select>
        </div>

        <button type="submit" class="btn">Simpan Perubahan</button>
    </form>
</main>

<?php
include 'admin_templates/footer.php';
$conn->close();
?>