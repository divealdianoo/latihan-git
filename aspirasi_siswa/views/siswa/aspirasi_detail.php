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
        <small>Panel Siswa</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="<?= BASE_URL ?>?page=aspirasi" class="nav-link active"><i class="fas fa-inbox"></i> Aspirasi Saya</a>
        <a href="<?= BASE_URL ?>?page=aspirasi-create" class="nav-link"><i class="fas fa-plus-circle"></i> Buat Aspirasi</a>
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
        <h2>Detail Aspirasi</h2>
        <p>Lihat status penyelesaian, progres, dan umpan balik</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Info Detail -->
        <div class="col-lg-7 animate-in">
            <div class="card-glass mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 style="font-weight:700; font-size:1.15rem; flex:1;"><?= htmlspecialchars($aspirasi['judul']) ?></h5>
                    <?php
                    $statusClass = match($aspirasi['status']) {
                        'Menunggu' => 'badge-menunggu',
                        'Diproses' => 'badge-diproses',
                        'Selesai' => 'badge-selesai',
                        'Ditolak' => 'badge-ditolak',
                        default => 'badge-menunggu'
                    };
                    ?>
                    <span class="badge-status <?= $statusClass ?> ms-2"><?= $aspirasi['status'] ?></span>
                </div>
                
                <div class="mb-3">
                    <div style="font-size:0.78rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Isi Aspirasi</div>
                    <p style="font-size:0.92rem; line-height:1.7; color:var(--text-secondary);">
                        <?= nl2br(htmlspecialchars($aspirasi['isi_aspirasi'])) ?>
                    </p>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase;">Kategori</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;">
                                <i class="fas fa-tag me-1" style="color:var(--primary-light);"></i>
                                <?= htmlspecialchars($aspirasi['nama_kategori']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase;">Lokasi</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;">
                                <i class="fas fa-map-marker-alt me-1" style="color:var(--warning);"></i>
                                <?= htmlspecialchars($aspirasi['lokasi'] ?: '-') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding:12px; background:var(--dark); border-radius:10px;">
                            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase;">Tanggal</div>
                            <div style="font-size:0.88rem; font-weight:600; margin-top:2px;">
                                <i class="fas fa-calendar me-1" style="color:var(--info);"></i>
                                <?= date('d/m/Y', strtotime($aspirasi['tgl_lapor'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Umpan Balik Timeline -->
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-comments me-2" style="color:var(--primary-light);"></i>Umpan Balik dari Admin
                </h6>
                
                <?php if (empty($feedbacks)): ?>
                    <div class="empty-state" style="padding:30px;">
                        <i class="fas fa-comment-dots"></i>
                        <h5>Belum ada umpan balik</h5>
                        <p>Admin akan memberikan umpan balik setelah meninjau aspirasimu</p>
                    </div>
                <?php else: ?>
                    <div class="feedback-timeline">
                        <?php foreach ($feedbacks as $fb): ?>
                            <div class="feedback-item">
                                <div class="feedback-header">
                                    <span class="feedback-admin">
                                        <i class="fas fa-user-shield me-1"></i><?= htmlspecialchars($fb['nama_admin']) ?>
                                    </span>
                                    <span class="feedback-date"><?= date('d/m/Y H:i', strtotime($fb['tgl_feedback'])) ?></span>
                                </div>
                                <div class="feedback-content"><?= nl2br(htmlspecialchars($fb['isi_feedback'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Side Panel: Status & Progress -->
        <div class="col-lg-5 animate-in">
            <!-- Status Penyelesaian -->
            <div class="card-glass mb-4">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-tasks me-2" style="color:var(--info);"></i>Status Penyelesaian
                </h6>
                
                <div class="mb-3">
                    <!-- Status Steps -->
                    <div class="d-flex flex-column gap-3">
                        <?php
                        $steps = [
                            ['status' => 'Menunggu', 'icon' => 'fa-clock', 'label' => 'Menunggu Review', 'desc' => 'Aspirasi sedang menunggu ditinjau admin'],
                            ['status' => 'Diproses', 'icon' => 'fa-cog', 'label' => 'Sedang Diproses', 'desc' => 'Aspirasi sedang ditindaklanjuti'],
                            ['status' => 'Selesai', 'icon' => 'fa-check-circle', 'label' => 'Selesai', 'desc' => 'Aspirasi telah ditindaklanjuti']
                        ];
                        
                        $currentIndex = array_search($aspirasi['status'], array_column($steps, 'status'));
                        if ($aspirasi['status'] === 'Ditolak') $currentIndex = -1;
                        
                        foreach ($steps as $idx => $step):
                            $isActive = $idx <= $currentIndex;
                            $isCurrent = $idx === $currentIndex;
                        ?>
                            <div class="d-flex gap-3 align-items-start">
                                <div style="
                                    width:36px; 
                                    height:36px; 
                                    border-radius:10px; 
                                    display:flex; 
                                    align-items:center; 
                                    justify-content:center;
                                    flex-shrink:0;
                                    <?php if ($isCurrent): ?>
                                        background: var(--gradient-1); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.4);
                                    <?php elseif ($isActive): ?>
                                        background: rgba(16,185,129,0.15); color: var(--success);
                                    <?php else: ?>
                                        background: var(--dark); color: var(--text-muted);
                                    <?php endif; ?>
                                ">
                                    <i class="fas <?= $isActive && !$isCurrent ? 'fa-check' : $step['icon'] ?>" style="font-size:0.85rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size:0.88rem; font-weight:<?= $isCurrent ? '700' : '500' ?>; color:<?= $isActive ? 'var(--text-primary)' : 'var(--text-muted)' ?>;">
                                        <?= $step['label'] ?>
                                    </div>
                                    <div style="font-size:0.75rem; color:var(--text-muted);"><?= $step['desc'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if ($aspirasi['status'] === 'Ditolak'): ?>
                            <div class="d-flex gap-3 align-items-start">
                                <div style="width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:rgba(239,68,68,0.15); color:var(--danger);">
                                    <i class="fas fa-times" style="font-size:0.85rem;"></i>
                                </div>
                                <div>
                                    <div style="font-size:0.88rem; font-weight:700; color:var(--danger);">Ditolak</div>
                                    <div style="font-size:0.75rem; color:var(--text-muted);">Aspirasi tidak dapat ditindaklanjuti</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($aspirasi['tgl_update']): ?>
                    <div style="padding:10px 14px; background:var(--dark); border-radius:8px; font-size:0.78rem; color:var(--text-muted);">
                        <i class="fas fa-clock me-1"></i> Terakhir diperbarui: <?= date('d/m/Y H:i', strtotime($aspirasi['tgl_update'])) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Progres Perbaikan -->
            <div class="card-glass">
                <h6 style="font-weight:700; margin-bottom:16px;">
                    <i class="fas fa-chart-line me-2" style="color:var(--success);"></i>Progres Perbaikan
                </h6>
                
                <div class="text-center mb-3">
                    <div style="position:relative; width:120px; height:120px; margin:0 auto;">
                        <svg viewBox="0 0 120 120" style="transform:rotate(-90deg);">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="var(--dark)" stroke-width="8"/>
                            <circle cx="60" cy="60" r="54" fill="none" stroke="url(#grad)" stroke-width="8" 
                                stroke-dasharray="<?= 339.292 * $aspirasi['progres'] / 100 ?> 339.292"
                                stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#6366f1"/>
                                    <stop offset="100%" style="stop-color:#a78bfa"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;">
                            <div style="font-size:1.6rem; font-weight:800; color:var(--text-primary);"><?= $aspirasi['progres'] ?>%</div>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($aspirasi['catatan_progres'])): ?>
                    <div style="padding:12px; background:var(--dark); border-radius:10px;">
                        <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Catatan Progres</div>
                        <div style="font-size:0.85rem; color:var(--text-secondary);">
                            <?= htmlspecialchars($aspirasi['catatan_progres']) ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div style="text-align:center; font-size:0.82rem; color:var(--text-muted);">
                        Belum ada catatan progres dari admin
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
