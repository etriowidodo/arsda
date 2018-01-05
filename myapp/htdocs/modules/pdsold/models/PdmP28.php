<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p28".
 *
 * @property string $id_p28
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $no_rt2
 * @property string $no_rt3
 * @property string $no_rb1
 * @property string $no_rb2
 * @property string $hakim1
 * @property string $hakim2
 * @property string $hakim3
 * @property string $panitera
 * @property string $penasehat
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSidang[] $pdmSidangs
 */
class PdmP28 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p28';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p28'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_p28', 'id_perkara'], 'string', 'max' => 16],
            [['no_surat', 'no_rt2', 'no_rt3', 'no_rb1', 'no_rb2', 'panitera', 'penasehat'], 'string', 'max' => 32],
            [['hakim1', 'hakim2', 'hakim3'], 'string', 'max' => 20],
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
            'id_p28' => 'Id P28',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'no_rt2' => 'No Rt2',
            'no_rt3' => 'No Rt3',
            'no_rb1' => 'No Rb1',
            'no_rb2' => 'No Rb2',
            'hakim1' => 'Hakim1',
            'hakim2' => 'Hakim2',
            'hakim3' => 'Hakim3',
            'panitera' => 'Panitera',
            'penasehat' => 'Penasehat',
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
    public function getPdmSidangs()
    {
        return $this->hasMany(PdmSidang::className(), ['id_p28' => 'id_p28']);
    }
}