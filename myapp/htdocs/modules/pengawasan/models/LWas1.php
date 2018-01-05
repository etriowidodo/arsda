<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_1".
 *
 * @property string $id_l_was_1
 * @property string $no_register
 * @property string $inst_satkerkd
 * @property string $tgl
 * @property string $data_data
 * @property string $upload_file_data
 * @property string $analisa
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $tempat
 */
		   
class LWas1 extends \yii\db\ActiveRecord
{

   // public $no_register; 
   // public $inst_nama; 
   // public $ttd_peg_nama; 
   // public $ttd_peg_nip; 
   // public $ttd_peg_pangkat; 
   // public $ttd_peg_jabatan; 
   // public $jabatan; 
   // public $no_sp_was_1; 
   // public $tgl_sp_was_1; 
   // public $saran;
   // public $analisa;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_l_was_1'], 'required'],
            [['permasalahan_lwas1', 'data_lwas1', 'analis_lwas1', 'pendapat'], 'string'],
            // [['id_l_was_1'], 'string', 'max' => 16],
            [['no_register'], 'string', 'max' => 25],
            [['file_lwas1'], 'string', 'max' => 100],
            [['tanggal_lwas1'], 'safe'],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_l_was_1' => 'Id L Was 1',
            'no_register' => 'No Register',
            'permasalahan_lwas1' => 'Permasalahan Lwas1',
            'data_lwas1' => 'Data Lwas1',
            'analis_lwas1' => 'Analis Lwas1',
            'pendapat' => 'Pendapat',
        ];
    }
}
