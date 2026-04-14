<?php 
$pageTitle = 'Daftar Aspirasi - ' . APP_NAME;
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
        <h2>Daftar Aspirasi</h2>
        <p>List aspirasi keseluruhan - filter per tanggal, bulan, siswa, atau kategori</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-custom alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>-custom mb-3 animate-in">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="card-glass mb-4 animate-in">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-filter" style="color:var(--primary-light);"></i>
            <h6 style="font-weight:700; margin:0;">Filter & Pencarian</h6>
        </div>
        
        <!-- Search -->
        <form action="<?= BASE_URL ?>" method="GET" class="mb-3">
            <input type="hidden" name="page" value="aspirasi-admin">
            <div class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-dark flex-grow-1" placeholder="Cari judul, isi, atau nama siswa..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-primary-custom"><i class="fas fa-search"></i></button>
                <a href="<?= BASE_URL ?>?page=aspirasi-admin" class="btn btn-outline-custom"><i class="fas fa-times"></i></a>
            </div>
        </form>

        <!-- Filters -->
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label-custom">Per Tanggal</label>
                <form action="<?= BASE_URL ?>" method="GET" class="d-flex gap-1">
                    <input type="hidden" name="page" value="aspirasi-admin">
                    <input type="hidden" name="filter" value="tanggal">
                    <input type="date" name="value" class="form-control form-control-dark" value="<?= $filter === 'tanggal' ? htmlspecialchars($value) : '' ?>">
                    <button type="submit" class="btn btn-sm btn-primary-custom"><i class="fas fa-check"></i></button>
                </form>
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Per Bulan</label>
                <form action="<?= BASE_URL ?>" method="GET" class="d-flex gap-1">
                    <input type="hidden" name="page" value="aspirasi-admin">
                    <input type="hidden" name="filter" value="bulan">
                    <input type="month" name="value" class="form-control form-control-dark" value="<?= $filter === 'bulan' ? htmlspecialchars($value) : '' ?>">
                    <button type="submit" class="btn btn-sm btn-primary-custom"><i class="fas fa-check"></i></button>
                </form>
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Per Siswa</label>
                <form action="<?= BASE_URL ?>" method="GET" class="d-flex gap-1">
                    <input type="hidden" name="page" value="aspirasi-admin">
                    <input type="hidden" name="filter" value="siswa">
                    <select name="value" class="form-control form-control-dark">
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach ($siswaList as $s): ?>
                            <option value="<?= $s['nis'] ?>" <?= ($filter === 'siswa' && $value == $s['nis']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nama_siswa']) ?> (<?= $s['nis'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary-custom"><i class="fas fa-check"></i></button>
                </form>
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Per Kategori</label>
                <form action="<?= BASE_URL ?>" method="GET" class="d-flex gap-1">
                    <input type="hidden" name="page" value="aspirasi-admin">
                    <input type="hidden" name="filter" value="kategori">
                    <select name="value" class="form-control form-control-dark">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>" <?= ($filter === 'kategori' && $value == $k['id_kategori']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary-custom"><i class="fas fa-check"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container animate-in">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Progres</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($aspirasi)): ?>
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-search"></i>
                                <h5>Tidak ada data</h5>
                                <p>Tidak ada aspirasi yang sesuai dengan filter</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($aspirasi as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="font-size:0.88rem;"><?= htmlspecialchars($a['judul']) ?></strong></td>
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
                                <?php
                                $prioClass = match($a['prioritas']) {
                                    'Rendah' => 'badge-rendah',
                                    'Sedang' => 'badge-sedang',
                                    'Tinggi' => 'badge-tinggi',
                                    default => 'badge-sedang'
                                };
                                ?>
                                <span class="badge-status <?= $prioClass ?>"><?= $a['prioritas'] ?></span>
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
                                <a href="<?= BASE_URL ?>?page=aspirasi-detail-admin&id=<?= $a['id_aspirasi'] ?>" class="btn btn-sm btn-primary-custom btn-sm-custom" title="Detail">
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
