<?php

namespace app\modules\pidum\models;

use Yii;
use app\models\KpPegawai;
/**
 * This is the model class for table "pidum.pdm_jpu".
 *
 * @property string $id_perkara
 * @property string $id_jpu
 * @property string $nip
 * @property string $keterangan
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
class PdmJpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_jpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jpu'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_perkara'], 'string', 'max' => 32],
            [['id_jpu'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 64],
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
            'id_perkara' => 'Id Perkara',
            'id_jpu' => 'Id Jpu',
            'nip' => 'Nip',
            'keterangan' => 'Keterangan',
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
	
	public function getNamaPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), ['peg_nip' => 'nip']);
    }
}
