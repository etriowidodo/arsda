<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa_bawas2".
 *
 * @property string $id_ba_was_2
 * @property string $id_pemeriksa_bawas2
 * @property string $nip
 * @property string $nrp
 * @property string $nama_pemeriksa
 * @property string $pangkat_pemeriksa
 * @property string $nrp_pemeriksa
 * @property string $jabatan_pemeriksa
 * @property string $golongan_pemeriksa
 * @property string $pegawai_terlapor
 * @property string $hari_pemeriksaan
 * @property string $tanggal_pemeriksaan
 * @property string $jam_pemeriksaan
 * @property integer $created_by
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property string $created_ip
 * @property string $inst_satkerkd
 */
class pemeriksaBawas2 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
	 public $flag;
    public static function tableName()
    {
        return 'was.pemeriksa_bawas2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_pemeriksa_bawas2'], 'required'],
            [['tanggal_pemeriksaan', 'jam_pemeriksaan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_ba_was_2', 'inst_satkerkd'], 'string', 'max' => 25],
            [['id_pemeriksa_bawas2'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 18],
            [['nrp', 'nrp_pemeriksa'], 'string', 'max' => 10],
            [['nama_pemeriksa', 'pangkat_pemeriksa', 'jabatan_pemeriksa', 'pegawai_terlapor'], 'string', 'max' => 65],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
            [['hari_pemeriksaan'], 'string', 'max' => 6],
            [['updated_ip', 'created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was_2' => 'Id Ba Was 2',
            'id_pemeriksa_bawas2' => 'Id Pemeriksa Bawas2',
            'nip' => 'Nip',
            'nrp' => 'Nrp',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'nrp_pemeriksa' => 'Nrp Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
            'pegawai_terlapor' => 'Pegawai Terlapor',
            'hari_pemeriksaan' => 'Hari Pemeriksaan',
            'tanggal_pemeriksaan' => 'Tanggal Pemeriksaan',
            'jam_pemeriksaan' => 'Jam Pemeriksaan',
            'created_by' => 'Created By',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'created_ip' => 'Created Ip',
            'inst_satkerkd' => 'Inst Satkerkd',
        ];
    }
}
