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
class WasRiksaindex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    
    public static function tableName()
    {
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        if($var[2] % 2=='1'){
        $view_table='was.v_riksa_index_1';
        }else{
        $view_table='was.v_riksa_index_2';
        }
        return $view_table;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['tgl_sk_was_2a', 'created_time', 'updated_time'], 'safe'],
            [['id_irmud'], 'integer'],
            [['satker_terlapor_awal','nama_terlapor_awal','id_terlapor_awal','sumber_laporan','perihal_lapdu','nama_pelapor'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['id_terlapor'], 'string', 'max' => 16],
            [['status1','status2'], 'string', 'max' => 5],
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
