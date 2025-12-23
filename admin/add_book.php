<?php
// admin/add_book.php
require '../db.php';
$page_title = "Tambah Buku Baru";

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $page_count = $_POST['page_count'];
    $stock = $_POST['stock'];
    $tag = $_POST['tag'];
    $synopsis = $_POST['synopsis'];
    
    // --- LOGIKA KATEGORI BARU ---
    $category_id = $_POST['category_id']; // Dari Dropdown
    $new_category = trim($_POST['new_category']); // Dari Input Teks

    // Jika admin mengisi input kategori baru
    if (!empty($new_category)) {
        // Cek dulu apakah kategori itu sudah ada (biar gak duplikat)
        $check_cat = $conn->prepare("SELECT id FROM categories WHERE name = ?");
        $check_cat->bind_param("s", $new_category);
        $check_cat->execute();
        $res_cat = $check_cat->get_result();

        if ($res_cat->num_rows > 0) {
            // Kalau sudah ada, pakai ID yang lama
            $category_id = $res_cat->fetch_assoc()['id'];
        } else {
            // Kalau belum ada, buat baru
            $stmt_cat = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt_cat->bind_param("s", $new_category);
            if ($stmt_cat->execute()) {
                $category_id = $stmt_cat->insert_id; // Ambil ID baru
            } else {
                $error_message = "Gagal membuat kategori baru.";
            }
            $stmt_cat->close();
        }
    }

    // Validasi akhir: Kategori wajib dipilih atau dibuat
    if (empty($category_id) && empty($error_message)) {
        $error_message = "Kategori wajib dipilih atau buat baru.";
    }

    $is_popular = $_POST['is_popular'];
    $is_hidden = $_POST['is_hidden'];

    // Handle Cover
    $cover_image_path = '';
    $cover_url = trim($_POST['cover_url']);

    if (!empty($cover_url)) {
        if (filter_var($cover_url, FILTER_VALIDATE_URL)) {
            $cover_image_path = $cover_url;
        } else {
            $error_message = "Link URL cover tidak valid.";
        }
    } elseif (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $target_dir = "../images/";
        $file_name = time() . '_' . basename($_FILES["cover_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            $cover_image_path = "images/" . $file_name;
        } else {
            $error_message = "Gagal upload cover.";
        }
    } else {
        $error_message = "Cover wajib diisi.";
    }

    if (empty($error_message)) {
        $stmt = $conn->prepare("INSERT INTO books 
            (title, author, publisher, publish_year, page_count, stock, synopsis, cover_image, category_id, is_popular, is_hidden, tag) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssiisssisss", 
            $title, $author, $publisher, $publish_year, $page_count, $stock, $synopsis, $cover_image_path, $category_id, $is_popular, $is_hidden, $tag);

        if ($stmt->execute()) {
            header('Location: manage_books.php?status=added');
            exit;
        } else {
            $error_message = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

include 'admin_templates/header.php';
?>

<main class="form-content">
    <h1 class="page-title">Tambah Buku Baru</h1>

    <?php if ($error_message): ?>
        <div class="contact-error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form class="admin-form" method="POST" action="add_book.php" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="title">Judul Buku</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" id="author" name="author" required>
        </div>
        
        <div class="form-group">
            <label for="cover_url">Link URL Cover Buku</label>
            <input type="url" id="cover_url" name="cover_url" placeholder="https://...">
            <p style="font-size: 0.9em; color: var(--light-text-color); margin: 5px 0;">Atau upload file:</p>
            <input type="file" id="cover_image" name="cover_image" accept="image/*">
        </div>

        <div class="form-group" style="background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
            <label for="category_id">Kategori (Pilih Salah Satu)</label>
            <select id="category_id" name="category_id">
                <option value="">-- Pilih dari Daftar --</option>
                <?php
                $result_cat = $conn->query("SELECT id, name FROM categories ORDER BY name");
                while ($cat = $result_cat->fetch_assoc()) {
                    echo "<option value=\"{$cat['id']}\">".htmlspecialchars($cat['name'])."</option>";
                }
                ?>
            </select>
            
            <p style="text-align: center; margin: 10px 0; font-weight: bold; color: #aaa;">- ATAU -</p>
            
            <label for="new_category">Buat Kategori Baru</label>
            <input type="text" id="new_category" name="new_category" placeholder="Ketik nama kategori baru disini (otomatis tersimpan)">
        </div>

        <div class="form-group">
            <label for="tag">Tag (Genre)</label>
            <input type="text" id="tag" name="tag">
        </div>

        <div class="form-group">
            <label for="synopsis">Sinopsis</label>
            <textarea id="synopsis" name="synopsis" rows="6"></textarea>
        </div>
        
        <div class="form-group">
            <label for="publisher">Penerbit</label>
            <input type="text" id="publisher" name="publisher">
        </div>

        <div class="form-group">
            <label for="publish_year">Tahun Terbit</label>
            <input type="number" id="publish_year" name="publish_year">
        </div>

        <div class="form-group">
            <label for="page_count">Jumlah Halaman</label>
            <input type="number" id="page_count" name="page_count">
        </div>

        <div class="form-group">
            <label for="stock">Stok Buku</label>
            <input type="number" id="stock" name="stock" required min="0" value="5">
        </div>
        
        <div class="form-group">
            <label for="is_popular">Populer?</label>
            <select id="is_popular" name="is_popular">
                <option value="No" selected>No</option>
                <option value="Yes">Yes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_hidden">Sembunyikan?</label>
            <select id="is_hidden" name="is_hidden">
                <option value="No" selected>No (Tampilkan)</option>
                <option value="Yes">Yes (Sembunyikan)</option>
            </select>
        </div>

        <button type="submit" class="btn">Simpan Buku</button>
    </form>
</main>

<?php
include 'admin_templates/footer.php';
$conn->close();
?>