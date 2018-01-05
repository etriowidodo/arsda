<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "saksi_internal".
 *
 * @property string $id_saksi_internal
 * @property string $nip
 * @property string $nama_saksi_internal
 * @property string $pangkat_saksi_internal
 * @property string $golongan_saksi_internal
 * @property string $jabatan_saksi_internal
 * @property string $inst_satkerkd
 * @property string $nrp_saksi_internal
 */
class SaksiInternalInspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.saksi_internal_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_saksi_internal'], 'integer'],
           // [['id_was'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 18],
            [['pangkat_saksi_internal'], 'string', 'max' => 30],
            [['nama_saksi_internal'], 'string', 'max' => 50],
            [['golongan_saksi_internal'], 'string', 'max' => 5],
            [['jabatan_saksi_internal'], 'string', 'max' => 65],
            [['nrp'], 'string', 'max' => 10],
            [['no_register'], 'string', 'max' => 25],
            [['created_by'], 'integer'],
            [['created_time'], 'safe'],
            [['created_ip'], 'string', 'max' => 15],
            [['id_tingkat','id_kejari','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_saksi_internal' => 'Id Saksi Internal',
            'nip' => 'Nip',
            'nama_saksi_internal' => 'Nama Saksi Internal',
            'pangkat_saksi_internal' => 'Pangkat Saksi Internal',
            'golongan_saksi_internal' => 'Golongan Saksi Internal',
            'jabatan_saksi_internal' => 'Jabatan Saksi Internal',
        ];
    }
}
