<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.tembusan_was".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property string $is_inspektur_irmud_riksa
 * @property integer $id_tembusan_was
 * @property string $from_table
 * @property string $pk_in_table
 * @property string $tembusan
 * @property integer $is_order
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property integer $updated_ip
 * @property string $updated_by
 * @property string $updated_time
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 */
class TembusanWasx extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.tembusan_was';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'is_inspektur_irmud_riksa', 'id_tembusan_was', 'from_table'], 'required'],
            [['id_tembusan_was', 'is_order', 'created_by', 'updated_ip', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
            [['from_table', 'pk_in_table'], 'string', 'max' => 32],
            [['tembusan'], 'string', 'max' => 128],
            [['created_ip', 'updated_by'], 'string', 'max' => 15]
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
            'is_inspektur_irmud_riksa' => 'Is Inspektur Irmud Riksa',
            'id_tembusan_was' => 'Id Tembusan Was',
            'from_table' => 'From Table',
            'pk_in_table' => 'Pk In Table',
            'tembusan' => 'Tembusan',
            'is_order' => 'Is Order',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
        ];
    }
}
