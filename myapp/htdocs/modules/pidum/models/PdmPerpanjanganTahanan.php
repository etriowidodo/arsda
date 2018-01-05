<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_perpanjangan_tahanan".
 *
 * @property string $id
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property string $terima_dari
 
 *
 * @property PdmSpdp $idPerkara
 */
class PdmPerpanjanganTahanan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_perpanjangan_tahanan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perpanjangan', 'id_perkara', 'no_surat', 'tgl_surat', 'tgl_terima', 'lokasi_penahanan', 'tgl_selesai', 'tgl_mulai', 'id_msloktahanan'], 'required'],
            [['tgl_surat'], 'safe'],
            [['tgl_terima'], 'safe'],
            [['tgl_mulai'], 'safe'],
            [['tgl_surat_penahanan','tgl_mulai_permintaan','tgl_selesai_permintaan'], 'safe'],
            [['tgl_selesai'], 'safe'],
            [['id_msloktahanan','persetujuan'], 'integer'],
            [['id_perpanjangan'], 'string', 'max' => 121],
            [['no_surat', 'no_surat_penahanan'], 'string', 'max' => 64],
            [['terima_dari', 'lokasi_penahanan'], 'string', 'max' => 255],
            [['no_surat'], 'string', 'max' => 64],
            [['id_perkara'], 'string', 'max' => 56],
            [['terima_dari'], 'string', 'max' => 255],
            [['tgl_terima'], 'compare','compareAttribute'=>'tgl_surat','operator'=>'>=','message'=>'Tanggal Terima tidak boleh lebih kecil dari Tanggal Permintaan'],
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
            'id' => 'ID',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_terima' => 'Tgl Terima',
            'terima_dari' => 'Terima Dari',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
