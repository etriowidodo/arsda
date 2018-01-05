<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_3".
 *
 * @property string $id_ba_was_3
 * @property string $inst_satkerkd
 * @property string $no_register
 * @property string $hari
 * @property string $tgl
 * @property string $tempat
 * @property integer $tunggal_jamak
 * @property integer $id_pemeriksa
 * @property integer $sebagai
 * @property integer $id_peran
 * @property string $bawas3_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas3Inspeksi extends \yii\db\ActiveRecord
{
    public $cari;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_3_inspeksi';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_ba_was3', 'created_time', 'updated_time'], 'safe'],
            [['sebagai', 'created_by', 'updated_by','id_ba_was3','id_sp_was2','id_was9','id_was10','id_pemeriksa'], 'integer'],
            [['satker_dimintai_keterangan','nama_dimintai_keterangan'], 'string', 'max' => 65],
            [['bawas3_file'], 'string', 'max' => 200],
            [['nip_dimintai_keterangan'], 'string', 'max' => 18],
            [['keterangan'], 'string', 'max' => 60],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['pangkat_dimintai_keterangan','jabatan_dimintai_keterangan'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_tingkat','id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['nrp_pemeriksa'], 'string', 'max' => 10],
            [['nip_pemeriksa'], 'string', 'max' => 18],
            [['golongan_pemeriksa'], 'string', 'max' => 50],
            [['jabatan_pemeriksa'], 'string', 'max' => 65],
            [['nama_pemeriksa','tempat_ba_was3'], 'string', 'max' => 100],
            [['id_terlapor_saksi'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was3' => 'Id Ba Was 3',
            'no_register' => 'Id Register',
            'tanggal_ba_was3' => 'Tgl',
            'tempat' => 'Tempat',
            'sebagai' => 'Sebagai',
            'bawas3_file' => 'Upload File',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
			

        ];
    }
}
