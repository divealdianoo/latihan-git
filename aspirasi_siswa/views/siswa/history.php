<?php 
$pageTitle = 'Histori Aspirasi - ' . APP_NAME;
require_once __DIR__ . '/../layouts/header.php'; 
?>

<button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('show'); document.querySelector('.sidebar-overlay').classList.toggle('show');">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay"></div>

<aside class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-bullhorn me-2"></i><?= APP_NAME ?></h4>
        <small>Panel Siswa</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="<?= BASE_URL ?>?page=aspirasi" class="nav-link"><i class="fas fa-inbox"></i> Aspirasi Saya</a>
        <a href="<?= BASE_URL ?>?page=aspirasi-create" class="nav-link"><i class="fas fa-plus-circle"></i> Buat Aspirasi</a>
        <a href="<?= BASE_URL ?>?page=aspirasi-history" class="nav-link active"><i class="fas fa-history"></i> Histori</a>
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
        <h2>Histori Aspirasi</h2>
        <p>Riwayat semua aspirasi yang pernah kamu kirimkan</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <div class="table-container animate-in">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Progres</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($aspirasi)): ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <h5>Belum ada histori</h5>
                                <p>Aspirasi yang kamu kirimkan akan ditampilkan di sini</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($aspirasi as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="font-size:0.88rem;"><?= htmlspecialchars($a['judul']) ?></strong></td>
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
                                    <div class="progress-custom flex-grow-1" style="width:50px;">
                                        <div class="progress-bar" style="width:<?= $a['progres'] ?>%"></div>
                                    </div>
                                    <span style="font-size:0.72rem; color:#94a3b8;"><?= $a['progres'] ?>%</span>
                                </div>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>?page=aspirasi-detail&id=<?= $a['id_aspirasi'] ?>" class="btn btn-sm btn-primary-custom btn-sm-custom" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
