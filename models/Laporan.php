<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Laporan extends ActiveRecord
{
    const JENIS_HARIAN = 'harian';
    const JENIS_MINGGUAN = 'mingguan';
    const JENIS_BULANAN = 'bulanan';
    const JENIS_TAHUNAN = 'tahunan';

    public static function tableName()
    {
        return 'laporan';
    }

    public function rules()
    {
        return [
            [['judul', 'jenis', 'periode', 'petugas_id'], 'required'],
            [['jenis'], 'string'],
            [['petugas_id'], 'integer'],
            [['created_at'], 'safe'],
            [['judul'], 'string', 'max' => 200],
            [['periode'], 'string', 'max' => 50],
            [['file_path'], 'string', 'max' => 255],
            ['petugas_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['petugas_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul' => 'Judul Laporan',
            'jenis' => 'Jenis Laporan',
            'periode' => 'Periode',
            'file_path' => 'File Path',
            'petugas_id' => 'Petugas',
            'created_at' => 'Tanggal Dibuat',
        ];
    }

    /**
     * Relasi ke User (karena petugas sekarang ada di tabel users)
     */
    public function getPetugas()
    {
        return $this->hasOne(User::class, ['id' => 'petugas_id']);
    }

    public function getJenisLabel()
    {
        $jenis = [
            self::JENIS_HARIAN => 'Harian',
            self::JENIS_MINGGUAN => 'Mingguan',
            self::JENIS_BULANAN => 'Bulanan',
            self::JENIS_TAHUNAN => 'Tahunan',
        ];
        return $jenis[$this->jenis] ?? $this->jenis;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}