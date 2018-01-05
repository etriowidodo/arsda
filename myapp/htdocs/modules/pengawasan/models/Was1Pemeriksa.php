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
class Was1Pemeriksa extends \yii\db\ActiveRecord
{
    public $nama_penandatangan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pemeriksa'], 'string', 'max' => 1],
            [['nip','peg_nik_baru'], 'string', 'max' => 18],
            [['akronim'], 'string', 'max' => 20],
            [['nama_pemeriksa','pangkat'], 'string', 'max' => 30],
            [['golongan','jabatan'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pemeriksa' => 'Id Pemeriksa',
            'nip' => 'Peg Nik',
            'peg_nik_baru' => 'Peg Nik Baru',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'akronim' => 'Akronim',
            'pangkat' => 'Pangkat',
            'golongan' => 'Golongan',
            'jabatan' => 'Jabatan',
            
        ];
    }
}
