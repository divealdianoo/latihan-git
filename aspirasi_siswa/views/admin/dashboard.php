<?php 
$pageTitle = 'Dashboard - ' . APP_NAME;
require_once __DIR__ . '/../layouts/header.php'; 
?>

<!-- Mobile Toggle -->
<button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('show'); document.querySelector('.sidebar-overlay').classList.toggle('show');">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay"></div>

<!-- Sidebar Admin -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-bullhorn me-2"></i><?= APP_NAME ?></h4>
        <small>Panel Admin</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="<?= BASE_URL ?>?page=dashboard" class="nav-link active">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="nav-link">
            <i class="fas fa-inbox"></i> Daftar Aspirasi
        </a>
        <div class="nav-label">Manajemen</div>
        <a href="<?= BASE_URL ?>?page=kategori" class="nav-link">
            <i class="fas fa-tags"></i> Kategori
        </a>
        <a href="<?= BASE_URL ?>?page=history-admin" class="nav-link">
            <i class="fas fa-history"></i> Histori
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1)) ?></div>
            <div>
                <div class="user-name"><?= $_SESSION['admin_nama'] ?? 'Admin' ?></div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>?action=logout-admin" class="btn-logout" style="text-decoration:none; display:block; text-align:center;">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="main-content">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Ringkasan data aspirasi siswa</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6 col-6 animate-in">
            <div class="stat-card primary">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-value"><?= $totalAspirasi ?></div>
                <div class="stat-label">Total Aspirasi</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 animate-in">
            <div class="stat-card warning">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value"><?= $menunggu ?></div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 animate-in">
            <div class="stat-card info">
                <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                <div class="stat-value"><?= $diproses ?></div>
                <div class="stat-label">Diproses</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 animate-in">
            <div class="stat-card success">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value"><?= $selesai ?></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <!-- Recent Aspirasi -->
    <div class="animate-in">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 style="font-weight:700; font-size:1.1rem;">Aspirasi Terbaru</h5>
            <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="btn btn-sm btn-outline-custom">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Siswa</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentAspirasi)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>Belum ada aspirasi</h5>
                                    <p>Data aspirasi akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach (array_slice($recentAspirasi, 0, 10) as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($a['judul']) ?></strong></td>
                                <td>
                                    <div style="font-size:0.85rem;"><?= htmlspecialchars($a['nama_siswa']) ?></div>
                                    <div style="font-size:0.72rem; color:#64748b;"><?= htmlspecialchars($a['kelas']) ?></div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-25" style="color:#94a3b8;"><?= htmlspecialchars($a['nama_kategori']) ?></span></td>
                                <td style="font-size:0.82rem; color:#94a3b8;"><?= date('d/m/Y', strtotime($a['tgl_lapor'])) ?></td>
                                <td>
                                    <?php
                                    $statusClass = match($a['status']) {
                                        'Menunggu' => 'badge-menunggu',
                                        'Diproses' => 'badge-diproses',
                                        'Selesai' => 'badge-selesai',
                                        'Ditolak' => 'badge-ditolak',
                                        default => 'badge-menunggu'
                                    };
                                    ?>
                                    <span class="badge-status <?= $statusClass ?>"><?= $a['status'] ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress-custom flex-grow-1" style="width:60px;">
                                            <div class="progress-bar" style="width:<?= $a['progres'] ?>%"></div>
                                        </div>
                                        <span style="font-size:0.75rem; color:#94a3b8;"><?= $a['progres'] ?>%</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?page=aspirasi-detail-admin&id=<?= $a['id_aspirasi'] ?>" class="btn btn-sm btn-primary-custom btn-sm-custom">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
