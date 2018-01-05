<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba3".
 *
 * @property string $id_ba3
 * @property string $id_perkara
 * @property string $tgl_pembuatan
 * @property string $jam
 * @property string $id_ms_saksi_ahli
 * @property string $id_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa3 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba3', 'id_perkara'], 'required'],
            [['tgl_pembuatan', 'jam', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_ba3', 'id_perkara'], 'string', 'max' => 16],
            [['id_ms_saksi_ahli'], 'string', 'max' => 20],
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
            'id_ba3' => 'Id Ba3',
            'tgl_pembuatan' => 'Tgl Pembuatan',
            'jam' => 'Jam',
            'id_ms_saksi_ahli' => 'Id Ms Saksi Ahli',
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
}
