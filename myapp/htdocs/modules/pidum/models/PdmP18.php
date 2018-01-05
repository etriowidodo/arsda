<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p18".
 *
 * @property string $id_p18
 * @property string $id_p24
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
 * @property PdmP24 $idP24
 */
class PdmP18 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p18';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id_p18',
                 'sifat',
                 'no_surat',
                 'tgl_dikeluarkan',
                 'dikeluarkan',
                 'lampiran',
                 'di_kepada',
                 'id_penandatangan',
                 'kepada'
                 ]
            , 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['lampiran'], 'string', 'max' => 16],
            [['id_p18'], 'string', 'max' => 121],
            [['id_berkas'], 'string', 'max' => 70],
            [['file_upload'], 'string', 'max' => 100],
            [['no_surat', 'di_kepada'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_p18'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p18' => 'Id P18',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'di_kepada',
            'id_penandatangan' => 'Id Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'file_upload'  => 'Unggah File'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP24()
    {
        return $this->hasOne(PdmP24::className(), ['id_p24' => 'id_p24']);
    }
}
