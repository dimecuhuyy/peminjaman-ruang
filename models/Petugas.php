<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Petugas extends ActiveRecord
{
    public static function tableName()
    {
        return 'petugas';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'nama_lengkap'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255],
            [['nama_lengkap'], 'string', 'max' => 100],
            [['username', 'email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'nama_lengkap' => 'Nama Lengkap',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}