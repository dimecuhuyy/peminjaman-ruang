<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Laporan;
use app\models\Peminjaman;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class LaporanController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Laporan::find()->with(['petugas']),
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Laporan();
        $model->petugas_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Laporan berhasil dibuat.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal membuat laporan. Silakan periksa data Anda.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $laporan = $this->findModel($id);
        $dataPeminjaman = $this->getDataPeminjaman($laporan->periode, $laporan->jenis);

        return $this->render('view', [
            'laporan' => $laporan,
            'dataPeminjaman' => $dataPeminjaman,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Laporan berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
        $laporan = $this->findModel($id);
        $dataPeminjaman = $this->getDataPeminjaman($laporan->periode, $laporan->jenis);

        // Render langsung tanpa layout
        return $this->render('print', [
            'laporan' => $laporan,
            'dataPeminjaman' => $dataPeminjaman,
        ]);
    }

    public function actionPrintAll()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Laporan::find()->with(['petugas']),
            'pagination' => false,
        ]);

        // Render langsung tanpa layout
        return $this->render('print-all', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportExcel($id)
    {
        $laporan = $this->findModel($id);
        $dataPeminjaman = $this->getDataPeminjaman($laporan->periode, $laporan->jenis);

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"laporan-{$laporan->judul}-" . date('Y-m-d') . ".xls\"");
        
        return $this->renderPartial('excel', [
            'laporan' => $laporan,
            'dataPeminjaman' => $dataPeminjaman,
        ]);
    }

    private function getDataPeminjaman($periode, $jenis)
    {
        $query = Peminjaman::find()
            ->with(['user', 'ruang'])
            ->orderBy(['tanggal_pinjam' => SORT_ASC]);

        // Filter berdasarkan jenis laporan
        switch ($jenis) {
            case 'harian':
                $query->andWhere(['tanggal_pinjam' => $periode]);
                break;
            case 'mingguan':
                if (strpos($periode, '-') !== false) {
                    list($year, $week) = explode('-', $periode);
                    $query->andWhere(['YEAR(tanggal_pinjam)' => $year])
                          ->andWhere(['WEEK(tanggal_pinjam)' => $week]);
                }
                break;
            case 'bulanan':
                if (strpos($periode, '-') !== false) {
                    list($year, $month) = explode('-', $periode);
                    $query->andWhere(['YEAR(tanggal_pinjam)' => $year])
                          ->andWhere(['MONTH(tanggal_pinjam)' => $month]);
                }
                break;
            case 'tahunan':
                $query->andWhere(['YEAR(tanggal_pinjam)' => $periode]);
                break;
        }

        return $query->all();
    }

    protected function findModel($id)
    {
        if (($model = Laporan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Laporan tidak ditemukan.');
    }
}