<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.pelapor".
 *
 * @property integer $id_pelapor
 * @property integer $id_register
 * @property string $nik
 * @property string $nama
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $pendidikan
 * @property string $agama
 * @property string $pekerjaan
 * @property integer $dugaan_pelaporan
 * @property integer $was_9
 * @property integer $was_11
 * @property integer $was_13
 * @property integer $ba_was_2
 * @property integer $ba_was_3
 * @property integer $ba_was_4
 * @property integer $l_was_2
 * @property integer $was_15
 * @property integer $ba_was_5
 * @property integer $ba_was_7
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Pelapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pelapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_register', 'dugaan_pelaporan', 'was_9', 'was_11', 'was_13', 'ba_was_2', 'ba_was_3', 'ba_was_4', 'l_was_2', 'was_15', 'ba_was_5', 'ba_was_7', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['tgl_lahir', 'created_time', 'updated_time'], 'safe'],
            [['nik'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 60],
            [['tempat_lahir', 'pekerjaan'], 'string', 'max' => 30],
            [['alamat'], 'string', 'max' => 200],
            [['pendidikan', 'agama'], 'string', 'max' => 10],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pelapor' => 'Id Pelapor',
            'id_register' => 'Id Register',
            'nik' => 'Nik',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'pendidikan' => 'Pendidikan',
            'agama' => 'Agama',
            'pekerjaan' => 'Pekerjaan',
            'dugaan_pelaporan' => 'Dugaan Pelaporan',
            'was_9' => 'Was 9',
            'was_11' => 'Was 11',
            'was_13' => 'Was 13',
            'ba_was_2' => 'Ba Was 2',
            'ba_was_3' => 'Ba Was 3',
            'ba_was_4' => 'Ba Was 4',
            'l_was_2' => 'L Was 2',
            'was_15' => 'Was 15',
            'ba_was_5' => 'Ba Was 5',
            'ba_was_7' => 'Ba Was 7',
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
