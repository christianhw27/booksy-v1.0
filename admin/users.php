<?php
// admin/users.php
require '../db.php';
$page_title = "Kelola Pengguna";
include 'admin_templates/header.php';

// --- LOGIKA PENCARIAN ---
$search_keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$where_clause = "";

if (!empty($search_keyword)) {
    $search_safe = $conn->real_escape_string($search_keyword);
    $where_clause = "WHERE username LIKE '%$search_safe%' OR role LIKE '%$search_safe%'";
}

$sql = "SELECT * FROM users $where_clause ORDER BY last_active DESC";
$result = $conn->query($sql);
?>

<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <div style="margin-bottom: 25px;">
        <h1 class="page-title" style="margin-bottom: 5px;">Daftar Pengguna</h1>
        <p style="color: #666;">Pantau aktivitas pengguna yang terdaftar di sistem.</p>
    </div>

    <div style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 20px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="60%" valign="middle">
                    <form method="GET" action="users.php" style="margin: 0;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                    <input type="text" name="q" placeholder="Cari username atau role..." 
                                           value="<?php echo htmlspecialchars($search_keyword); ?>" 
                                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px 0 0 6px; font-size: 14px; outline: none; margin: 0;">
                                </td>
                                <td width="1%">
                                    <button type="submit" style="background: var(--secondary-color); color: white; border: 1px solid var(--secondary-color); padding: 10px 20px; border-radius: 0 6px 6px 0; cursor: pointer; font-weight: 600; white-space: nowrap; margin: 0;">
                                        Cari User
                                    </button>
                                </td>
                                <?php if(!empty($search_keyword)): ?>
                                <td width="1%" style="padding-left: 10px;">
                                    <a href="users.php" style="display: block; padding: 10px 15px; background: #eee; color: #555; text-decoration: none; border-radius: 6px; font-size: 14px;">Reset</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </form>
                </td>

                <td width="40%" align="right" valign="middle">
                    <span style="color: #666; font-size: 14px; font-weight: 500;">
                        Total: <strong style="color: var(--primary-color);"><?php echo $result->num_rows; ?></strong> Pengguna
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Terakhir Aktif</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($user = $result->fetch_assoc()) {
                        
                        $status_html = '<span class="status-badge badge-red">Offline</span>';
                        $last_active_str = '<span style="color:#999; font-style:italic;">Belum login</span>';

                        if ($user['last_active']) {
                            $time_diff = time() - strtotime($user['last_active']);
                            $last_active_str = date('d M Y, H:i', strtotime($user['last_active']));
                            if ($time_diff >= 0 && $time_diff <= 300) {
                                $status_html = '<span class="status-badge badge-green">Online</span>';
                            }
                        }
                ?>
                    <tr>
                        <td>
                            <div class="user-flex">
                                <div class="avatar-circle">
                                    <?php echo substr($user['username'], 0, 1); ?>
                                </div>
                                <div class="user-info-text">
                                    <strong style="display:block; color:var(--primary-color);">
                                        <?php echo htmlspecialchars($user['username']); ?>
                                    </strong>
                                    <span style="font-size:12px; color:#888;">ID: #<?php echo $user['id']; ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:600; font-size:13px; color: #555;">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td style="font-size:13px; color:#555;">
                            <?php echo $last_active_str; ?>
                        </td>
                        <td>
                            <?php echo $status_html; ?>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center; padding:30px;'>User tidak ditemukan.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'admin_templates/footer.php'; ?>