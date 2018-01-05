<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_20b_detail".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_was15
 * @property integer $id_was_20b
 * @property integer $id_was_20b_detail
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $keberatan
 * @property string $tanggapan
 */
class Was20bDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_20b_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_20b', 'id_was_20b_detail', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_20b', 'id_was_20b_detail', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4' , 'created_by', 'updated_by'], 'integer'],
            [['created_time'], 'safe'],
            [['keberatan', 'tanggapan'], 'string'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tingkat' => 'Id Tingkat',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'no_register' => 'No Register',
            'id_sp_was2' => 'Id Sp Was2',
            'id_ba_was2' => 'Id Ba Was2',
            'id_l_was2' => 'Id L Was2',
            'id_was15' => 'Id Was15',
            'id_was_20b' => 'Id Was 20b',
            'id_was_20b_detail' => 'Id Was 20b Detail',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'keberatan' => 'Keberatan',
            'tanggapan' => 'Tanggapan',
        ];
    }
}
