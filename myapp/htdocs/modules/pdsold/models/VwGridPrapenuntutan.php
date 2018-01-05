<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_grid_prapenuntutan".
 *
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $assurat
 * @property string $tgl_terima
 * @property string $no_p16
 * @property string $tgl_p16
 * @property string $jpu
 * @property string $tersangka
 * @property string $id_sys_menu
 * @property string $url
 */
class VwGridPrapenuntutan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_grid_prapenuntutan';
    }

    /**
     * @inheritdoc
     */
	 //tambah rules status untuk pencarian #bowo #09 juni 2016
    public function rules()
    {  
        return [
            [['tgl_surat', 'tgl_terima', 'tgl_p16'], 'safe'],
            [['jpu', 'tersangka', 'data_berkas'], 'string'],
            [['id_perkara'], 'string', 'max' => 16],
            [['no_surat', 'no_p16', 'id_sys_menu'], 'string', 'max' => 32],
            [['assurat', 'status'], 'string', 'max' => 20] 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'assurat' => 'Assurat',
            'tgl_terima' => 'Tgl Terima',
            'no_p16' => 'No P16',
            'tgl_p16' => 'Tgl P16',
            'jpu' => 'Jpu',
            'tersangka' => 'Tersangka',
            'id_sys_menu' => 'Id Sys Menu',
            'url' => 'Url',
			'status' => 'Status Surat',
        ];
    }
}
