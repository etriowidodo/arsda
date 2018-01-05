<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_pelaksanaan_b22".
 *
 * @property string $id_b22
 * @property integer $id_msstatusdata
 */
class PdmPelaksanaanB22 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pelaksanaan_b22';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b22', 'id_msstatusdata'], 'required'],
            [['id_msstatusdata'], 'integer'],
            [['id_b22'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b22' => 'Id B22',
            'id_msstatusdata' => 'Id Msstatusdata',
        ];
    }
}
