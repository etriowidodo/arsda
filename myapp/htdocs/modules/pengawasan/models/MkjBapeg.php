<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.mkj_bapeg".
 *
 * @property string $id_mkj_bapeg
 * @property string $no_mkj_bapeg
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_mkj_bapeg
 * @property string $id_terlapor
 * @property integer $hasil_putusan
 * @property integer $id_peraturan
 * @property string $tingkat_kd
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class MkjBapeg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.mkj_bapeg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_mkj_bapeg', 'created_time', 'updated_time'], 'safe'],
            [['hasil_putusan', 'id_peraturan', 'created_by', 'updated_by'], 'integer'],
            [['no_mkj_bapeg'], 'string', 'max' => 50],
            [['id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['tingkat_kd'], 'string', 'max' => 4],
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
            'id_mkj_bapeg' => 'Id Mkj Bapeg',
            'no_mkj_bapeg' => 'No Mkj Bapeg',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_mkj_bapeg' => 'Tgl Mkj Bapeg',
            'id_terlapor' => 'Id Terlapor',
            'hasil_putusan' => 'Hasil Putusan',
            'id_peraturan' => 'Id Peraturan',
            'tingkat_kd' => 'Tingkat Kd',
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
