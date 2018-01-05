<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tetap_hakim".
 *
 * @property string $id_thakim
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property integer $id_msstatusdata
 * @property string $lokasi
 * @property string $uraian
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
class PdmTetapHakim extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tetap_hakim';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_thakim'], 'required'],
            [['tgl_surat', 'tgl_terima', 'created_time', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
            [['uraian'], 'string'],
            [['id_thakim', 'id_perkara'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['lokasi'], 'string', 'max' => 128],
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
            'id_thakim' => 'Id Thakim',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_terima' => 'Tgl Terima',
            'id_msstatusdata' => 'Jnspengadilan',
            'lokasi' => 'Lokasi',
            'uraian' => 'Uraian',
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
