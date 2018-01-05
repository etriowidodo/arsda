<?php

namespace app\modules\pidum\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pidum.pdm_t5".
 *
 * @property string $id_t5
 * @property string $id_p16
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $alasan
 * @property string $id_penandatangan
 
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmP16 $idP16
 */
class PdmT5 extends \app\models\BaseModel
{
    public $id_tersangka;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t5', 'no_surat', 'lampiran','sifat'], 'required'],
            [['tgl_dikeluarkan', 'tgl_resume','created_time', 'updated_time'], 'safe'],
            [['alasan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_t5', 'lampiran'], 'string', 'max' => 172],
			[['id_perpanjangan'], 'string', 'max' => 121],
            [['no_surat',  'di_kepada'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['kepada'], 'string', 'max' => 128],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_t5'], 'unique'],
			[['file_upload'],'safe'],
			[['file_upload'],'file','extensions'=>['pdf'],'mimeTypes'=>['application/pdf']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_t5'             => 'Id T5',
            'no_surat'          => 'No Surat',
            'sifat'             => 'Sifat',
            'lampiran'          => 'Lampiran',
            'tgl_dikeluarkan'   => 'Tgl Surat',
			'tgl_resume'        =>'Tgl Resume',
            'dikeluarkan'       => 'Dikeluarkan',
            'kepada'            => 'Kepada',
            'di_kepada'         => 'di_kepada',
            'alasan'            => 'Alasan',
            'id_penandatangan'  => 'Id Penandatangan',
            'created_by'        => 'Created By',
            'created_ip'        => 'Created Ip',
            'created_time'      => 'Created Time',
            'updated_ip'        => 'Updated Ip',
            'updated_by'        => 'Updated By',
            'updated_time'      => 'Updated Time',
			
        ];
    }

  
}
