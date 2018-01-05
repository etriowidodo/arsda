<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.barbuk".
 *
 * @property string $id_barbuk
 * @property string $id_register
 * @property string $nm_barbuk
 * @property string $jml
 * @property string $satuan
 * @property string $upload_file
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Barbuk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.barbuk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jml', 'flag', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_register'], 'string', 'max' => 16],
            [['nm_barbuk', 'upload_file'], 'string', 'max' => 200],
            [['satuan'], 'string', 'max' => 20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_barbuk' => 'Id Barbuk',
            'id_register' => 'Id Register',
            'nm_barbuk' => 'Nm Barbuk',
            'jml' => 'Jml',
            'satuan' => 'Satuan',
            'upload_file' => 'Upload File',
            'flag' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
