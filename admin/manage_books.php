<?php
// admin/manage_books.php
require '../db.php';
$page_title = "Kelola Buku";
include 'admin_templates/header.php';

// Cek Pesan Sukses
$success_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'deleted') $success_message = "Buku berhasil dihapus.";
    if ($_GET['status'] == 'edited') $success_message = "Buku berhasil diperbarui.";
    if ($_GET['status'] == 'added') $success_message = "Buku berhasil ditambahkan.";
}

// --- LOGIKA PENCARIAN & PAGINATION ---
$search_keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; 
$offset = ($page - 1) * $limit;

$where_clause = "";
if (!empty($search_keyword)) {
    $search_safe = $conn->real_escape_string($search_keyword);
    $where_clause = "WHERE b.title LIKE '%$search_safe%' 
                     OR b.author LIKE '%$search_safe%' 
                     OR c.name LIKE '%$search_safe%'";
}

$sql_count = "SELECT COUNT(*) as total FROM books b LEFT JOIN categories c ON b.category_id = c.id $where_clause";
$res_count = $conn->query($sql_count);
$total_rows = $res_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT b.*, c.name AS category_name 
        FROM books b 
        LEFT JOIN categories c ON b.category_id = c.id 
        $where_clause
        ORDER BY b.id DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    
    <div style="margin-bottom: 25px;">
        <h1 class="page-title" style="margin-bottom: 5px;">Kelola Buku</h1>
        <p style="color: #666;">Total <?php echo $total_rows; ?> buku di database.</p>
    </div>

    <?php if ($success_message): ?>
        <div class="contact-success" style="padding:15px; margin-bottom:20px; font-size:14px; background:#dcfce7; color:#166534; border:1px solid #bbf7d0; border-radius:8px;">
            ✅ <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 20px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="60%" valign="middle">
                    <form method="GET" action="manage_books.php" style="margin: 0;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                    <input type="text" name="q" placeholder="Cari judul..." 
                                           value="<?php echo htmlspecialchars($search_keyword); ?>" 
                                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px 0 0 6px; font-size: 14px; outline: none; margin: 0;">
                                </td>
                                <td width="1%">
                                    <button type="submit" style="background: var(--secondary-color); color: white; border: 1px solid var(--secondary-color); padding: 10px 20px; border-radius: 0 6px 6px 0; cursor: pointer; font-weight: 600; white-space: nowrap; margin: 0;">
                                        Cari
                                    </button>
                                </td>
                                <?php if(!empty($search_keyword)): ?>
                                <td width="1%" style="padding-left: 10px;">
                                    <a href="manage_books.php" style="display: block; padding: 10px 15px; background: #eee; color: #555; text-decoration: none; border-radius: 6px; font-size: 14px;">Reset</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </form>
                </td>

                <td width="40%" align="right" valign="middle">
                    <a href="add_book.php" class="btn" style="display: inline-block; padding: 10px 20px; background: var(--primary-color); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; white-space: nowrap;">
                        + Tambah Buku
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">Cover</th>
                    <th>Info Buku</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($book = $result->fetch_assoc()) {
                        
                        if (strpos($book['cover_image'], 'http') === 0) {
                            $cover_src = htmlspecialchars($book['cover_image']);
                        } else {
                            $cover_src = '../' . htmlspecialchars($book['cover_image']);
                        }

                        $badges = "";
                        if ($book['is_popular'] == 'Yes') $badges .= '<span class="status-badge badge-orange" style="font-size:10px; margin-right:5px;">Populer</span>';
                        if ($book['is_hidden'] == 'Yes') $badges .= '<span class="status-badge badge-gray" style="font-size:10px;">Hidden</span>';
                ?>
                    <tr>
                        <td>
                            <img src="<?php echo $cover_src; ?>" alt="Cover" style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        </td>
                        <td>
                            <strong style="color: var(--primary-color); display: block; font-size: 15px; margin-bottom: 3px;">
                                <?php echo htmlspecialchars($book['title']); ?>
                            </strong>
                            <span style="font-size: 13px; color: #777;">
                                <?php echo htmlspecialchars($book['author']); ?>
                            </span>
                            <div style="margin-top: 5px;">
                                <?php echo $badges; ?>
                            </div>
                        </td>
                        <td>
                            <span style="background: #f0f9ff; color: var(--secondary-color); padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                <?php echo htmlspecialchars($book['category_name']); ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            if($book['stock'] > 0) echo "<strong>{$book['stock']}</strong>";
                            else echo "<span style='color:red; font-weight:bold;'>Habis</span>";
                            ?>
                        </td>
                        <td>
                            <?php if ($book['is_hidden'] == 'Yes'): ?>
                                <span style="color: #aaa; font-style: italic;">Disembunyikan</span>
                            <?php else: ?>
                                <span style="color: green;">Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn-action btn-outline-small" title="Edit">
                                    Edit
                                </a>
                                <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn-action" style="background: #fee2e2; color: #dc2626;" onclick="return confirm('Yakin hapus buku ini?');" title="Hapus">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding: 40px; color: #999;'>Tidak ada buku yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&q=<?php echo urlencode($search_keyword); ?>">« Prev</a>
            <?php else: ?>
                <span class="disabled">« Prev</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>&q=<?php echo urlencode($search_keyword); ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&q=<?php echo urlencode($search_keyword); ?>">Next »</a>
            <?php else: ?>
                <span class="disabled">Next »</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</main>

<?php include 'admin_templates/footer.php'; ?>