<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\JadwalReguler;
use app\models\Ruang;
use yii\helpers\ArrayHelper;

class JadwalController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'], // Semua user yang login bisa lihat jadwal
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
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
        // Get all jadwal reguler grouped by hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jadwalByHari = [];
        
        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = JadwalReguler::find()
                ->where(['nama_hari' => $hari])
                ->with(['ruang', 'user'])
                ->orderBy(['jam_mulai' => SORT_ASC])
                ->all();
        }

        $ruangList = Ruang::find()->all();

        return $this->render('index', [
            'jadwalByHari' => $jadwalByHari,
            'ruangList' => $ruangList,
            'hariList' => $hariList,
        ]);
    }

    public function actionCreate()
    {
        $model = new JadwalReguler();
        $model->id_user = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Jadwal reguler berhasil ditambahkan.');
            return $this->redirect(['index']);
        }

        $ruang = Ruang::find()->all();
        return $this->render('create', [
            'model' => $model,
            'ruang' => $ruang,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Jadwal reguler berhasil diupdate.');
            return $this->redirect(['index']);
        }

        $ruang = Ruang::find()->all();
        return $this->render('update', [
            'model' => $model,
            'ruang' => $ruang,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Jadwal reguler berhasil dihapus.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = JadwalReguler::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Jadwal reguler tidak ditemukan.');
    }
}