<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\User;
use app\models\RegisterForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdministrator(); // Hanya admin
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        // Force role menjadi peminjam untuk registrasi public
        $model->role = User::ROLE_PEMINJAM;

        if ($model->load(Yii::$app->request->post())) {
            // Pastikan role tetap peminjam meskipun user mencoba mengubahnya
            $model->role = User::ROLE_PEMINJAM;

            if ($model->register()) {
                Yii::$app->session->setFlash('success', 'Registrasi berhasil! Silakan login.');
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $users = User::find()->all();
        return $this->render('index', [
            'users' => $users,
        ]);
    }

    public function actionCreate()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            // Untuk admin yang membuat user, izinkan semua role
            if ($model->register()) {
                Yii::$app->session->setFlash('success', 'User berhasil dibuat.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal membuat user. Silakan periksa data Anda.');
                Yii::error('Register error: ' . print_r($model->errors, true));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $model = new RegisterForm();

        // Set nilai awal dari user yang akan diupdate
        $model->username = $user->username;
        $model->email = $user->email;
        $model->role = $user->role;

        if ($model->load(Yii::$app->request->post())) {
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role = $model->role; // Pastikan role terupdate

            if (!empty($model->password)) {
                $user->password = $model->password;
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'User berhasil diupdate.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal mengupdate user.');
                Yii::error('Update user error: ' . print_r($user->errors, true));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionDelete($id)
    {
        // Jangan izinkan hapus diri sendiri
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Tidak dapat menghapus akun sendiri.');
            return $this->redirect(['index']);
        }

        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'User berhasil dihapus.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('User tidak ditemukan.');
    }
}
