<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_sidang".
 *
 * @property string $tgl_sidang
 * @property string $id_p28
 * @property string $flag
 */
class PdmSidang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_sidang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_sidang'], 'required'],
            [['tgl_sidang'], 'safe'],
            [['id_p28'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tgl_sidang' => 'Tgl Sidang',
            'id_p28' => 'Id P28',
            'flag' => 'Flag',
        ];
    }
}
