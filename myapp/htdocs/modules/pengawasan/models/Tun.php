<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.tun".
 *
 * @property string $id_tun
 * @property string $no_tun
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_tun
 * @property string $id_terlapor
 * @property integer $hasil_putusan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Tun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.tun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_tun', 'created_time', 'updated_time'], 'safe'],
            [['hasil_putusan', 'created_by', 'updated_by'], 'integer'],
            [['no_tun'], 'string', 'max' => 50],
            [['id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
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
            'id_tun' => 'Id Tun',
            'no_tun' => 'No Tun',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_tun' => 'Tgl Tun',
            'id_terlapor' => 'Id Terlapor',
            'hasil_putusan' => 'Hasil Putusan',
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
