<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Peminjaman;
use app\models\Ruang;

class PeminjamanController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Hanya peminjam yang bisa create
                            if ($action->id === 'create') {
                                return Yii::$app->user->identity->isPeminjam();
                            }
                            // Semua user yang login bisa lihat index (tapi dengan data berbeda)
                            return true;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['approve', 'reject'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdministrator() || 
                                   Yii::$app->user->identity->isPetugas();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        if (Yii::$app->user->identity->isAdministrator() || Yii::$app->user->identity->isPetugas()) {
            $peminjaman = Peminjaman::find()
                ->with(['user', 'ruang'])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();
        } else {
            $peminjaman = Peminjaman::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->with(['ruang'])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'peminjaman' => $peminjaman,
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // Pastikan hanya peminjam yang bisa akses
        if (!Yii::$app->user->identity->isPeminjam()) {
            Yii::$app->session->setFlash('error', '❌ Anda tidak memiliki akses untuk mengajukan peminjaman.');
            return $this->redirect(['index']);
        }

        $model = new Peminjaman();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            // Validasi manual sebelum save
            if (!$model->validate()) {
                Yii::$app->session->setFlash('error', 'Terdapat kesalahan dalam data. Silakan periksa kembali.');
            } else {
                // Cek ketersediaan tambahan
                $availability = Peminjaman::checkAvailability(
                    $model->ruang_id,
                    $model->tanggal_pinjam,
                    $model->jam_mulai,
                    $model->jam_selesai
                );

                if (!$availability['available']) {
                    Yii::$app->session->setFlash('error', 
                        "❌ Gagal mengajukan peminjaman. " . $availability['message']
                    );
                } elseif ($model->save()) {
                    Yii::$app->session->setFlash('success', '✅ Pengajuan peminjaman berhasil dikirim!');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', '❌ Gagal mengajukan peminjaman. Silakan coba lagi.');
                }
            }
        }

        $ruang = Ruang::find()
            ->where(['status' => 'tersedia'])
            ->all();

        return $this->render('create', [
            'model' => $model,
            'ruang' => $ruang,
        ]);
    }

    public function actionApprove($id)
    {
        if (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdministrator() && !Yii::$app->user->identity->isPetugas())) {
            Yii::$app->session->setFlash('error', '❌ Anda tidak memiliki akses.');
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);
        
        // Cek ketersediaan sebelum approve
        $availability = Peminjaman::checkAvailability(
            $model->ruang_id,
            $model->tanggal_pinjam,
            $model->jam_mulai,
            $model->jam_selesai,
            $model->id
        );

        if (!$availability['available']) {
            // Auto reject jika tidak tersedia
            $model->status = Peminjaman::STATUS_DITOLAK;
            $model->catatan = "Ditolak otomatis: " . $availability['message'];
            $model->save();
            
            Yii::$app->session->setFlash('error', 
                "❌ Peminjaman otomatis ditolak. " . $availability['message']
            );
            return $this->redirect(['index']);
        }

        $model->status = Peminjaman::STATUS_DISETUJUI;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', '✅ Peminjaman berhasil disetujui.');
        } else {
            Yii::$app->session->setFlash('error', '❌ Gagal menyetujui peminjaman.');
        }

        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        if (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdministrator() && !Yii::$app->user->identity->isPetugas())) {
            Yii::$app->session->setFlash('error', '❌ Anda tidak memiliki akses.');
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);
        $model->status = Peminjaman::STATUS_DITOLAK;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', '✅ Peminjaman berhasil ditolak.');
        } else {
            Yii::$app->session->setFlash('error', '❌ Gagal menolak peminjaman.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Peminjaman::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Peminjaman tidak ditemukan.');
    }
}