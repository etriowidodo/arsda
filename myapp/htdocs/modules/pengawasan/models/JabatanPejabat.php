<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.jabatan_pejabat".
 *
 * @property integer $id_jabatan_pejabat
 * @property integer $ref_jabatan_kd
 * @property string $unitkerja_kd
 * @property string $jabatan
 * @property string $di_level
 * @property string $bidang
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class JabatanPejabat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.jabatan_pejabat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_jabatan_kd', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['unitkerja_kd'], 'string', 'max' => 12],
            [['jabatan'], 'string', 'max' => 200],
            [['di_level'], 'string', 'max' => 4],
            [['bidang'], 'string', 'max' => 20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan_pejabat' => 'Id Jabatan Pejabat',
            'ref_jabatan_kd' => 'Ref Jabatan Kd',
            'unitkerja_kd' => 'Unitkerja Kd',
            'jabatan' => 'Jabatan',
            'di_level' => 'Di Level',
            'bidang' => 'Bidang',
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
