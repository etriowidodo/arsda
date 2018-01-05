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
class SPWas1Terlapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.vw_pegawai_terlapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'string', 'max' => 1],
            [['peg_nik','peg_nip','peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nama','pangkat','jabatan'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Pegawai',
            'peg_nik_baru' => 'Peg Nik Baru',
            'peg_nama' => 'Nama Pegawai',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            
        ];
    }
}
