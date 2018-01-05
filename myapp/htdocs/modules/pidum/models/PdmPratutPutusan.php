<?php

namespace app\modules\pidum\models;

use Yii;
use app\models\KpInstSatker;

/**
 * This is the model class for table "pidum.pdm_pratut_putusan".
 *
 * @property string $id_pratut
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property integer $is_proses
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmPratutPutusan extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pratut_putusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['is_proses', 'created_by', 'updated_by'], 'integer'],
            [['id_pratut', 'id_perkara'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 64],
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
            'id_pratut' => 'Id Pratut',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'is_proses' => 'Is Proses',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    public function satker($kd_satker){
        $query = KpInstSatker::find()
                        ->where([])
                        ->all();
        return $query;
    }
}
