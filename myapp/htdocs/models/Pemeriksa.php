<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.pemeriksa".
 *
 * @property string $id_pemeriksa
 * @property string $id_register
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $peg_gol
 * @property integer $peg_jabatan
 * @property string $peg_inst_satker
 * @property string $peg_unitkerja
 * @property string $phd_jns
 * @property string $tingkat_kd
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
 * @property integer $is_deleted
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
        return 'was.pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pemeriksa'], 'required'],
            [['peg_jabatan', 'dugaan_pelaporan', 'sp_was_1', 'was_9', 'was_13', 'l_was_1', 'ba_was_2', 'was_27_kla', 'sp_was_2', 'was_10', 'was_12', 'ba_was_3', 'l_was_2', 'was_15', 'was_27_inspek', 'was_18', 'ba_was_5', 'ba_was_7', 'sk_was_2a', 'sk_was_2b', 'sk_was_2c', 'sk_was_3a', 'sk_was_3b', 'sk_was_3c', 'sk_was_4a', 'sk_was_4b', 'sk_was_4c', 'sk_was_4d', 'sk_was_4e', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_pemeriksa', 'id_register', 'peg_nik', 'peg_nip'], 'string', 'max' => 20],
            [['peg_nrp'], 'string', 'max' => 10],
            [['peg_gol'], 'string', 'max' => 5],
            [['peg_inst_satker', 'peg_unitkerja'], 'string', 'max' => 12],
            [['phd_jns'], 'string', 'max' => 3],
            [['tingkat_kd'], 'string', 'max' => 4],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pemeriksa' => 'Id Pemeriksa',
            'id_register' => 'Id Register',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nrp' => 'Peg Nrp',
            'peg_gol' => 'Peg Gol',
            'peg_jabatan' => 'Peg Jabatan',
            'peg_inst_satker' => 'Peg Inst Satker',
            'peg_unitkerja' => 'Peg Unitkerja',
            'phd_jns' => 'Phd Jns',
            'tingkat_kd' => 'Tingkat Kd',
            'dugaan_pelaporan' => 'Dugaan Pelaporan',
            'sp_was_1' => 'Sp Was 1',
            'was_9' => 'Was 9',
            'was_13' => 'Was 13',
            'l_was_1' => 'L Was 1',
            'ba_was_2' => 'Ba Was 2',
            'was_27_kla' => 'Was 27 Kla',
            'sp_was_2' => 'Sp Was 2',
            'was_10' => 'Was 10',
            'was_12' => 'Was 12',
            'ba_was_3' => 'Ba Was 3',
            'l_was_2' => 'L Was 2',
            'was_15' => 'Was 15',
            'was_27_inspek' => 'Was 27 Inspek',
            'was_18' => 'Was 18',
            'ba_was_5' => 'Ba Was 5',
            'ba_was_7' => 'Ba Was 7',
            'sk_was_2a' => 'Sk Was 2a',
            'sk_was_2b' => 'Sk Was 2b',
            'sk_was_2c' => 'Sk Was 2c',
            'sk_was_3a' => 'Sk Was 3a',
            'sk_was_3b' => 'Sk Was 3b',
            'sk_was_3c' => 'Sk Was 3c',
            'sk_was_4a' => 'Sk Was 4a',
            'sk_was_4b' => 'Sk Was 4b',
            'sk_was_4c' => 'Sk Was 4c',
            'sk_was_4d' => 'Sk Was 4d',
            'sk_was_4e' => 'Sk Was 4e',
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
