<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;

class SiteController extends Controller
{
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Debug: Log user info after login
            Yii::info("User logged in: " . Yii::$app->user->identity->username . " with role: " . Yii::$app->user->identity->role, 'login');
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

    public function actionTestLogin()
    {
        // Test manual login untuk debug
        $user = \app\models\User::findByUsername('petugas');
        
        if ($user) {
            echo "<h3>Debug User Info:</h3>";
            echo "User found:<br>";
            echo "ID: {$user->id}<br>";
            echo "Username: {$user->username}<br>";
            echo "Role: {$user->role}<br>";
            echo "Email: {$user->email}<br>";
            echo "Password in DB: {$user->password}<br>";
            echo "Password match 'petugas123': " . ($user->validatePassword('petugas123') ? 'YES' : 'NO') . "<br>";
            
            echo "<h3>Attempting Login:</h3>";
            // Try login
            if (Yii::$app->user->login($user)) {
                echo "Login SUCCESS!<br>";
                echo "Current user ID: " . Yii::$app->user->id . "<br>";
                echo "Current user username: " . Yii::$app->user->identity->username . "<br>";
                echo "Current user role: " . Yii::$app->user->identity->role . "<br>";
                echo "Current user email: " . Yii::$app->user->identity->email . "<br>";
            } else {
                echo "Login FAILED!<br>";
            }
        } else {
            echo "User 'petugas' not found!";
        }
    }

    public function actionTestDb()
    {
        try {
            $users = \app\models\User::find()->count();
            $ruang = \app\models\Ruang::find()->count();
            $peminjaman = \app\models\Peminjaman::find()->count();
            
            echo "✅ Database connected!<br>";
            echo "Users: $users<br>";
            echo "Ruang: $ruang<br>";
            echo "Peminjaman: $peminjaman<br>";
            
            // Test specific users
            echo "<br><strong>User Details:</strong><br>";
            $userList = \app\models\User::find()->all();
            foreach ($userList as $user) {
                echo "ID: {$user->id}, Username: {$user->username}, Role: {$user->role}, Email: {$user->email}<br>";
            }
            
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }
    }
}