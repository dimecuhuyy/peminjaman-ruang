<?php
use yii\helpers\Html;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1>Selamat Datang di Sistem Peminjaman Ruang</h1>
        <p class="lead">SMKN 1 Bantul - Kompetensi Keahlian RPL</p>
        
        <div class="admin-info-card mt-4">
            <h4>
                <i class="fas fa-user me-2"></i>
                Halo, <?= Html::encode(Yii::$app->user->identity->username) ?>!
            </h4>
            <p class="mb-0">
                Anda login sebagai 
                <span class="badge bg-light text-dark fs-6">
                    <?= Yii::$app->user->identity->getRoleLabel() ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Peminjaman -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="stat-number"><?= $data['totalPeminjaman'] ?></h3>
                    <p class="card-text">
                        <?php if ($user->isPeminjam()): ?>
                            Total Peminjaman Saya
                        <?php else: ?>
                            Total Peminjaman
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Peminjaman Pending -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="feature-icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="stat-number"><?= $data['peminjamanPending'] ?></h3>
                    <p class="card-text">
                        <?php if ($user->isPeminjam()): ?>
                            Peminjaman Pending
                        <?php else: ?>
                            Menunggu Persetujuan
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Peminjaman Disetujui -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="feature-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="stat-number"><?= $data['peminjamanDisetujui'] ?></h3>
                    <p class="card-text">
                        <?php if ($user->isPeminjam()): ?>
                            Disetujui
                        <?php else: ?>
                            Telah Disetujui
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card ke-4: berbeda berdasarkan role -->
        <?php if ($user->isPeminjam()): ?>
            <!-- Untuk Peminjam: Total Ruang -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="feature-icon text-info">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="stat-number"><?= $data['totalRuang'] ?></h3>
                        <p class="card-text">Total Ruang Tersedia</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Untuk Admin/Petugas: Total Users -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="feature-icon text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="stat-number"><?= $data['totalUsers'] ?></h3>
                        <p class="card-text">Total Users</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if ($user->isAdministrator() || $user->isPetugas()): ?>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-clipboard-list me-2"></i>Kelola Peminjaman', ['peminjaman/index'], [
                                    'class' => 'btn btn-outline-primary w-100 h-100 py-3'
                                ]) ?>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-building me-2"></i>Manajemen Ruang', ['ruang/index'], [
                                    'class' => 'btn btn-outline-success w-100 h-100 py-3'
                                ]) ?>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-chart-bar me-2"></i>Laporan', ['laporan/index'], [
                                    'class' => 'btn btn-outline-info w-100 h-100 py-3'
                                ]) ?>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-calendar-alt me-2"></i>Jadwal', ['jadwal/index'], [
                                    'class' => 'btn btn-outline-warning w-100 h-100 py-3'
                                ]) ?>
                            </div>
                        <?php else: ?>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman', ['peminjaman/create'], [
                                    'class' => 'btn btn-outline-primary w-100 h-100 py-3'
                                ]) ?>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-history me-2"></i>Status Peminjaman', ['peminjaman/index'], [
                                    'class' => 'btn btn-outline-success w-100 h-100 py-3'
                                ]) ?>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <?= Html::a('<i class="fas fa-calendar-alt me-2"></i>Jadwal Ruang', ['jadwal/index'], [
                                    'class' => 'btn btn-outline-info w-100 h-100 py-3'
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Peminjaman -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-history me-2"></i>
                <?php if ($user->isPeminjam()): ?>
                    Peminjaman Terbaru Saya
                <?php else: ?>
                    Peminjaman Terbaru
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($data['recentPeminjaman'])): ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">
                        <?php if ($user->isPeminjam()): ?>
                            Belum ada peminjaman. <?= Html::a('Ajukan peminjaman pertama Anda!', ['peminjaman/create'], ['class' => 'text-primary']) ?>
                        <?php else: ?>
                            Belum ada data peminjaman.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <?php if (!$user->isPeminjam()): ?>
                                    <th>Peminjam</th>
                                <?php endif; ?>
                                <th>Ruang</th>
                                <th width="120">Tanggal</th>
                                <th width="120">Jam</th>
                                <th width="100">Status</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['recentPeminjaman'] as $index => $peminjaman): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <?php if (!$user->isPeminjam()): ?>
                                    <td><?= Html::encode($peminjaman->user->username) ?></td>
                                <?php endif; ?>
                                <td><?= Html::encode($peminjaman->ruang->nama_ruang) ?></td>
                                <td class="text-center"><?= Yii::$app->formatter->asDate($peminjaman->tanggal_pinjam) ?></td>
                                <td class="text-center"><?= $peminjaman->jam_mulai ?> - <?= $peminjaman->jam_selesai ?></td>
                                <td class="text-center">
                                    <?php
                                    $statuses = [
                                        'pending' => '<span class="badge bg-warning">Menunggu</span>',
                                        'disetujui' => '<span class="badge bg-success">Disetujui</span>',
                                        'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
                                    ];
                                    echo $statuses[$peminjaman->status] ?? '<span class="badge bg-secondary">Unknown</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fas fa-eye"></i>', ['peminjaman/view', 'id' => $peminjaman->id], [
                                        'class' => 'btn btn-sm btn-info',
                                        'title' => 'Lihat Detail'
                                    ]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3 text-end">
                    <?= Html::a('Lihat Semua Peminjaman →', ['peminjaman/index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Custom styles untuk dashboard */
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px;
    padding: 3rem 2rem;
    margin: 2rem 0;
    text-align: center;
}

.admin-info-card {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
    margin: 1rem auto;
    max-width: 400px;
    backdrop-filter: blur(10px);
}

.stat-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(45deg, #4361ee, #3a0ca3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0.5rem 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-section {
        padding: 2rem 1rem;
        margin: 1rem 0;
    }
    
    .admin-info-card {
        padding: 1rem;
        margin: 0.5rem auto;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .feature-icon {
        font-size: 2rem;
    }
    
    .btn.py-3 {
        padding: 1rem 0.5rem !important;
    }
}

@media (max-width: 576px) {
    .welcome-section {
        padding: 1.5rem 1rem;
    }
    
    .stat-number {
        font-size: 1.8rem;
    }
    
    .card-text {
        font-size: 0.9rem;
    }
    
    small {
        font-size: 0.8rem;
    }
}
</style>