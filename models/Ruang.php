<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Ruang extends ActiveRecord
{
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_TIDAK_TERSEDIA = 'tidak_tersedia';

    public static function tableName()
    {
        return 'ruang';
    }

    public function rules()
    {
        return [
            [['kode_ruang', 'nama_ruang', 'kapasitas'], 'required'],
            [['kapasitas'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_ruang'], 'string', 'max' => 20],
            [['nama_ruang'], 'string', 'max' => 100],
            [['kode_ruang'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_ruang' => 'Kode Ruang',
            'nama_ruang' => 'Nama Ruang',
            'kapasitas' => 'Kapasitas',
            'status' => 'Status',
        ];
    }

    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_TERSEDIA => 'Tersedia',
            self::STATUS_TIDAK_TERSEDIA => 'Tidak Tersedia'
        ];
        return $statuses[$this->status] ?? $this->status;
    }
}