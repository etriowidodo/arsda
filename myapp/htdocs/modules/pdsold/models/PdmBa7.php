<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba7".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba7
 * @property string $tgl_dikeluarkan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_surat_t7
 * @property string $kepala_rutan
 * @property string $nama_tersangka_ba4
 * @property string $upload_file
 */
class PdmBa7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba7', 'created_by', 'updated_by', 'no_surat_t7'], 'required'],
            [['tgl_ba7', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['upload_file'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_surat_t7'], 'string', 'max' => 50],
            [['kepala_rutan'], 'string', 'max' => 64],
            [['nama_tersangka_ba4'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba7' => 'Tgl Ba7',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_surat_t7' => 'No Surat T7',
            'kepala_rutan' => 'Kepala Rutan',
            'nama_tersangka_ba4' => 'Nama Tersangka Ba4',
            'upload_file' => 'Upload File',
        ];
    }
}
