<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Peminjaman extends ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK = 'ditolak';

    public static function tableName()
    {
        return 'peminjaman';
    }

    public function rules()
    {
        return [
            [['ruang_id', 'tanggal_pinjam', 'jam_mulai', 'jam_selesai', 'deskripsi'], 'required'],
            [['user_id', 'ruang_id'], 'integer'],
            [['tanggal_pinjam', 'jam_mulai', 'jam_selesai', 'created_at', 'updated_at'], 'safe'],
            [['deskripsi', 'catatan'], 'string'],
            [['status'], 'string', 'max' => 20],
            [['kode_peminjaman'], 'string', 'max' => 20],
            ['tanggal_pinjam', 'validateTanggal'],
            ['jam_selesai', 'validateJam'],
            ['ruang_id', 'validateBookingConflict'],
        ];
    }

    /**
     * Validasi untuk mencegah double booking
     */
    public function validateBookingConflict($attribute, $params)
    {
        if (!$this->hasErrors() && $this->ruang_id && $this->tanggal_pinjam && $this->jam_mulai && $this->jam_selesai) {
            
            // Cek peminjaman yang sudah disetujui
            $query = self::find()
                ->where(['ruang_id' => $this->ruang_id])
                ->andWhere(['tanggal_pinjam' => $this->tanggal_pinjam])
                ->andWhere(['status' => self::STATUS_DISETUJUI])
                ->andWhere(['or',
                    ['and', 
                        ['<=', 'jam_mulai', $this->jam_mulai],
                        ['>=', 'jam_selesai', $this->jam_mulai]
                    ],
                    ['and',
                        ['<=', 'jam_mulai', $this->jam_selesai],
                        ['>=', 'jam_selesai', $this->jam_selesai]
                    ],
                    ['and',
                        ['>=', 'jam_mulai', $this->jam_mulai],
                        ['<=', 'jam_selesai', $this->jam_selesai]
                    ]
                ]);

            // Jika update, exclude current record
            if (!$this->isNewRecord) {
                $query->andWhere(['<>', 'id', $this->id]);
            }

            $conflictingBooking = $query->one();

            if ($conflictingBooking) {
                $this->addError($attribute, 
                    "❌ Ruang sudah dipesan pada jam {$conflictingBooking->jam_mulai} - {$conflictingBooking->jam_selesai}. " .
                    "Silakan pilih jam atau tanggal lain."
                );
                return;
            }

            // Cek conflict dengan jadwal reguler
            $conflictingJadwal = JadwalReguler::find()
                ->where(['id_room' => $this->ruang_id])
                ->andWhere(['nama_hari' => $this->getHariFromDate()])
                ->andWhere(['or',
                    ['and', 
                        ['<=', 'jam_mulai', $this->jam_mulai],
                        ['>=', 'jam_selesai', $this->jam_mulai]
                    ],
                    ['and',
                        ['<=', 'jam_mulai', $this->jam_selesai],
                        ['>=', 'jam_selesai', $this->jam_selesai]
                    ],
                    ['and',
                        ['>=', 'jam_mulai', $this->jam_mulai],
                        ['<=', 'jam_selesai', $this->jam_selesai]
                    ]
                ])
                ->one();

            if ($conflictingJadwal) {
                $this->addError($attribute, 
                    "❌ Ruang sudah terjadwal reguler pada jam {$conflictingJadwal->jam_mulai} - {$conflictingJadwal->jam_selesai}. " .
                    "Silakan pilih jam atau tanggal lain."
                );
            }
        }
    }

    /**
     * Get hari dari tanggal (Senin, Selasa, etc)
     */
    private function getHariFromDate()
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin', 
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $englishDay = date('l', strtotime($this->tanggal_pinjam));
        return $days[$englishDay] ?? $englishDay;
    }

    public function validateTanggal($attribute, $params)
    {
        if (strtotime($this->tanggal_pinjam) < strtotime(date('Y-m-d'))) {
            $this->addError($attribute, '❌ Tanggal peminjaman tidak boleh kurang dari hari ini.');
        }
    }

    public function validateJam($attribute, $params)
    {
        if ($this->jam_mulai && $this->jam_selesai) {
            if (strtotime($this->jam_selesai) <= strtotime($this->jam_mulai)) {
                $this->addError($attribute, '❌ Jam selesai harus setelah jam mulai.');
            }
            
            // Validasi jam operasional (07:00 - 17:00)
            if (strtotime($this->jam_mulai) < strtotime('07:00:00') || 
                strtotime($this->jam_selesai) > strtotime('17:00:00')) {
                $this->addError($attribute, '❌ Jam peminjaman hanya tersedia dari 07:00 hingga 17:00.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_peminjaman' => 'Kode Peminjaman',
            'user_id' => 'Peminjam',
            'ruang_id' => 'Ruang',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'deskripsi' => 'Keperluan',
            'status' => 'Status',
            'catatan' => 'Catatan',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRuang()
    {
        return $this->hasOne(Ruang::class, ['id' => 'ruang_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = Yii::$app->user->id;
                $this->status = self::STATUS_PENDING;
                $this->kode_peminjaman = $this->generateKodePeminjaman();
            }
            return true;
        }
        return false;
    }

    private function generateKodePeminjaman()
    {
        $last = self::find()->orderBy(['id' => SORT_DESC])->one();
        $nextId = $last ? $last->id + 1 : 1;
        return 'PINJ-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_DISETUJUI => 'Disetujui',
            self::STATUS_DITOLAK => 'Ditolak'
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusClass()
    {
        $classes = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_DISETUJUI => 'success',
            self::STATUS_DITOLAK => 'danger'
        ];
        return $classes[$this->status] ?? 'secondary';
    }

    /**
     * Cek ketersediaan ruang
     */
    public static function checkAvailability($ruang_id, $tanggal, $jam_mulai, $jam_selesai, $exclude_id = null)
    {
        // Cek peminjaman yang sudah disetujui
        $query = self::find()
            ->where(['ruang_id' => $ruang_id])
            ->andWhere(['tanggal_pinjam' => $tanggal])
            ->andWhere(['status' => self::STATUS_DISETUJUI])
            ->andWhere(['or',
                ['and', 
                    ['<=', 'jam_mulai', $jam_mulai],
                    ['>=', 'jam_selesai', $jam_mulai]
                ],
                ['and',
                    ['<=', 'jam_mulai', $jam_selesai],
                    ['>=', 'jam_selesai', $jam_selesai]
                ],
                ['and',
                    ['>=', 'jam_mulai', $jam_mulai],
                    ['<=', 'jam_selesai', $jam_selesai]
                ]
            ]);

        if ($exclude_id) {
            $query->andWhere(['<>', 'id', $exclude_id]);
        }

        $conflictingPeminjaman = $query->one();

        if ($conflictingPeminjaman) {
            return [
                'available' => false,
                'message' => "Sudah ada peminjaman pada jam {$conflictingPeminjaman->jam_mulai} - {$conflictingPeminjaman->jam_selesai}"
            ];
        }

        // Cek jadwal reguler
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin', 
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $englishDay = date('l', strtotime($tanggal));
        $hari = $days[$englishDay] ?? $englishDay;

        $conflictingJadwal = JadwalReguler::find()
            ->where(['id_room' => $ruang_id])
            ->andWhere(['nama_hari' => $hari])
            ->andWhere(['or',
                ['and', 
                    ['<=', 'jam_mulai', $jam_mulai],
                    ['>=', 'jam_selesai', $jam_mulai]
                ],
                ['and',
                    ['<=', 'jam_mulai', $jam_selesai],
                    ['>=', 'jam_selesai', $jam_selesai]
                ],
                ['and',
                    ['>=', 'jam_mulai', $jam_mulai],
                    ['<=', 'jam_selesai', $jam_selesai]
                ]
            ])
            ->one();

        if ($conflictingJadwal) {
            return [
                'available' => false,
                'message' => "Sudah ada jadwal reguler pada jam {$conflictingJadwal->jam_mulai} - {$conflictingJadwal->jam_selesai}"
            ];
        }

        return ['available' => true, 'message' => 'Ruang tersedia'];
    }
}