<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b21".
 *
 * @property string $id_b21
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $pertimbangan
 * @property string $untuk
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 */
class PdmB21 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public $wilayah;
    public $dikeluarkan;
    public $surat_jaksa_agung;
    public $tanggal_jaksa_agung;
    
    public static function tableName()
    {
        return 'pidum.pdm_b21';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b21'], 'required'],
            [['pertimbangan', 'untuk'], 'string'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_b21', 'id_perkara'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
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
            'id_b21' => 'Id B21',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'pertimbangan' => 'Pertimbangan',
            'untuk' => 'Untuk',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
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
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
