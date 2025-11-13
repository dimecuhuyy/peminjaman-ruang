<?php
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Sistem Peminjaman Ruang</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .main-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin: 20px auto;
            min-height: calc(100vh - 40px);
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        /* Tambahan untuk spacing yang lebih baik */
        .content-wrapper {
            padding: 15px 0;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            background: #ffffff;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Improved spacing untuk elemen form */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        /* PERBAIKAN: Text header tabel harus putih */
        .table th {
            background: linear-gradient(45deg, var(--primary), var(--secondary)) !important;
            color: white !important;
            border: none !important;
            font-weight: 600;
            padding: 15px 12px;
        }

        /* Selector lebih spesifik untuk memastikan warna putih */
        table th,
        .table thead th,
        .data-table th,
        table thead th {
            color: white !important;
            background: linear-gradient(45deg, var(--primary), var(--secondary)) !important;
        }

        /* Pastikan link di header juga putih */
        .table th a,
        .table th span,
        .table th div {
            color: white !important;
            text-decoration: none;
        }

        .table th a:hover {
            color: #f8f9fa !important;
            text-decoration: underline;
        }

        .table td {
            padding: 12px 12px;
            vertical-align: middle;
            color: var(--dark);
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transform: translateX(5px);
        }
        
        /* Dropdown menu */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 10px;
            margin-top: 10px;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 10px 15px;
            margin: 2px 0;
            transition: all 0.3s ease;
            color: var(--dark);
        }
        
        .dropdown-item:hover {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white !important;
            transform: translateX(5px);
        }
        
        .dropdown-divider {
            margin: 8px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #4361ee, #3a0ca3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            font-weight: 500;
            border-radius: 10px;
            margin: 0 5px;
            padding: 10px 15px !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: var(--primary);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 20px 25px !important;
            background: linear-gradient(45deg, var(--primary), var(--secondary)) !important;
            color: white !important;
        }
        
        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            padding: 10px 20px;
            margin: 5px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
        }
        
        .btn-success {
            background: linear-gradient(45deg, #4cc9f0, #4895ef);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .badge {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 12px;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            font-weight: 500;
            padding: 15px 20px;
            margin: 15px 0;
        }
        
        .jumbotron {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            margin: 25px 0;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-card {
            text-align: center;
            padding: 2rem 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .floating-nav {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 10px 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border-radius: 15px;
            margin-top: 3rem;
            padding: 30px 25px;
        }
        
        /* Style khusus untuk halaman index/home */
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            margin: 2rem 0;
            text-align: center;
        }
        
        .admin-info-card {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
            text-align: center;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* ===== RESPONSIVE DESIGN ===== */
        
        /* Tablet (768px - 991px) */
        @media (max-width: 991px) {
            .main-container {
                margin: 15px;
                padding: 20px;
                border-radius: 18px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .table-container {
                padding: 20px;
            }
            
            .form-container {
                padding: 25px;
            }
            
            .nav-link {
                padding: 8px 12px !important;
                margin: 2px 0;
                font-size: 0.9rem;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
            
            .welcome-section {
                padding: 2rem 1.5rem;
                margin: 1.5rem 0;
            }
            
            .feature-card {
                padding: 1.5rem;
            }
        }
        
        /* Mobile (576px - 767px) */
        @media (max-width: 767px) {
            .main-container {
                margin: 10px;
                padding: 15px;
                border-radius: 15px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .table-container {
                padding: 15px;
                margin: 15px 0;
            }
            
            .form-container {
                padding: 20px 15px;
            }
            
            .nav-link {
                padding: 6px 10px !important;
                font-size: 0.85rem;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .btn {
                width: 100%;
                margin: 5px 0;
                padding: 10px 16px;
            }
            
            .table-responsive {
                border-radius: 10px;
                border: 1px solid #dee2e6;
            }
            
            .dropdown-menu {
                margin-top: 5px;
                border-radius: 8px;
                font-size: 0.9rem;
            }
            
            .welcome-section {
                padding: 1.5rem 1rem;
                margin: 1rem 0;
                font-size: 0.9rem;
            }
            
            .feature-card {
                padding: 1rem;
                margin: 0.5rem 0;
            }
            
            .footer {
                padding: 20px 15px;
                margin-top: 2rem;
            }
            
            /* Improve table readability on mobile */
            .table th,
            .table td {
                padding: 8px 6px;
                font-size: 0.85rem;
            }
            
            /* Stack cards vertically on mobile */
            .row .col-md-6,
            .row .col-md-4,
            .row .col-md-3 {
                margin-bottom: 15px;
            }
        }
        
        /* Small Mobile (< 576px) */
        @media (max-width: 575px) {
            .main-container {
                margin: 5px;
                padding: 10px;
                border-radius: 10px;
            }
            
            .card-body {
                padding: 12px;
            }
            
            .card {
                margin-bottom: 15px;
            }
            
            .nav-link {
                padding: 5px 8px !important;
                font-size: 0.8rem;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
            
            .btn {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
            
            .table th,
            .table td {
                padding: 6px 4px;
                font-size: 0.8rem;
            }
            
            .alert {
                padding: 12px 15px;
                margin: 10px 0;
                font-size: 0.85rem;
            }
            
            .welcome-section {
                padding: 1rem;
                margin: 0.5rem 0;
                font-size: 0.85rem;
            }
            
            .footer {
                padding: 15px 10px;
                font-size: 0.85rem;
            }
            
            h1 { font-size: 1.5rem; }
            h2 { font-size: 1.3rem; }
            h3 { font-size: 1.2rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            h6 { font-size: 0.9rem; }
            
            /* Form improvements for mobile */
            .form-control {
                padding: 10px 12px;
                font-size: 16px; /* Prevent zoom on iOS */
            }
            
            .form-label {
                font-size: 14px;
                margin-bottom: 0.5rem;
            }
        }
        
        /* Extra Small Devices (<= 375px) */
        @media (max-width: 375px) {
            .main-container {
                margin: 2px;
                padding: 8px;
            }
            
            .card-body {
                padding: 10px;
            }
            
            .navbar-brand {
                font-size: 0.9rem;
            }
            
            .nav-link {
                font-size: 0.75rem;
                padding: 4px 6px !important;
            }
            
            .btn {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
            
            .table th,
            .table td {
                padding: 4px 3px;
                font-size: 0.75rem;
            }
        }
        
        /* Print Styles */
        @media print {
            .floating-nav,
            .footer,
            .btn,
            .no-print {
                display: none !important;
            }
            
            .main-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
                background: white;
            }
            
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light floating-nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Url::to(['site/index']) ?>">
            <i class="fas fa-school me-2"></i>Sistem Peminjaman Ruang
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['site/index']) ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php if (Yii::$app->user->identity->isAdministrator()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cogs me-1"></i>Administrasi
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= Url::to(['ruang/index']) ?>">
                                    <i class="fas fa-building me-2"></i>Manajemen Ruang
                                </a></li>
                                <li><a class="dropdown-item" href="<?= Url::to(['user/index']) ?>">
                                    <i class="fas fa-users me-2"></i>Manajemen User
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= Url::to(['laporan/index']) ?>">
                                    <i class="fas fa-chart-bar me-2"></i>Laporan
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['peminjaman/index']) ?>">
                                <i class="fas fa-clipboard-list me-1"></i>Kelola Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['jadwal/index']) ?>">
                                <i class="fas fa-calendar-alt me-1"></i>Jadwal
                            </a>
                        </li>
                    <?php elseif (Yii::$app->user->identity->isPetugas()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['peminjaman/index']) ?>">
                                <i class="fas fa-clipboard-list me-1"></i>Kelola Peminjaman
                            </a>
                        </li>
                        <!-- MENU MANAJEMEN RUANG DIHAPUS UNTUK PETUGAS -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['jadwal/index']) ?>">
                                <i class="fas fa-calendar-alt me-1"></i>Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['laporan/index']) ?>">
                                <i class="fas fa-chart-bar me-1"></i>Laporan
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['peminjaman/create']) ?>">
                                <i class="fas fa-plus-circle me-1"></i>Ajukan Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['peminjaman/index']) ?>">
                                <i class="fas fa-history me-1"></i>Status Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['jadwal/index']) ?>">
                                <i class="fas fa-calendar-alt me-1"></i>Jadwal Ruang
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= Url::to(['site/logout']) ?>" data-method="post">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout (<?= Yii::$app->user->identity->username ?>)
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['site/login']) ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['user/register']) ?>">
                            <i class="fas fa-user-plus me-1"></i>Registrasi
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-container">
    <div class="content-wrapper">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (Yii::$app->session->hasFlash('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?= Yii::$app->session->getFlash('warning') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="row">
        <div class="col-md-6">
            <h5><i class="fas fa-school me-2"></i>Sistem Peminjaman Ruang</h5>
            <p class="mb-0">SMKN 1 Bantul - Kompetensi Keahlian RPL</p>
            <small>Teknologi Informasi dan Komunikasi</small>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-0">&copy; <?= date('Y') ?> SMKN 1 Bantul</p>
            <small>All rights reserved | Developed with Dimzlwy/Dimzxz
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading animation
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Improved form focus
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            control.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentElement) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });

        // Mobile menu improvement
        const navbarToggler = document.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                document.body.classList.toggle('menu-open');
            });
        }

        // Force white text in table headers
        const tableHeaders = document.querySelectorAll('table th, .table th');
        tableHeaders.forEach(header => {
            header.style.color = 'white !important';
            const links = header.querySelectorAll('a');
            links.forEach(link => {
                link.style.color = 'white !important';
            });
        });
    });

    // Improve mobile experience
    if (window.innerWidth <= 767) {
        // Add touch improvements
        document.addEventListener('touchstart', function() {}, { passive: true });
        
        // Prevent zoom on input focus (iOS)
        document.addEventListener('touchstart', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') {
                document.body.style.zoom = '100%';
            }
        });
    }
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>