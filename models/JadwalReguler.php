<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class JadwalReguler extends ActiveRecord
{
    public static function tableName()
    {
        return 'jadwal_reguler';
    }

    public function rules()
    {
        return [
            [['nama_hari', 'id_room', 'id_user', 'jam_mulai', 'jam_selesai'], 'required'],
            [['id_room', 'id_user'], 'integer'],
            [['jam_mulai', 'jam_selesai', 'created_at', 'updated_at'], 'safe'],
            [['keterangan'], 'string'],
            [['nama_hari'], 'string', 'max' => 50],
            ['jam_selesai', 'validateJam'],
        ];
    }

    public function validateJam($attribute, $params)
    {
        if ($this->jam_mulai && $this->jam_selesai) {
            if (strtotime($this->jam_selesai) <= strtotime($this->jam_mulai)) {
                $this->addError($attribute, 'Jam selesai harus setelah jam mulai.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id_reguler' => 'ID',
            'nama_hari' => 'Hari',
            'id_room' => 'Ruang',
            'id_user' => 'User',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRuang()
    {
        return $this->hasOne(Ruang::class, ['id' => 'id_room']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function getHariList()
    {
        return [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        ];
    }

    public function getDisplayJam()
    {
        return date('H:i', strtotime($this->jam_mulai)) . ' - ' . date('H:i', strtotime($this->jam_selesai));
    }

    // ✅ TAMBAHKAN METHOD UNTUK SISTEM SESI
    public static function generateSesiOptions($type = 'mulai')
    {
        $sesi = [];
        $startTime = strtotime('07:00');
        $endTime = strtotime('17:00');
        
        $counter = 1;
        for ($time = $startTime; $time < $endTime; $time = strtotime('+45 minutes', $time)) {
            $jamMulai = date('H:i', $time);
            $jamSelesai = date('H:i', strtotime('+45 minutes', $time));
            
            if ($type === 'mulai') {
                $sesi[$jamMulai] = "Sesi $counter: $jamMulai - $jamSelesai";
            } else {
                $sesi[$jamSelesai] = "Sesi $counter: $jamMulai - $jamSelesai (Selesai: $jamSelesai)";
            }
            $counter++;
        }
        
        return $sesi;
    }

    public function getJumlahSesi()
    {
        if ($this->jam_mulai && $this->jam_selesai) {
            $mulai = strtotime($this->jam_mulai);
            $selesai = strtotime($this->jam_selesai);
            $diff = ($selesai - $mulai) / 60; // difference in minutes
            return ceil($diff / 45); // convert to 45-minute sessions
        }
        return 0;
    }

    public function getDurasiMenit()
    {
        return $this->getJumlahSesi() * 45;
    }

    public function getDisplayJamWithSesi()
    {
        return $this->getDisplayJam() . ' (' . $this->getJumlahSesi() . ' sesi)';
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
}