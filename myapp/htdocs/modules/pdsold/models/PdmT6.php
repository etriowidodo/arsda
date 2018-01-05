<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t6".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t6
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $id_tersangka
 * @property string $alasan
 * @property string $karena
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmT6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t6';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_t6', 'created_by', 'updated_by'], 'required'],
            [['alasan', 'karena'], 'string'],
            [['tgl_mulai', 'tgl_selesai', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['lampiran'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t6'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'id_tersangka', 'dikeluarkan'], 'string', 'max' => 64],
            [['upload_file'], 'string', 'max' => 256],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_t6' => 'No Surat T6',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'id_tersangka' => 'Id Tersangka',
            'alasan' => 'Alasan',
            'karena' => 'Karena',
            'tgl_mulai' => 'Tgl Mulai',
            'tgl_selesai' => 'Tgl Selesai',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
