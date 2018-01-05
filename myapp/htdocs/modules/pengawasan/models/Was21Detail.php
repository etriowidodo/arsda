<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_21_detail".
 *
 * @property string $id_was_21_detail
 * @property string $id_was_21
 * @property integer $keberatan_tanggapan
 * @property string $isi
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was21Detail extends WasRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_21_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keberatan_tanggapan'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_21'], 'string', 'max' => 20],
            [['isi'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 18]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_21_detail' => 'Id Was 21 Detail',
            'id_was_21' => 'Id Was 21',
            'keberatan_tanggapan' => 'Keberatan Tanggapan',
            'isi' => 'Isi',
            'upload_file' => 'Upload File',
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
