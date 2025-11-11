<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Peminjaman;
use app\models\Ruang;
use app\models\User;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'logout'], // Hanya proteksi index dan logout
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        // Data untuk dashboard
        $data = [];

        if ($user->isAdministrator() || $user->isPetugas()) {
            // Untuk Admin & Petugas - tampilkan semua data
            $data['totalPeminjaman'] = Peminjaman::find()->count();
            $data['peminjamanPending'] = Peminjaman::find()->where(['status' => 'pending'])->count();
            $data['peminjamanDisetujui'] = Peminjaman::find()->where(['status' => 'disetujui'])->count();
            $data['totalRuang'] = Ruang::find()->count();
            $data['totalUsers'] = User::find()->count();
            
            // Data untuk chart (5 peminjaman terbaru)
            $data['recentPeminjaman'] = Peminjaman::find()
                ->with(['user', 'ruang'])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(5)
                ->all();

        } else {
            // Untuk Peminjam - hanya tampilkan data miliknya sendiri
            $userId = Yii::$app->user->id;
            
            $data['totalPeminjaman'] = Peminjaman::find()->where(['user_id' => $userId])->count();
            $data['peminjamanPending'] = Peminjaman::find()->where([
                'user_id' => $userId,
                'status' => 'pending'
            ])->count();
            $data['peminjamanDisetujui'] = Peminjaman::find()->where([
                'user_id' => $userId,
                'status' => 'disetujui'
            ])->count();
            $data['totalRuang'] = Ruang::find()->count();
            $data['totalUsers'] = null;
            
            // Data untuk chart (5 peminjaman terbaru milik user ini)
            $data['recentPeminjaman'] = Peminjaman::find()
                ->with(['user', 'ruang'])
                ->where(['user_id' => $userId])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(5)
                ->all();
        }

        return $this->render('index', [
            'data' => $data,
            'user' => $user,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}