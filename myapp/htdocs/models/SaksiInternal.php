<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.saksi_internal".
 *
 * @property string $id_saksi_internal
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
class SaksiInternal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.saksi_internal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_saksi_internal'], 'required'],
            [['peg_jabatan', 'dugaan_pelaporan', 'was_9', 'was_11', 'was_13', 'ba_was_2', 'ba_was_3', 'ba_was_4', 'l_was_2', 'was_15', 'ba_was_5', 'ba_was_7', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_saksi_internal', 'id_register', 'peg_nik', 'peg_nip'], 'string', 'max' => 20],
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
            'id_saksi_internal' => 'Id Saksi Internal',
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
