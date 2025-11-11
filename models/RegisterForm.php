<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $role;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            [['username', 'email'], 'trim'],
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Username hanya boleh berisi huruf, angka, dan underscore.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Password tidak sama.'],
            
            // Role tidak required karena akan di-set otomatis
            ['role', 'safe'], // Safe untuk admin yang mengisi role
            
            // Validasi unique
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Username sudah digunakan.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Email sudah digunakan.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Ulangi Password',
            'role' => 'Role',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $this->password;
        
        // Tentukan role berdasarkan konteks
        if (Yii::$app->user->isGuest) {
            // Registrasi public - otomatis menjadi peminjam
            $user->role = User::ROLE_PEMINJAM;
        } else {
            // Admin yang membuat user - gunakan role dari form
            $user->role = $this->role ?? User::ROLE_PEMINJAM;
        }

        if ($user->save()) {
            return true;
        }

        // Jika ada error saat save, tambahkan ke model
        $this->addErrors($user->errors);
        return false;
    }

    /**
     * Get role options untuk form registrasi public
     */
    public function getRoleOptions()
    {
        // Untuk registrasi public, hanya tampilkan peminjam
        if (Yii::$app->user->isGuest) {
            return [
                User::ROLE_PEMINJAM => '👤 Peminjam',
            ];
        }
        
        // Untuk admin, tampilkan semua role
        return $this->getAdminRoleOptions();
    }

    /**
     * Get role options untuk admin (create user)
     */
    public function getAdminRoleOptions()
    {
        return [
            User::ROLE_ADMINISTRATOR => '👑 Administrator',
            User::ROLE_PETUGAS => '👨‍💼 Petugas',
            User::ROLE_PEMINJAM => '👤 Peminjam',
        ];
    }
}