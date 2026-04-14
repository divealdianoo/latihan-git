<?php 
$pageTitle = 'Kategori - ' . APP_NAME;
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
        <a href="<?= BASE_URL ?>?page=kategori" class="nav-link active"><i class="fas fa-tags"></i> Kategori</a>
        <a href="<?= BASE_URL ?>?page=history-admin" class="nav-link"><i class="fas fa-history"></i> Histori</a>
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
        <h2>Kelola Kategori</h2>
        <p>Manajemen kategori aspirasi siswa</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Form Tambah -->
        <div class="col-md-4 animate-in">
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-plus-circle me-2" style="color:var(--success);"></i>Tambah Kategori
                </h6>
                <form action="<?= BASE_URL ?>?action=kategori-store" method="POST">
                    <div class="mb-3">
                        <label class="form-label-custom">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-dark" placeholder="Masukkan nama kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div class="col-md-8 animate-in">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kategori)): ?>
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state" style="padding:30px;">
                                        <i class="fas fa-tags"></i>
                                        <h5>Belum ada kategori</h5>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($kategori as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <span id="label-<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></span>
                                        <form id="form-edit-<?= $k['id_kategori'] ?>" action="<?= BASE_URL ?>?action=kategori-update" method="POST" style="display:none;" class="d-flex gap-2">
                                            <input type="hidden" name="id_kategori" value="<?= $k['id_kategori'] ?>">
                                            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($k['nama_kategori']) ?>" class="form-control form-control-dark form-control-sm">
                                            <button type="submit" class="btn btn-sm btn-primary-custom btn-sm-custom"><i class="fas fa-check"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-custom btn-sm-custom" onclick="cancelEdit(<?= $k['id_kategori'] ?>)"><i class="fas fa-times"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-outline-custom btn-sm-custom" onclick="startEdit(<?= $k['id_kategori'] ?>)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?= BASE_URL ?>?action=kategori-delete" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                <input type="hidden" name="id_kategori" value="<?= $k['id_kategori'] ?>">
                                                <button type="submit" class="btn btn-sm btn-sm-custom" style="background:rgba(239,68,68,0.15); color:#f87171; border:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
function startEdit(id) {
    document.getElementById('label-' + id).style.display = 'none';
    document.getElementById('form-edit-' + id).style.display = 'flex';
}

function cancelEdit(id) {
    document.getElementById('label-' + id).style.display = 'inline';
    document.getElementById('form-edit-' + id).style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
