<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.terlapor_was12".
 *
 * @property string $id_was_12
 * @property string $id_terlapor
 * @property string $nip
 * @property string $nrp_pegawai_terlapor
 * @property string $nama_pegawai_terlapor
 * @property string $pangkat_pegawai_terlapor
 * @property string $golongan_pegawai_terlapor
 * @property string $jabatan_pegawai_terlapor
 * @property string $satker_pegawai_terlapor
 * @property integer $created_by
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property string $created_ip
 * @property string $inst_satkerkd
 */
class terlaporWas12 extends \app\models\BaseModel
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.terlapor_was12';
    }

    /**
     * @inheritdoc
     */
     public $flag;
	 public $peg_nrp;
    public function rules()
    {
        return [
            //[['id_terlapor'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_12', 'inst_satkerkd'], 'string', 'max' => 25],
            [['id_terlapor'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 18],
            [['nrp_pegawai_terlapor'], 'string', 'max' => 10],
            [['nama_pegawai_terlapor', 'satker_pegawai_terlapor'], 'string', 'max' => 65],
            [['pangkat_pegawai_terlapor'], 'string', 'max' => 30],
            [['golongan_pegawai_terlapor'], 'string', 'max' => 50],
            [['jabatan_pegawai_terlapor'], 'string', 'max' => 100],
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
            'id_terlapor' => 'Id Terlapor',
            'nip' => 'Nip',
            'nrp_pegawai_terlapor' => 'Nrp Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'created_by' => 'Created By',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'created_ip' => 'Created Ip',
            'inst_satkerkd' => 'Inst Satkerkd',
        ];
    }

    /**
     * @inheritdoc
     * @return terlaporWas12Query the active query used by this AR class.
     */
   /*  public static function find()
    {
        return new terlaporWas12Query(get_called_class());
    } */
}
