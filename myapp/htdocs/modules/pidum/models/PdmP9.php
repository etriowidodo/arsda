<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p9".
 *
 * @property string $id_p9
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $kepada
 * @property string $di_kepada
 * @property string $tgl_panggilan
 * @property string $jam
 * @property string $tempat
 * @property string $menghadap
 * @property string $sebagai
 * @property integer $id_msstatusdata
 * @property string $id_panggilan_saksi
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
 

 * @property PdmPanggilanSaksi $idPanggilanSaksi
 * @property PdmSpdp $idPerkara
 */
class PdmP9 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p9';
    }
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p9', 'id_perkara'], 'required'],
            [['tgl_panggilan', 'jam', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
            [['id_p9', 'id_perkara', 'id_panggilan_saksi'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['kepada', 'di_kepada', 'sebagai'], 'string', 'max' => 128],
            [['tempat', 'menghadap', 'dikeluarkan'], 'string', 'max' => 64],
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
            'id_p9' => 'Id P9',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'tgl_panggilan' => 'Tgl Panggilan',
            'jam' => 'Jam',
            'tempat' => 'Tempat',
            'menghadap' => 'Menghadap',
            'sebagai' => 'Sebagai',
            'id_msstatusdata' => 'Id Msstatusdata',
            'id_panggilan_saksi' => 'Id Panggilan Saksi',
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
     		'id_perkara' => $id,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPanggilanSaksi()
    {
        return $this->hasOne(PdmPanggilanSaksi::className(), ['id_saksi_ahli' => 'id_panggilan_saksi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
