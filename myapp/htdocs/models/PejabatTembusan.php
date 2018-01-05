<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.pejabat_tembusan".
 *
 * @property string $id_pejabat_tembusan
 * @property integer $ref_jabatan_kd
 * @property string $unitkerja_kd
 * @property string $jabatan
 * @property integer $was_1
 * @property integer $was_2
 * @property integer $was_3
 * @property integer $sp_was_1
 * @property integer $was_9
 * @property integer $was_11
 * @property integer $was_13
 * @property integer $l_was_1
 * @property integer $ba_was_2
 * @property integer $was_27_kla
 * @property integer $sp_was_2
 * @property integer $was_10
 * @property integer $was_12
 * @property integer $ba_was_3
 * @property integer $ba_was_4
 * @property integer $l_was_2
 * @property integer $was_15
 * @property integer $was_27_inspek
 * @property integer $was_16a
 * @property integer $was_16b
 * @property integer $was_16c
 * @property integer $was_16d
 * @property integer $was_17
 * @property integer $was_18
 * @property integer $was_19a
 * @property integer $was_19b
 * @property integer $was_20a
 * @property integer $was_20b
 * @property integer $was_21
 * @property integer $ba_was_5
 * @property integer $ba_was_6
 * @property integer $ba_was_7
 * @property integer $ba_was_8
 * @property integer $ba_was_9
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
class PejabatTembusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pejabat_tembusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pejabat_tembusan'], 'required'],
            [['ref_jabatan_kd', 'was_1', 'was_2', 'was_3', 'sp_was_1', 'was_9', 'was_11', 'was_13', 'l_was_1', 'ba_was_2', 'was_27_kla', 'sp_was_2', 'was_10', 'was_12', 'ba_was_3', 'ba_was_4', 'l_was_2', 'was_15', 'was_27_inspek', 'was_16a', 'was_16b', 'was_16c', 'was_16d', 'was_17', 'was_18', 'was_19a', 'was_19b', 'was_20a', 'was_20b', 'was_21', 'ba_was_5', 'ba_was_6', 'ba_was_7', 'ba_was_8', 'ba_was_9', 'sk_was_2a', 'sk_was_2b', 'sk_was_2c', 'sk_was_3a', 'sk_was_3b', 'sk_was_3c', 'sk_was_4a', 'sk_was_4b', 'sk_was_4c', 'sk_was_4d', 'sk_was_4e', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_pejabat_tembusan'], 'string', 'max' => 20],
            [['unitkerja_kd'], 'string', 'max' => 12],
            [['jabatan'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pejabat_tembusan' => 'Id Pejabat Tembusan',
            'ref_jabatan_kd' => 'Ref Jabatan Kd',
            'unitkerja_kd' => 'Unitkerja Kd',
            'jabatan' => 'Jabatan',
            'was_1' => 'Was 1',
            'was_2' => 'Was 2',
            'was_3' => 'Was 3',
            'sp_was_1' => 'Sp Was 1',
            'was_9' => 'Was 9',
            'was_11' => 'Was 11',
            'was_13' => 'Was 13',
            'l_was_1' => 'L Was 1',
            'ba_was_2' => 'Ba Was 2',
            'was_27_kla' => 'Was 27 Kla',
            'sp_was_2' => 'Sp Was 2',
            'was_10' => 'Was 10',
            'was_12' => 'Was 12',
            'ba_was_3' => 'Ba Was 3',
            'ba_was_4' => 'Ba Was 4',
            'l_was_2' => 'L Was 2',
            'was_15' => 'Was 15',
            'was_27_inspek' => 'Was 27 Inspek',
            'was_16a' => 'Was 16a',
            'was_16b' => 'Was 16b',
            'was_16c' => 'Was 16c',
            'was_16d' => 'Was 16d',
            'was_17' => 'Was 17',
            'was_18' => 'Was 18',
            'was_19a' => 'Was 19a',
            'was_19b' => 'Was 19b',
            'was_20a' => 'Was 20a',
            'was_20b' => 'Was 20b',
            'was_21' => 'Was 21',
            'ba_was_5' => 'Ba Was 5',
            'ba_was_6' => 'Ba Was 6',
            'ba_was_7' => 'Ba Was 7',
            'ba_was_8' => 'Ba Was 8',
            'ba_was_9' => 'Ba Was 9',
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
