<?php
// admin/loans.php
require '../db.php';
$page_title = "Data Peminjaman";
include 'admin_templates/header.php';

// --- LOGIKA PENCARIAN PEMINJAMAN ---
$search_keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$where_clause = "";

if (!empty($search_keyword)) {
    $search_safe = $conn->real_escape_string($search_keyword);
    $where_clause = "WHERE l.loan_code LIKE '%$search_safe%' 
                     OR u.username LIKE '%$search_safe%' 
                     OR b.title LIKE '%$search_safe%'";
}

$sql = "SELECT l.*, u.username, b.title, b.cover_image 
        FROM loans l
        JOIN users u ON l.user_id = u.id
        JOIN books b ON l.book_id = b.id
        $where_clause
        ORDER BY FIELD(l.status, 'booked', 'borrowed', 'returned'), l.loan_date DESC";

$result = $conn->query($sql);
?>

<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div style="margin-bottom: 25px;">
        <h1 class="page-title" style="margin-bottom: 5px;">Data Peminjaman</h1>
        <p style="color: #666;">Kelola serah terima buku dengan pengguna.</p>
    </div>

    <div style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 20px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="60%" valign="middle">
                    <form method="GET" action="loans.php" style="margin: 0;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                    <input type="text" name="q" placeholder="Cari kode, nama, atau buku..." 
                                           value="<?php echo htmlspecialchars($search_keyword); ?>" 
                                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px 0 0 6px; font-size: 14px; outline: none; margin: 0;">
                                </td>
                                <td width="1%">
                                    <button type="submit" style="background: var(--secondary-color); color: white; border: 1px solid var(--secondary-color); padding: 10px 20px; border-radius: 0 6px 6px 0; cursor: pointer; font-weight: 600; white-space: nowrap; margin: 0;">
                                        Cari Data
                                    </button>
                                </td>
                                <?php if(!empty($search_keyword)): ?>
                                <td width="1%" style="padding-left: 10px;">
                                    <a href="loans.php" style="display: block; padding: 10px 15px; background: #eee; color: #555; text-decoration: none; border-radius: 6px; font-size: 14px;">Reset</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </form>
                </td>

                <td width="40%" align="right" valign="middle">
                    <span style="color: #666; font-size: 14px; font-weight: 500;">
                        Ditemukan: <strong style="color: var(--primary-color);"><?php echo $result->num_rows; ?></strong> Transaksi
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Detail Transaksi</th>
                    <th>Peminjam</th>
                    <th width="30%">Buku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                        $badge = '';
                        if ($row['status'] == 'booked') {
                            $badge = '<span class="status-badge badge-orange">Menunggu Diambil</span>';
                        } elseif ($row['status'] == 'borrowed') {
                            $badge = '<span class="status-badge badge-green">Sedang Dipinjam</span>';
                        } else {
                            $badge = '<span class="status-badge badge-gray">Dikembalikan</span>';
                        }
                ?>
                    <tr>
                        <td>
                            <div style="display:flex; flex-direction:column;">
                                <span style="font-family:monospace; font-weight:bold; color:var(--primary-color);">
                                    <?php echo $row['loan_code']; ?>
                                </span>
                                <span style="font-size:12px; color:#888; margin-top:4px;">
                                    Tgl: <?php echo date('d M Y', strtotime($row['loan_date'])); ?>
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="user-flex">
                                <div class="avatar-circle" style="background-color: #eee; color: #555;">
                                    <?php echo substr($row['username'], 0, 1); ?>
                                </div>
                                <div class="user-info-text">
                                    <strong><?php echo htmlspecialchars(ucfirst($row['username'])); ?></strong>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span style="font-weight:600; color:var(--primary-color);">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </span>
                        </td>

                        <td><?php echo $badge; ?></td>

                        <td>
                            <?php if ($row['status'] == 'booked'): ?>
                                <a href="process_loan.php?id=<?php echo $row['id']; ?>&action=borrow" class="btn-action btn-primary-small">Serahkan Buku</a>
                            <?php elseif ($row['status'] == 'borrowed'): ?>
                                <a href="process_loan.php?id=<?php echo $row['id']; ?>&action=return" class="btn-action btn-outline-small">Terima Kembali</a>
                            <?php else: ?>
                                <span style="font-size:12px; color:#bbb;">- Selesai -</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px;'>Data peminjaman tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'admin_templates/footer.php'; ?>