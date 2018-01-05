<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.dokumen".
 *
 * @property integer $no_register
 * @property string $irmud_pegasum_kepbang
 * @property string $id_inspektur
 * @property string $url
 * @property string $proses
 * @property integer $id_terlapor_awal
 * @property string $keterangan
 * @property string $upload_file
 * @property integer * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class DisposisiInspektur extends \yii\db\ActiveRecord
{
    // public $isi_disposisi;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_disposisi_inspektur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register'], 'required'],
            [['id_inspektur','created_by'], 'integer'],
            [['no_urut','id_irmud','urut_terlapor'], 'integer'], 
            [['status'], 'string', 'max' => 25],
            [['tanggal_disposisi','created_time'], 'safe'],
            [['isi_disposisi'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['file_inspektur'], 'string', 'max' => 100],
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
            'no_register' => 'Id Dokumen',
          //  'irmud_pegasum_kepbang' => 'Kd Dokumen',
            'id_inspektur' => 'Nm Dokumen',
            'isi_disposisi' => 'Url',
            'tanggal_disposisi' => 'Proses',
            /*'id_terlapor_awal' => 'id_terlapor_awal',*/
            // 'keterangan' => 'Keterangan',
            // 'upload_file' => 'Upload File',
            // 'created_by' => 'Created By',
            // 'created_ip' => 'Created Ip',
            // 'created_time' => 'Created Time',
            // 'updated_ip' => 'Updated Ip',
            // 'updated_by' => 'Updated By',
            // 'updated_time' => 'Updated Time',
        ];
    }
}
