<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sp_was_1".
 *
 * @property integer $id_sp_was1
 * @property string $nomor_sp_was1
 * @property string $tanggal_sp_was1
 * @property string $tanggal_mulai_sp_was1
 * @property string $tanggal_akhir_sp_was1
 * @property string $nip_penandatangan_sp_was1
 * @property string $nama_penandatangan_sp_was1
 * @property string $pangkat_penandatangan_sp_was1
 * @property string $golongan_penandatangan_sp_was1
 * @property string $jabatan_penandatangan_sp_was1
 * @property string $file_sp_was1
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property integer $updated_by
 * @property string $updated_ip
 * @property string $updated_time
 */
class SpWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $cari;
    public static function tableName()
    {
        return 'was.sp_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_sp_was1', 'tanggal_mulai_sp_was1', 'tanggal_akhir_sp_was1', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['nomor_sp_was1'], 'string', 'max' => 50],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['nama_penandatangan'], 'string', 'max' => 70],
            [['pangkat_penandatangan', 'file_sp_was1'], 'string', 'max' => 30],
            [['golongan_penandatangan'], 'string', 'max' => 8],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
			// [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
			// [['status_penandatangan'], 'string', 'max' => 15],
			[['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nomor_sp_was1' => 'Nomor Sp Was1',
            'tanggal_sp_was1' => 'Tanggal Sp Was1',
            'tanggal_mulai_sp_was1' => 'Tanggal Mulai Sp Was1',
            'tanggal_akhir_sp_was1' => 'Tanggal Akhir Sp Was1',
            'nip_penandatangan' => 'Nip Penandatangan Sp Was1',
            'nama_penandatangan' => 'Nama Penandatangan Sp Was1',
            'pangkat_penandatangan' => 'Pangkat Penandatangan Sp Was1',
            'golongan_penandatangan' => 'Golongan Penandatangan Sp Was1',
            'jabatan_penandatangan' => 'Jabatan Penandatangan Sp Was1',
            'file_sp_was1' => 'File Sp Was1',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
            'updated_time' => 'Updated Time',
        ];
    }
}
