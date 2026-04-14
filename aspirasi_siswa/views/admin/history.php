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
        <small>Panel Admin</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="<?= BASE_URL ?>?page=dashboard" class="nav-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="nav-link"><i class="fas fa-inbox"></i> Daftar Aspirasi</a>
        <div class="nav-label">Manajemen</div>
        <a href="<?= BASE_URL ?>?page=kategori" class="nav-link"><i class="fas fa-tags"></i> Kategori</a>
        <a href="<?= BASE_URL ?>?page=history-admin" class="nav-link active"><i class="fas fa-history"></i> Histori</a>
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

<main class="main-content">
    <div class="page-header">
        <h2>Histori Aspirasi</h2>
        <p>Daftar aspirasi yang sudah selesai atau ditolak</p>
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
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th>Tgl Lapor</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($aspirasi)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <h5>Belum ada histori</h5>
                                <p>Aspirasi yang sudah selesai/ditolak akan ditampilkan di sini</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($aspirasi as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($a['judul']) ?></strong></td>
                            <td>
                                <div style="font-size:0.85rem;"><?= htmlspecialchars($a['nama_siswa']) ?></div>
                                <div style="font-size:0.72rem; color:#64748b;"><?= htmlspecialchars($a['kelas']) ?></div>
                            </td>
                            <td><span class="badge bg-secondary bg-opacity-25" style="color:#94a3b8;"><?= htmlspecialchars($a['nama_kategori']) ?></span></td>
                            <td style="font-size:0.82rem; color:#94a3b8;"><?= date('d/m/Y', strtotime($a['tgl_lapor'])) ?></td>
                            <td style="font-size:0.82rem; color:#94a3b8;"><?= $a['tgl_update'] ? date('d/m/Y', strtotime($a['tgl_update'])) : '-' ?></td>
                            <td>
                                <?php
                                $statusClass = $a['status'] === 'Selesai' ? 'badge-selesai' : 'badge-ditolak';
                                ?>
                                <span class="badge-status <?= $statusClass ?>"><?= $a['status'] ?></span>
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
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
