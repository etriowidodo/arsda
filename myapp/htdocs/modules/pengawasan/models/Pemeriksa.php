<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa".
 *
 * @property string $id_pemeriksa
 * @property string $id_register
 * @property integer $id_h_jabatan
 * @property string $peg_nik
 * @property integer $dugaan_pelaporan
 * @property integer $sp_was_1
 * @property integer $was_9
 * @property integer $was_13
 * @property integer $l_was_1
 * @property integer $ba_was_2
 * @property integer $was_27_kla
 * @property integer $sp_was_2
 * @property integer $was_10
 * @property integer $was_12
 * @property integer $ba_was_3
 * @property integer $l_was_2
 * @property integer $was_15
 * @property integer $was_27_inspek
 * @property integer $was_18
 * @property integer $ba_was_5
 * @property integer $ba_was_7
 * @property integer $sk_was_2a
 * @property integer $sk_was_2b
 * @property integer $sk_was_2c
 * @property integer $sk_was_3a
 * @property integer $sk_was_3b
 * @property integer $sk_was_3c
 * @property integer $sk_was_4a
 * @property integer $sk_was_4b
 * @property integer $sk_was_4c
 * @property integer $sk_was_4d
 * @property integer $sk_was_4e
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Pemeriksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pemeriksa_sp_was2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_sp_was2'], 'string', 'max' => 16],
            [['nip'], 'string', 'max' => 18],
            [['nrp','id_pemeriksa_sp_was2'], 'string', 'max' => 10],
            [['nama_pemeriksa','pangkat_pemeriksa'], 'string', 'max' => 30],
            [['jabatan_pemeriksa'], 'string', 'max' => 65],
            [['golongan_pemeriksa'], 'string', 'max' =>20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was1' => 'Id Pemeriksa',
            'id_pemeriksa_sp_was2' => 'Id H Jabatan',
            'nip' => 'Peg Nik',
            'nrp' => 'nrp',
            'nama_pemeriksa' => 'Nama',
            'pangkat_pemeriksa' => 'Pangkat',
            'jabatan_pemeriksa' => 'Jabata',
            'golongan_pemeriksa' => 'Golongan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
