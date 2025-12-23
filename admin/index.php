<?php
// admin/index.php
require '../db.php';
$page_title = "Admin Dashboard";
include 'admin_templates/header.php';

// --- 1. QUERY STATISTIK UTAMA ---
// Total Buku
$total_books = $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
// Total User
$total_users = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='user'")->fetch_assoc()['c'];
// Sedang Dipinjam (Status 'borrowed')
$active_loans = $conn->query("SELECT COUNT(*) as c FROM loans WHERE status='borrowed'")->fetch_assoc()['c'];
// Menunggu Diambil (Status 'booked')
$pending_loans = $conn->query("SELECT COUNT(*) as c FROM loans WHERE status='booked'")->fetch_assoc()['c'];

// --- 2. QUERY BUKU TERLARIS (TOP 5) ---
$sql_top = "SELECT b.title, COUNT(l.id) as total_pinjam 
            FROM loans l 
            JOIN books b ON l.book_id = b.id 
            GROUP BY l.book_id 
            ORDER BY total_pinjam DESC 
            LIMIT 5";
$res_top = $conn->query($sql_top);

// --- 3. QUERY TERLAMBAT PENGEMBALIAN (OVERDUE) ---
// Cari yang statusnya 'borrowed' TAPI due_date-nya kurang dari hari ini
$today = date('Y-m-d');
$sql_late = "SELECT l.loan_code, u.username, l.due_date, b.title
             FROM loans l
             JOIN users u ON l.user_id = u.id
             JOIN books b ON l.book_id = b.id
             WHERE l.status = 'borrowed' AND l.due_date < '$today'
             ORDER BY l.due_date ASC";
$res_late = $conn->query($sql_late);
?>

<style>
    /* Grid Layout: Membuat kartu berjejer ke samping */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Card Styling: Kotak putih dengan bayangan */
    .dash-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        display: flex;           /* KUNCI: Icon di kiri, Teks di kanan */
        align-items: center;
        gap: 20px;
        transition: transform 0.2s ease;
    }
    .dash-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    /* Icon Styling */
    .dash-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0; /* Biar icon tidak tergencet */
    }

    /* Warna Icon */
    .bg-blue { background: #e0f2fe; color: #0284c7; }
    .bg-purple { background: #f3e8ff; color: #9333ea; }
    .bg-green { background: #dcfce7; color: #16a34a; }
    .bg-orange { background: #ffedd5; color: #ea580c; }

    /* Text Styling */
    .dash-info h3 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: var(--primary-color);
        line-height: 1;
        margin-bottom: 5px;
    }
    .dash-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Layout Bagian Bawah (2 Kolom) */
    .dashboard-sections {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) {
        .dashboard-sections { grid-template-columns: 1fr; }
    }
</style>

<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    
    <div style="margin-bottom: 30px;">
        <h1 class="page-title" style="border:none; margin-bottom:5px;">Dashboard Ringkasan</h1>
        <p >Selamat datang, <strong>Administrator</strong>. Berikut ringkasan hari ini.</p>
    </div>

    <div class="dashboard-grid">
        <div class="dash-card">
            <div class="dash-icon bg-blue"><i class="fa-solid fa-book"></i></div>
            <div class="dash-info">
                <h3><?php echo $total_books; ?></h3>
                <p>Total Judul Buku</p>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-icon bg-purple"><i class="fa-solid fa-users"></i></div>
            <div class="dash-info">
                <h3><?php echo $total_users; ?></h3>
                <p>User Terdaftar</p>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-icon bg-green"><i class="fa-solid fa-book-reader"></i></div>
            <div class="dash-info">
                <h3><?php echo $active_loans; ?></h3>
                <p>Sedang Dipinjam</p>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-icon bg-orange"><i class="fa-solid fa-clock"></i></div>
            <div class="dash-info">
                <h3><?php echo $pending_loans; ?></h3>
                <p>Menunggu Diambil</p>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        
        <div class="table-card" style="margin-top: 0;">
            <h3 style="margin-bottom: 20px; color: red">
                <i class="fa-solid fa-triangle-exclamation" style="color: red;"></i> Terlambat Kembali
            </h3>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tenggat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res_late->num_rows > 0): ?>
                        <?php while ($late = $res_late->fetch_assoc()): 
                            // Hitung telat berapa hari
                            $diff = (strtotime($today) - strtotime($late['due_date'])) / (60 * 60 * 24);
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars(ucfirst($late['username'])); ?></strong></td>
                            <td><?php echo htmlspecialchars($late['title']); ?></td>
                            <td>
                                <span class="status-badge badge-red">
                                    Telat <?php echo $diff; ?> Hari
                                </span>
                            </td>
                            <td>
                                <a href="loans.php" class="btn-action btn-outline-small">Proses</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center; color:green;">🎉 Tidak ada buku yang terlambat!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-card" style="margin-top: 0;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">
                <i class="fa-solid fa-crown"></i> Buku Terlaris
            </h3>
            <ul style="list-style: none; padding: 0;">
                <?php if ($res_top->num_rows > 0): $rank = 1; ?>
                    <?php while ($top = $res_top->fetch_assoc()): ?>
                    <li style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                        <span style="font-weight: 500;">
                            <span><?php echo $rank++; ?></span> 
                            <?php echo htmlspecialchars($top['title']); ?>
                        </span>
                        <span class="status-badge badge-blue" style="background:#e0f2fe; color:#0284c7;">
                            <?php echo $top['total_pinjam']; ?> x
                        </span>
                    </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center; color:#999;">Belum ada data peminjaman.</p>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</main>

<?php
include 'admin_templates/footer.php';
$conn->close();
?>