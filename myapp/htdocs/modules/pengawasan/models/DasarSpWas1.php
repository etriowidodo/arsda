<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.dasar_sp_was1".
 *
 * @property integer $id_sp_was1
 * @property string $isi_dasar_sp_was1
 */
class DasarSpWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.dasar_sp_was1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isi_dasar_sp_was1'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_sp_was1', 'id_dasar_sp_was1'], 'integer'],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was1' => 'Id Sp Was1',
            'isi_dasar_sp_was1' => 'Isi Dasar Sp Was1',
        ];
    }
}
