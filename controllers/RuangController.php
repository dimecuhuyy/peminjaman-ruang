<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Ruang;

class RuangController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // HANYA ADMINISTRATOR yang bisa akses manajemen ruang
                            return Yii::$app->user->identity->isAdministrator();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $ruang = Ruang::find()->all();
        return $this->render('index', [
            'ruang' => $ruang,
        ]);
    }

    public function actionCreate()
    {
        $model = new Ruang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Ruang berhasil ditambahkan.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Ruang berhasil diupdate.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Ruang berhasil dihapus.');
        return $this->redirect(['index']);
    }

    // =============================================
    // ACTION UNTEST TRANSACTION
    // =============================================

    public function actionTestCommit()
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            // Simpan nilai awal
            $model = $this->findModel(3);
            $namaAwal = $model->nama_ruang;
            
            // Langkah 2: Lakukan perubahan
            $model->nama_ruang = 'Ruang Test COMMIT';
            $model->save();
            
            // Langkah 3: Lihat perubahan sementara
            $modelSementara = $this->findModel(3);
            $namaSementara = $modelSementara->nama_ruang;
            
            // Langkah 4: Simpan permanen
            $transaction->commit();
            
            // Langkah 5: Verify perubahan tetap ada
            $modelAkhir = $this->findModel(3);
            $namaAkhir = $modelAkhir->nama_ruang;
            
            Yii::$app->session->setFlash('success', 
                "COMMIT Berhasil!<br>" .
                "Awal: {$namaAwal}<br>" .
                "Sementara: {$namaSementara}<br>" .
                "Akhir: {$namaAkhir}"
            );
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }
        
        return $this->redirect(['index']);
    }

    public function actionTestRollback()
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            // Simpan nilai awal
            $model = $this->findModel(3);
            $namaAwal = $model->nama_ruang;
            
            // Langkah 2: Lakukan perubahan
            $model->nama_ruang = 'Ruang Test ROLLBACK';
            $model->save();
            
            // Langkah 3: Lihat perubahan sementara
            $modelSementara = $this->findModel(3);
            $namaSementara = $modelSementara->nama_ruang;
            
            // Langkah 4: Batalkan perubahan
            $transaction->rollBack();
            
            // Langkah 5: Verify kembali ke nilai awal
            $modelAkhir = $this->findModel(3);
            $namaAkhir = $modelAkhir->nama_ruang;
            
            Yii::$app->session->setFlash('success', 
                "ROLLBACK Berhasil!<br>" .
                "Awal: {$namaAwal}<br>" .
                "Sementara: {$namaSementara}<br>" .
                "Akhir: {$namaAkhir}"
            );
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }
        
        return $this->redirect(['index']);
    }

    // =============================================
    // ACTION UNTEST TRANSACTION REAL WORLD
    // =============================================

    public function actionTestMultipleOperations()
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            // Multiple operations dalam satu transaksi
            $ruang1 = $this->findModel(1);
            $ruang2 = $this->findModel(2);
            
            $namaAwal1 = $ruang1->nama_ruang;
            $namaAwal2 = $ruang2->nama_ruang;
            
            // Update kedua ruang
            $ruang1->nama_ruang = 'Ruang 1 Updated';
            $ruang1->save();
            
            $ruang2->nama_ruang = 'Ruang 2 Updated'; 
            $ruang2->save();
            
            // Simulasikan validasi bisnis
            if ($ruang1->kapasitas < 0) {
                throw new \Exception('Kapasitas tidak boleh negatif');
            }
            
            // Commit jika semua berhasil
            $transaction->commit();
            
            Yii::$app->session->setFlash('success', 
                "Multiple Operations Berhasil!<br>" .
                "Ruang 1: {$namaAwal1} → {$ruang1->nama_ruang}<br>" .
                "Ruang 2: {$namaAwal2} → {$ruang2->nama_ruang}"
            );
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Transaksi dibatalkan: ' . $e->getMessage());
        }
        
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Ruang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Ruang tidak ditemukan.');
    }
}