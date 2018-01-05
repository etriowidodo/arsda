<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p19".
 *
 * @property string $id_p19
 * @property string $id_p24
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $petunjuk
 * @property string $id_penandatangan
 * @property string $id_perkara
 
 
 
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmP24 $idP24
 * @property PdmP20[] $pdmP20s
 * @property PdmP22[] $pdmP22s
 */
class PdmP19 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p19';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penandatangan','no_surat','kepada','di_kepada','lampiran','dikeluarkan','tgl_dikeluarkan','sifat'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time', 'tgl_terima'], 'safe'],
            [['petunjuk'], 'string'],
            [['file_upload_petunjuk_p19','file_upload_p19'], 'string','max' =>100],            
            [[ 'created_by', 'updated_by'], 'integer'],
            [['lampiran'], 'string', 'max' => 16],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_p19'], 'string', 'max' => 172],
            [['id_p18'], 'string', 'max' => 121],
			[['id_pengantar'], 'string', 'max' => 135],
            [['no_surat', 'di_kepada'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['is_split'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_p19'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p19' => 'Id P19',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'di_kepada',
            'petunjuk' => 'Petunjuk',
            'id_penandatangan' => 'Id Penandatangan',
            'file_upload_petunjuk_p19' => 'Unggah Berkas Petunjuk P19',
            'file_upload_p19' => 'Unggah Berkas P19',
            'is_split' => 'Split Berkas',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP20s()
    {
        return $this->hasMany(PdmP20::className(), ['id_p19' => 'id_p19']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP22s()
    {
        return $this->hasMany(PdmP22::className(), ['id_p19' => 'id_p19']);
    }
}
