<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_data_l_was_1".
 *
 * @property integer $sebagai
 * @property string $id_peran
 * @property string $hasil
 */
class VDataLWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_data_l_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sebagai'], 'integer'],
            [['id_peran'], 'string', 'max' => 16],
            [['hasil'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sebagai' => 'Sebagai',
            'id_peran' => 'Id Peran',
            'hasil' => 'Hasil',
        ];
    }
}
