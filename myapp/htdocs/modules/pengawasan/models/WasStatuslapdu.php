<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sk_was_2a".
 *
 * @property string $id_sk_was_2a
 * @property string $no_sk_was_2a
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $tgl_sk_was_2a
 * @property integer $ttd_sk_was_2a
 * @property string $id_terlapor
 * @property string $tingkat_kd
 * @property string $ttd_peg_nik
 * @property integer $ttd_id_jabatan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class WasStatuslapdu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    
    public static function tableName()
    {
        return 'was.status_lapdu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['tgl_sk_was_2a', 'created_time', 'updated_time'], 'safe'],
            // [['ttd_sk_was_2a', 'ttd_id_jabatan', 'created_by', 'updated_by'], 'integer'],
            [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
            [['no_register'], 'string', 'max' => 25],
            [['id_terlapor'], 'string', 'max' => 16],
            [['status'], 'string', 'max' => 5],
            // [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'is_inspektur_irmud_riksa' => 'Id Sk Was 2a',
            'no_register' => 'No Sk Was 2a',
            'id_terlapor' => 'Inst Satkerkd',
            'status' => 'Id Register',
            // 'created_by' => 'Created By',
            // 'created_ip' => 'Created Ip',
            // 'created_time' => 'Created Time',
            // 'updated_ip' => 'Updated Ip',
            // 'updated_by' => 'Updated By',
            // 'updated_time' => 'Updated Time',
        ];
    }
}
