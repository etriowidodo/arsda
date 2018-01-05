<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba_konsultasi".
 *
 * @property string $id_perkara
 * @property integer $id_ba_konsultasi
 * @property string $tgl_pelaksanaan
 * @property string $nip_jaksa
 * @property string $nama_jaksa
 * @property string $jabatan_jaksa
 * @property string $nip_penyidik
 * @property string $nama_penyidik
 * @property string $jabatan_penyidik
 * @property string $konsultasi_formil
 * @property string $konsultasi_materil
 * @property string $kesimpulan
 * @property string $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property string $updated_by
 * @property string $updated_time
 * @property string $no_surat
 */
class PdmBaKonsultasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba_konsultasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'id_ba_konsultasi'], 'required'],
            [['id_ba_konsultasi'], 'integer'],
            [['tgl_pelaksanaan', 'created_time', 'updated_time'], 'safe'],
            [['konsultasi_formil', 'konsultasi_materil', 'kesimpulan','file_upload'], 'string'],
            [['id_perkara'], 'string', 'max' => 56],
            [['nip_jaksa', 'nip_penyidik'], 'string', 'max' => 20],
            [['nama_jaksa', 'nama_penyidik'], 'string', 'max' => 128],
            [['jabatan_jaksa'], 'string', 'max' => 2000],
            [['jabatan_penyidik'], 'string', 'max' => 200],
            [['created_by', 'updated_ip', 'updated_by'], 'string', 'max' => 18],
            [['created_ip'], 'string', 'max' => 15],
            [['no_surat'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'id_ba_konsultasi' => 'Id Ba Konsultasi',
            'tgl_pelaksanaan' => 'Tgl Pelaksanaan',
            'nip_jaksa' => 'Nip Jaksa',
            'nama_jaksa' => 'Nama Jaksa',
            'jabatan_jaksa' => 'Jabatan Jaksa',
            'nip_penyidik' => 'Nip Penyidik',
            'nama_penyidik' => 'Nama Penyidik',
            'jabatan_penyidik' => 'Jabatan Penyidik',
            'konsultasi_formil' => 'Konsultasi Formil',
            'konsultasi_materil' => 'Konsultasi Materil',
            'kesimpulan' => 'Kesimpulan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_surat' => 'No Surat',
        ];
    }
}
