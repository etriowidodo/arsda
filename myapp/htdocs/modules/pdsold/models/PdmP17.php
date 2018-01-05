<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p17".
 *

 * @property string $id_p17
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $id_penandatangan
 * @property string $id_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmP16 $idP16
 */
class PdmP17  extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p17', 'no_surat', 'sifat','lampiran', 'id_perkara'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_surat',  'di_kepada'], 'string', 'max' => 50],
			[['id_perkara'], 'string', 'max' => 56],
			[['id_p17'], 'string', 'max' => 121],
            [['lampiran'], 'string', 'max' => 16],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
			[['file_upload'],'safe'],
			[['file_upload'],'file','extensions'=>['pdf'],'mimeTypes'=>['application/pdf']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p17' => 'Id P17',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di',
            'id_penandatangan' => 'Id Penandatangan',
            'id_perkara' => 'Id Perkara',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }


}
