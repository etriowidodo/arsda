<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_3".
 *
 * @property string $id_ba_was_3
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $hari
 * @property string $tgl
 * @property string $tempat
 * @property integer $tunggal_jamak
 * @property integer $id_pemeriksa
 * @property integer $sebagai
 * @property integer $id_peran
 * @property string $jawaban_1
 * @property string $jawaban_2
 * @property string $pertanyaan_3
 * @property string $jawaban_3
 * @property string $jawaban_4
 * @property string $jawaban_5
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_3'], 'required'],
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['tunggal_jamak', 'id_pemeriksa', 'sebagai', 'id_peran', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['id_ba_was_3', 'id_register'], 'string', 'max' => 20],
            [['inst_satkerkd', 'hari'], 'string', 'max' => 10],
            [['tempat'], 'string', 'max' => 60],
            [['jawaban_1', 'jawaban_2', 'pertanyaan_3', 'jawaban_3', 'jawaban_4', 'jawaban_5'], 'string', 'max' => 2000],
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
            'id_ba_was_3' => 'Id Ba Was 3',
            'inst_satkerkd' => 'Inst Satkerkd',
            'id_register' => 'Id Register',
            'hari' => 'Hari',
            'tgl' => 'Tgl',
            'tempat' => 'Tempat',
            'tunggal_jamak' => 'Tunggal Jamak',
            'id_pemeriksa' => 'Id Pemeriksa',
            'sebagai' => 'Sebagai',
            'id_peran' => 'Id Peran',
            'jawaban_1' => 'Jawaban 1',
            'jawaban_2' => 'Jawaban 2',
            'pertanyaan_3' => 'Pertanyaan 3',
            'jawaban_3' => 'Jawaban 3',
            'jawaban_4' => 'Jawaban 4',
            'jawaban_5' => 'Jawaban 5',
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
