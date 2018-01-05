<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.was_27_inspek_detail".
 *
 * @property string $id_was_27_inspek_detail
 * @property string $id_was_27_inspek
 * @property integer $rncn_henti_riksa_was_27_ins
 * @property string $saran
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was27InspekDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_inspek_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_27_inspek_detail'], 'required'],
            [['rncn_henti_riksa_was_27_ins', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_27_inspek_detail', 'id_was_27_inspek'], 'string', 'max' => 20],
            [['saran'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_27_inspek_detail' => 'Id Was 27 Inspek Detail',
            'id_was_27_inspek' => 'Id Was 27 Inspek',
            'rncn_henti_riksa_was_27_ins' => 'Rncn Henti Riksa Was 27 Ins',
            'saran' => 'Saran',
            'upload_file' => 'Upload File',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
