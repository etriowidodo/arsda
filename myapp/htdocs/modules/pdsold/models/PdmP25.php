<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p25".
 *
 * @property string $id_p25
 * @property string $id_perkara
 * @property string $id_berkas
 * @property string $no_surat
 * @property string $id_tersangka
 * @property string $kegiatan
 * @property string $dikeluarkan
 * @property string $tgl_surat
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmP25 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p25';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p25', 'id_perkara', 'no_surat', 'dikeluarkan', 'tgl_surat', 'id_penandatangan'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p25', 'id_perkara', 'id_berkas'], 'string', 'max' => 16],
            [['no_surat', 'id_tersangka'], 'string', 'max' => 32],
            [['kegiatan'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['upload_file'], 'string', 'max' => 1000],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p25' => 'Id P25',
            'id_perkara' => 'Id Perkara',
            'id_berkas' => 'Id Berkas',
            'no_surat' => 'No Surat',
            'id_tersangka' => 'Id Tersangka',
            'kegiatan' => 'Kegiatan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_surat' => 'Tgl Surat',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
