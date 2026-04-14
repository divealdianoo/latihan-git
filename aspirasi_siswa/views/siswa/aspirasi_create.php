<?php 
$pageTitle = 'Buat Aspirasi - ' . APP_NAME;
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
        <a href="<?= BASE_URL ?>?page=aspirasi-create" class="nav-link active"><i class="fas fa-plus-circle"></i> Buat Aspirasi</a>
        <a href="<?= BASE_URL ?>?page=aspirasi-history" class="nav-link"><i class="fas fa-history"></i> Histori</a>
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
        <a href="<?= BASE_URL ?>?page=aspirasi" class="btn btn-outline-custom btn-sm-custom mb-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h2>Buat Aspirasi Baru</h2>
        <p>Sampaikan aspirasimu untuk sekolah yang lebih baik</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 animate-in">
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:20px;">
                    <i class="fas fa-edit me-2" style="color:var(--primary-light);"></i>Form Aspirasi
                </h6>
                
                <form action="<?= BASE_URL ?>?action=aspirasi-store" method="POST">
                    <div class="mb-3">
                        <label class="form-label-custom">Judul Aspirasi <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="judul" class="form-control form-control-dark" placeholder="Masukkan judul aspirasi" required maxlength="100">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">Kategori <span style="color:var(--danger);">*</span></label>
                            <select name="id_kategori" class="form-control form-control-dark" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control form-control-dark" placeholder="Misal: Kelas 12 RPL 1, Lab, dll" maxlength="100">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-custom">Isi Aspirasi <span style="color:var(--danger);">*</span></label>
                        <textarea name="isi_aspirasi" class="form-control form-control-dark" rows="6" placeholder="Jelaskan aspirasi, keluhan, atau saran kamu secara detail..." required></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Aspirasi
                        </button>
                        <a href="<?= BASE_URL ?>?page=aspirasi" class="btn btn-outline-custom">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tips -->
        <div class="col-lg-4 animate-in">
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-lightbulb me-2" style="color:var(--warning);"></i>Tips
                </h6>
                <div style="font-size:0.85rem; color:var(--text-secondary); line-height:1.8;">
                    <div class="mb-3">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="fas fa-check-circle" style="color:var(--success); margin-top:3px;"></i>
                            <span>Gunakan judul yang <strong>jelas dan singkat</strong></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="fas fa-check-circle" style="color:var(--success); margin-top:3px;"></i>
                            <span>Pilih <strong>kategori yang sesuai</strong> agar aspirasi lebih mudah ditindaklanjuti</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="fas fa-check-circle" style="color:var(--success); margin-top:3px;"></i>
                            <span>Jelaskan <strong>detail lokasi</strong> jika berkaitan dengan fasilitas</span>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex gap-2 align-items-start">
                            <i class="fas fa-check-circle" style="color:var(--success); margin-top:3px;"></i>
                            <span>Tulis aspirasi dengan <strong>bahasa yang sopan</strong> dan konstruktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
