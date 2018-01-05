<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa_was12".
 *
 * @property string $id_was_12
 * @property integer $id_pemeriksa_was12
 * @property string $nip
 * @property string $nrp
 * @property string $nama_pemeriksa
 * @property string $pangkat_pemeriksa
 * @property string $nrp_pemeriksa
 * @property string $jabatan_pemeriksa
 * @property string $golongan_pemeriksa
 * @property string $no_surat_was10
 * @property string $pegawai_terlapor
 * @property string $hari_pemeriksaan
 * @property string $tanggal_pemeriksaan
 * @property string $jam_pemeriksaan
 * @property string $id_sp_was1
 * @property integer $created_by
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property string $created_ip
 */
class PemeriksaWas12 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
	 public $flag;
    public static function tableName()
    {
        return 'was.pemeriksa_was12';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_pemeriksa_was12'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['tanggal_pemeriksaan', 'jam_pemeriksaan', 'created_time', 'updated_time'], 'safe'],
            [['id_was_12', 'no_surat_was10'], 'string', 'max' => 25],
            [['nip'], 'string', 'max' => 18],
			[[ 'id_pemeriksa_was12'], 'string', 'max' => 16],
			[['nrp', 'nrp_pemeriksa'], 'string', 'max' => 10],
            [['jabatan_pemeriksa', 'pangkat_pemeriksa','pegawai_terlapor','tempat_pemeriksaan'], 'string', 'max' => 65],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
            [['hari_pemeriksaan'], 'string', 'max' => 6],
			[['nama_pemeriksa'], 'string', 'max' => 100],
            //[['id_sp_was1'], 'string', 'max' => 16],
            [['updated_ip', 'created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_12' => 'Id Was 12',
            'id_pemeriksa_was12' => 'Id Pemeriksa Was12',
            'nip' => 'Nip',
            'nrp' => 'Nrp',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'nrp_pemeriksa' => 'Nrp Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
            'no_surat_was10' => 'No Surat Was10',
            'pegawai_terlapor' => 'Pegawai Terlapor',
            'hari_pemeriksaan' => 'Hari Pemeriksaan',
            'tanggal_pemeriksaan' => 'Tanggal Pemeriksaan',
            'jam_pemeriksaan' => 'Jam Pemeriksaan',
            'id_sp_was1' => 'Id Sp Was1',
            'created_by' => 'Created By',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'created_ip' => 'Created Ip',
        ];
    }
}
