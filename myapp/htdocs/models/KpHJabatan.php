<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_h_jabatan".
 *
 * @property integer $id
 * @property string $peg_nik
 * @property string $jabat_tmt
 * @property integer $ref_jabatan_kd
 * @property integer $jabat_jenisjabatan
 * @property string $jabat_kerjatmt
 * @property integer $jabat_status
 * @property string $jabat_eselon
 * @property string $jabat_instunitkerja
 * @property string $jabat_unitkerja
 * @property string $jabat_stsakhir
 * @property string $jabat_inst_deskripsi
 * @property string $jabat_jbt_deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpHJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_h_jabatan';
    }

    public static function primarykey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ref_jabatan_kd', 'jabat_jenisjabatan', 'jabat_status', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['jabat_tmt', 'jabat_kerjatmt', 'createdtime', 'updatedtime'], 'safe'],
            [['peg_nik'], 'string', 'max' => 20],
            [['jabat_eselon'], 'string', 'max' => 5],
            [['jabat_instunitkerja', 'jabat_unitkerja'], 'string', 'max' => 12],
            [['jabat_stsakhir'], 'string', 'max' => 1],
            [['jabat_inst_deskripsi', 'jabat_jbt_deskripsi'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peg_nik' => 'Peg Nik',
            'jabat_tmt' => 'Jabat Tmt',
            'ref_jabatan_kd' => 'Ref Jabatan Kd',
            'jabat_jenisjabatan' => 'Jabat Jenisjabatan',
            'jabat_kerjatmt' => 'Jabat Kerjatmt',
            'jabat_status' => 'Jabat Status',
            'jabat_eselon' => 'Jabat Eselon',
            'jabat_instunitkerja' => 'Jabat Instunitkerja',
            'jabat_unitkerja' => 'Jabat Unitkerja',
            'jabat_stsakhir' => 'Jabat Stsakhir',
            'jabat_inst_deskripsi' => 'Jabat Inst Deskripsi',
            'jabat_jbt_deskripsi' => 'Jabat Jbt Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
