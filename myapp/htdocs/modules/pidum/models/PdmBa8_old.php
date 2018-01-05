<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba8".
 *
 * @property string $id_ba8
 * @property string $id_perkara
 * @property string $tgl_surat
 * @property string $id_tersangka
 * @property string $uraian
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property MsTersangka $idTersangka
 */
class PdmBa8 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba8';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba8'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['uraian'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_ba8', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
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
            'id_ba8' => 'Id Ba8',
            'id_perkara' => 'Id Perkara',
            'tgl_surat' => 'Tgl Surat',
            'id_tersangka' => 'Id Tersangka',
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
    public function getIdTersangka()
    {
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }
}
