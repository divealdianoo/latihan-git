<?php 
$pageTitle = 'Aspirasi Saya - ' . APP_NAME;
require_once __DIR__ . '/../layouts/header.php'; 
?>

<button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('show'); document.querySelector('.sidebar-overlay').classList.toggle('show');">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay"></div>

<!-- Sidebar Siswa -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-bullhorn me-2"></i><?= APP_NAME ?></h4>
        <small>Panel Siswa</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="<?= BASE_URL ?>?page=aspirasi" class="nav-link active">
            <i class="fas fa-inbox"></i> Aspirasi Saya
        </a>
        <a href="<?= BASE_URL ?>?page=aspirasi-create" class="nav-link">
            <i class="fas fa-plus-circle"></i> Buat Aspirasi
        </a>
        <a href="<?= BASE_URL ?>?page=aspirasi-history" class="nav-link">
            <i class="fas fa-history"></i> Histori
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['siswa_nama'] ?? 'S', 0, 1)) ?></div>
            <div>
                <div class="user-name"><?= $_SESSION['siswa_nama'] ?? 'Siswa' ?></div>
                <div class="user-role"><?= $_SESSION['siswa_kelas'] ?? '' ?> | NIS: <?= $_SESSION['siswa_nis'] ?? '' ?></div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>?action=logout-siswa" class="btn-logout" style="text-decoration:none; display:block; text-align:center;">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>
</aside>

<main class="main-content">
    <div class="page-header">
        <h2>Aspirasi Saya</h2>
        <p>Daftar aspirasi yang telah kamu kirimkan</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <?php
        $totalSiswa = count($aspirasi);
        $menungguSiswa = count(array_filter($aspirasi, fn($a) => $a['status'] === 'Menunggu'));
        $diprosesSiswa = count(array_filter($aspirasi, fn($a) => $a['status'] === 'Diproses'));
        $selesaiSiswa = count(array_filter($aspirasi, fn($a) => $a['status'] === 'Selesai'));
        ?>
        <div class="col-6 col-md-3 animate-in">
            <div class="stat-card primary">
                <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
                <div class="stat-value"><?= $totalSiswa ?></div>
                <div class="stat-label">Total Dikirim</div>
            </div>
        </div>
        <div class="col-6 col-md-3 animate-in">
            <div class="stat-card warning">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value"><?= $menungguSiswa ?></div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>
        <div class="col-6 col-md-3 animate-in">
            <div class="stat-card info">
                <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                <div class="stat-value"><?= $diprosesSiswa ?></div>
                <div class="stat-label">Diproses</div>
            </div>
        </div>
        <div class="col-6 col-md-3 animate-in">
            <div class="stat-card success">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value"><?= $selesaiSiswa ?></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="d-flex justify-content-between align-items-center mb-3 animate-in">
        <h5 style="font-weight:700; font-size:1.05rem;">Daftar Aspirasi</h5>
        <a href="<?= BASE_URL ?>?page=aspirasi-create" class="btn btn-primary-custom">
            <i class="fas fa-plus me-1"></i> Buat Aspirasi Baru
        </a>
    </div>

    <!-- Aspirasi Cards -->
    <?php if (empty($aspirasi)): ?>
        <div class="card-glass animate-in">
            <div class="empty-state">
                <i class="fas fa-bullhorn"></i>
                <h5>Belum ada aspirasi</h5>
                <p>Kirim aspirasi pertamamu untuk sekolah yang lebih baik!</p>
                <a href="<?= BASE_URL ?>?page=aspirasi-create" class="btn btn-primary-custom mt-3">
                    <i class="fas fa-plus me-1"></i> Buat Aspirasi
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($aspirasi as $a): ?>
                <div class="col-md-6 animate-in">
                    <div class="card-glass" style="cursor:pointer;" onclick="window.location='<?= BASE_URL ?>?page=aspirasi-detail&id=<?= $a['id_aspirasi'] ?>'">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 style="font-weight:700; font-size:0.95rem; margin:0; flex:1;">
                                <?= htmlspecialchars($a['judul']) ?>
                            </h6>
                            <?php
                            $statusClass = match($a['status']) {
                                'Menunggu' => 'badge-menunggu',
                                'Diproses' => 'badge-diproses',
                                'Selesai' => 'badge-selesai',
                                'Ditolak' => 'badge-ditolak',
                                default => 'badge-menunggu'
                            };
                            ?>
                            <span class="badge-status <?= $statusClass ?> ms-2"><?= $a['status'] ?></span>
                        </div>
                        
                        <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                            <?= htmlspecialchars($a['isi_aspirasi']) ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-secondary bg-opacity-25" style="color:#94a3b8; font-size:0.72rem;">
                                    <i class="fas fa-tag me-1"></i><?= htmlspecialchars($a['nama_kategori']) ?>
                                </span>
                                <span style="font-size:0.72rem; color:var(--text-muted);">
                                    <i class="fas fa-calendar me-1"></i><?= date('d/m/Y', strtotime($a['tgl_lapor'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:0.72rem; color:var(--text-muted);">Progres</span>
                                <span style="font-size:0.72rem; font-weight:600; color:var(--primary-light);"><?= $a['progres'] ?>%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar" style="width:<?= $a['progres'] ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
