<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_PEMINJAM = 'peminjam';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'role'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 20],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['role', 'in', 'range' => [self::ROLE_ADMINISTRATOR, self::ROLE_PETUGAS, self::ROLE_PEMINJAM]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function isAdministrator()
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    public function isPetugas()
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isPeminjam()
    {
        return $this->role === self::ROLE_PEMINJAM;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }

    public function getRoleLabel()
    {
        $roles = [
            self::ROLE_ADMINISTRATOR => 'Administrator',
            self::ROLE_PETUGAS => 'Petugas',
            self::ROLE_PEMINJAM => 'Peminjam'
        ];
        return $roles[$this->role] ?? $this->role;
    }

    public function getFormattedCreatedAt()
    {
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

    public function canBeDeleted()
    {
        return $this->id !== Yii::$app->user->id;
    }

    /**
     * Getter untuk nama_lengkap - digunakan untuk kompatibilitas dengan kode yang membutuhkan nama_lengkap
     * Karena di database tidak ada kolom nama_lengkap, kita gunakan username
     */
    public function getNama_lengkap()
    {
        return $this->username;
    }

    /**
     * Getter untuk nama lengkap dengan format yang lebih formal
     */
    public function getNamaLengkap()
    {
        return ucwords($this->username);
    }

    /**
     * Method untuk mendapatkan display name yang bisa digunakan di seluruh aplikasi
     */
    public function getDisplayName()
    {
        return $this->username;
    }

    /**
     * Method untuk kompatibilitas - jika ada kode yang memanggil $user->nama_lengkap
     */
    public function __get($name)
    {
        if ($name === 'nama_lengkap') {
            return $this->getNama_lengkap();
        }
        return parent::__get($name);
    }

    /**
     * Method untuk kompatibilitas - jika ada kode yang memeriksa isset($user->nama_lengkap)
     */
    public function __isset($name)
    {
        if ($name === 'nama_lengkap') {
            return true;
        }
        return parent::__isset($name);
    }
}