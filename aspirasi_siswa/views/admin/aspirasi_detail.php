<?php 
$pageTitle = 'Detail Aspirasi - ' . APP_NAME;
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
        <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="nav-link active"><i class="fas fa-inbox"></i> Daftar Aspirasi</a>
        <div class="nav-label">Manajemen</div>
        <a href="<?= BASE_URL ?>?page=kategori" class="nav-link"><i class="fas fa-tags"></i> Kategori</a>
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
        <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="btn btn-outline-custom btn-sm-custom mb-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h2>Detail Aspirasi</h2>
        <p>Kelola status penyelesaian dan umpan balik</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Info Aspirasi -->
        <div class="col-lg-7 animate-in">
            <div class="card-glass mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 style="font-weight:700; font-size:1.15rem;"><?= htmlspecialchars($aspirasi['judul']) ?></h5>
                        <div class="d-flex gap-2 mt-2">
                            <?php
                            $statusClass = match($aspirasi['status']) {
                                'Menunggu' => 'badge-menunggu',
                                'Diproses' => 'badge-diproses',
                                'Selesai' => 'badge-selesai',
                                'Ditolak' => 'badge-ditolak',
                                default => 'badge-menunggu'
                            };
                            $prioClass = match($aspirasi['prioritas']) {
                                'Rendah' => 'badge-rendah',
                                'Sedang' => 'badge-sedang',
                                'Tinggi' => 'badge-tinggi',
                                default => 'badge-sedang'
                            };
                            ?>
                            <span class="badge-status <?= $statusClass ?>"><?= $aspirasi['status'] ?></span>
                            <span class="badge-status <?= $prioClass ?>">Prioritas: <?= $aspirasi['prioritas'] ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div style="font-size:0.82rem; color:var(--text-muted); margin-bottom:4px;">Isi Aspirasi</div>
                    <p style="font-size:0.92rem; line-height:1.7; color:var(--text-secondary);">
                        <?= nl2br(htmlspecialchars($aspirasi['isi_aspirasi'])) ?>
                    </p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Pelapor</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;"><?= htmlspecialchars($aspirasi['nama_siswa']) ?></div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">NIS: <?= $aspirasi['nis'] ?> | <?= htmlspecialchars($aspirasi['kelas']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Lokasi</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;"><?= htmlspecialchars($aspirasi['lokasi'] ?: '-') ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Kategori</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;"><?= htmlspecialchars($aspirasi['nama_kategori']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Tanggal Lapor</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;"><?= date('d/m/Y H:i', strtotime($aspirasi['tgl_lapor'])) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-3" style="padding:14px; background:var(--dark); border-radius:10px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size:0.82rem; font-weight:600;">Progres Perbaikan</span>
                        <span style="font-size:0.82rem; font-weight:700; color:var(--primary-light);"><?= $aspirasi['progres'] ?>%</span>
                    </div>
                    <div class="progress-custom" style="height:10px;">
                        <div class="progress-bar" style="width:<?= $aspirasi['progres'] ?>%"></div>
                    </div>
                    <?php if (!empty($aspirasi['catatan_progres'])): ?>
                        <div style="margin-top:8px; font-size:0.82rem; color:var(--text-muted);">
                            <i class="fas fa-info-circle me-1"></i> <?= htmlspecialchars($aspirasi['catatan_progres']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Umpan Balik Timeline -->
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-comments me-2" style="color:var(--primary-light);"></i>Umpan Balik
                </h6>
                
                <?php if (empty($feedbacks)): ?>
                    <div class="empty-state" style="padding:30px;">
                        <i class="fas fa-comment-slash"></i>
                        <h5>Belum ada umpan balik</h5>
                        <p>Kirim umpan balik pertama untuk aspirasi ini</p>
                    </div>
                <?php else: ?>
                    <div class="feedback-timeline">
                        <?php foreach ($feedbacks as $fb): ?>
                            <div class="feedback-item">
                                <div class="feedback-header">
                                    <span class="feedback-admin"><i class="fas fa-user-shield me-1"></i><?= htmlspecialchars($fb['nama_admin']) ?></span>
                                    <span class="feedback-date"><?= date('d/m/Y H:i', strtotime($fb['tgl_feedback'])) ?></span>
                                </div>
                                <div class="feedback-content"><?= nl2br(htmlspecialchars($fb['isi_feedback'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Side Panel: Update Status & Send Feedback -->
        <div class="col-lg-5 animate-in">
            <!-- Update Status -->
            <div class="card-glass mb-4">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-edit me-2" style="color:var(--warning);"></i>Update Status
                </h6>
                <form action="<?= BASE_URL ?>?action=update-status" method="POST">
                    <input type="hidden" name="id_aspirasi" value="<?= $aspirasi['id_aspirasi'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Status</label>
                        <select name="status" class="form-control form-control-dark">
                            <option value="Menunggu" <?= $aspirasi['status'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Diproses" <?= $aspirasi['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option value="Selesai" <?= $aspirasi['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="Ditolak" <?= $aspirasi['status'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Prioritas</label>
                        <select name="prioritas" class="form-control form-control-dark">
                            <option value="Rendah" <?= $aspirasi['prioritas'] === 'Rendah' ? 'selected' : '' ?>>Rendah</option>
                            <option value="Sedang" <?= $aspirasi['prioritas'] === 'Sedang' ? 'selected' : '' ?>>Sedang</option>
                            <option value="Tinggi" <?= $aspirasi['prioritas'] === 'Tinggi' ? 'selected' : '' ?>>Tinggi</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Progres (%)</label>
                        <input type="number" name="progres" class="form-control form-control-dark" min="0" max="100" value="<?= $aspirasi['progres'] ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Catatan Progres</label>
                        <textarea name="catatan_progres" class="form-control form-control-dark" rows="3" placeholder="Catatan perkembangan..."><?= htmlspecialchars($aspirasi['catatan_progres'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Kirim Umpan Balik -->
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-paper-plane me-2" style="color:var(--success);"></i>Kirim Umpan Balik
                </h6>
                <form action="<?= BASE_URL ?>?action=send-feedback" method="POST">
                    <input type="hidden" name="id_aspirasi" value="<?= $aspirasi['id_aspirasi'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Isi Umpan Balik</label>
                        <textarea name="isi_feedback" class="form-control form-control-dark" rows="4" placeholder="Tulis umpan balik untuk siswa..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom w-100" style="background:var(--gradient-3);">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
