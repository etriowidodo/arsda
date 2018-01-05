<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t4".
 *
 * @property string $id_t4
 * @property string $id_p16
 * @property integer $id_loktahanan
 * @property string $no_surat
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $id_penandatangan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $id_tersangka
 * @property string $lokasi
 *
 * @property MsLoktahanan $idLoktahanan
 * @property PdmP16 $idP16
 */
class PdmT4 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t4', 'no_surat', 'tgl_mulai', 'id_penandatangan'], 'required'],
            [['id_loktahanan', 'created_by', 'updated_by'], 'integer'],
            [['tgl_dikeluarkan', 'tgl_mulai', 'tgl_selesai', 'created_time', 'updated_time'], 'safe'],
            [['id_t4'], 'string', 'max' => 172],
            [['id_perpanjangan'], 'string', 'max' => 121],
            [['no_surat'], 'string', 'max' => 50],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['lokasi'], 'string', 'max' => 256],
            [['id_t4'], 'unique'],
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
            'id_t4' => 'Id T4',
            'id_loktahanan' => 'Id Loktahanan',
            'no_surat' => 'No Surat',
            'tgl_dikeluarkan' => 'Tgl Buat',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_mulai' => 'Tgl Mulai',
            'tgl_selesai' => 'Tgl Selesai',
            'id_penandatangan' => 'Id Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'lokasi' => 'Lokasi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLoktahanan()
    {
        return $this->hasOne(MsLoktahanan::className(), ['id_loktahanan' => 'id_loktahanan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getNamaTerdakwa()
    {
        return 'xxx';
    }
}
