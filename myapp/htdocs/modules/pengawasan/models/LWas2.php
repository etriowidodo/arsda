<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_2".
 *
 * @property string $id_l_was_2
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl
 * @property string $upload_file
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class LWas2 extends WasRecord
{
    
    public $no_register;
    public $inst_nama;
    public $sprint_lwas_2;
    public $no_sprint_lwas_2;
    public $tgl_sprint_lwas_2;
    public $ringkasan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['flag', 'created_by', 'updated_by'], 'integer'],
            [['id_register'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
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
            'id_l_was_2' => 'Id L Was 2',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl' => 'Tgl',
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
