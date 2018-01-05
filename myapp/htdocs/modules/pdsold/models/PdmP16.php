<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p16".
 *
 * @property string $id_p16
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 * @property PdmP17[] $pdmP17s
 * @property PdmT4[] $pdmT4s
 * @property PdmT5[] $pdmT5s
 */
class PdmP16 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'pidum.pdm_p16';
    }

    /**
     * @inheritdoc
     */
    
    
    public function rules()
    {
        return [
            [['id_penandatangan','dikeluarkan','no_surat','tgl_dikeluarkan'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p16'], 'string', 'max' => 56],
			[['id_perkara'], 'string', 'max' => 56],
            [['no_surat'], 'string', 'max' => 50],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
			[['nama'], 'string', 'max' => 200],
			[['file_upload'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_p16'], 'unique'],
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
            'id_p16' => 'Id P16',
            'id_perkara' => 'Id Perkara',
            'file_upload' => 'file_upload',
            'no_surat' => 'No Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
			'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP17s()
    {
        return $this->hasMany(PdmP17::className(), ['id_p16' => 'id_p16']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmT4s()
    {
        return $this->hasMany(PdmT4::className(), ['id_p16' => 'id_p16']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmT5s()
    {
        return $this->hasMany(PdmT5::className(), ['id_p16' => 'id_p16']);
    }
}
