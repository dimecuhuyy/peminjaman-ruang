<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 10px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 6px; 
            text-align: left; 
        }
        .table th { 
            background-color: #4361ee; 
            color: white; 
        }
        .info { 
            margin-bottom: 20px; 
            padding: 10px; 
            background-color: #f8f9fa; 
            border-radius: 5px; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #666; 
        }
        .no-print { display: none; }
        .print-only { display: block; }
        @media print {
            .no-print { display: none; }
            .print-only { display: block; }
            body { margin: 0; }
            .header { border-bottom: 2px solid #000; }
        }
    </style>
</head>
<body>
    <?= $content ?>
    
    <div class="footer">
        <p>Dicetak dari Sistem Peminjaman Ruang SMKN 1 Bantul</p>
        <p>Tanggal cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>