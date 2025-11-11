<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Manajemen Laporan';
?>
<div class="laporan-index">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i><?= Html::encode($this->title) ?>
                </h4>
                <div class="d-flex flex-wrap gap-2">
                    <?= Html::a('<i class="fas fa-plus me-1"></i>Buat Laporan', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                    <?= Html::a('<i class="fas fa-print me-1"></i>Print Semua', ['print-all'], [
                        'class' => 'btn btn-primary btn-sm',
                        'target' => '_blank'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped table-bordered mb-0'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 60px;'],
                            'contentOptions' => ['class' => 'text-center']
                        ],
                        
                        [
                            'attribute' => 'judul',
                            'contentOptions' => ['class' => 'text-wrap'],
                            'headerOptions' => ['class' => 'min-w-200']
                        ],
                        [
                            'attribute' => 'jenis',
                            'value' => function($model) {
                                return $model->getJenisLabel();
                            },
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 120px;']
                        ],
                        [
                            'attribute' => 'periode',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 120px;']
                        ],
                        [
                            'attribute' => 'petugas_id',
                            'value' => function($model) {
                                return $model->petugas ? $model->petugas->username : 'Unknown';
                            },
                            'label' => 'Petugas',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 120px;']
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 150px;']
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {print} {delete}',
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 130px;'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px;'],
                            'buttons' => [
                                'view' => function($url, $model) {
                                    return Html::a('<i class="fas fa-eye"></i>', $url, [
                                        'class' => 'btn btn-sm btn-info',
                                        'title' => 'Lihat Laporan',
                                    ]);
                                },
                                'print' => function($url, $model) {
                                    return Html::a('<i class="fas fa-print"></i>', ['print', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-primary',
                                        'title' => 'Print Laporan',
                                        'target' => '_blank'
                                    ]);
                                },
                                'delete' => function($url, $model) {
                                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                                        'class' => 'btn btn-sm btn-danger',
                                        'title' => 'Hapus Laporan',
                                        'data' => [
                                            'confirm' => 'Yakin hapus laporan ini?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive Design untuk Laporan */
.min-w-200 {
    min-width: 200px;
}

/* Tablet */
@media (max-width: 991px) {
    .laporan-index .card-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .laporan-index .card-header .gap-2 {
        margin-top: 10px;
    }
    
    .laporan-index .table-responsive {
        font-size: 0.9rem;
    }
}

/* Mobile */
@media (max-width: 767px) {
    .laporan-index .card-body {
        padding: 1rem;
    }
    
    .laporan-index .table-responsive {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .laporan-index .table th,
    .laporan-index .table td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
    
    .laporan-index .btn-sm {
        padding: 0.25rem 0.4rem;
        margin: 1px;
    }
    
    /* Stack buttons vertically in header */
    .laporan-index .card-header .d-flex.gap-2 {
        flex-direction: column;
        width: 100%;
    }
    
    .laporan-index .card-header .btn {
        width: 100%;
        margin-bottom: 5px;
    }
}

/* Small Mobile */
@media (max-width: 575px) {
    .laporan-index .card-body {
        padding: 0.75rem;
    }
    
    .laporan-index .table th,
    .laporan-index .table td {
        padding: 0.375rem;
        font-size: 0.8rem;
    }
    
    .laporan-index .table thead th {
        font-size: 0.8rem;
    }
    
    .laporan-index .btn-sm {
        font-size: 0.75rem;
        padding: 0.2rem 0.3rem;
    }
    
    /* Hide some columns on very small screens */
    .laporan-index .table td:nth-child(4), /* Periode column */
    .laporan-index .table th:nth-child(4) {
        display: none;
    }
}

/* Extra Small Mobile */
@media (max-width: 400px) {
    .laporan-index .table td:nth-child(5), /* Petugas column */
    .laporan-index .table th:nth-child(5) {
        display: none;
    }
    
    .laporan-index .table-responsive {
        font-size: 0.75rem;
    }
}
</style>