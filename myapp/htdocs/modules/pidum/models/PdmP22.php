<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p22".
 *
 * @property string $id_p22
 * @property string $id_p19
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
 * @property PdmP19 $idP19
 * @property PdmP23[] $pdmP23s
 */
class PdmP22 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p22';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p22', 'no_surat', 'sifat', 'lampiran'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time','tgl_terima_berkas'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['lampiran'], 'string', 'max' => 16],
			[['id_pengantar'], 'string', 'max' => 135],
			[['id_p22'], 'string', 'max' => 121],
            [['no_surat'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['kepada'], 'string', 'max' => 128],
            [['di_kepada'], 'string', 'max' => 128],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_p22'], 'unique'],
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
            'id_p22' => 'Id P22',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'di_kepada',
            'id_penandatangan' => 'Id Penandatangan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP23s()
    {
        return $this->hasMany(PdmP23::className(), ['id_p22' => 'id_p22']);
    }
}
