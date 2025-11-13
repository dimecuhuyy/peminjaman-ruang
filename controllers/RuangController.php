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

    protected function findModel($id)
    {
        if (($model = Ruang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Ruang tidak ditemukan.');
    }
}