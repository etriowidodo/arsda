<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p24".
 *
 * @property string $id_p24
 * @property string $id_berkas
 * @property string $ket_saksi
 * @property string $ket_ahli
 * @property string $alat_bukti
 * @property string $benda_sitaan
 * @property string $ket_tersangka
 * @property string $fakta_hukum
 * @property string $yuridis
 * @property string $kesimpulan
 * @property string $pendapat
 * @property string $saran
 * @property string $petunjuk
 
 * @property string $id_p17
 * @property string $id_perkara
 
 * @property string $tgl_ba
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $id_ms_hasil_berkas
 *
 * @property PdmP18[] $pdmP18s
 * @property PdmP19[] $pdmP19s
 * @property PdmP21[] $pdmP21s
 * @property PdmBerkas $idBerkas
 * @property PdmMsHasilBerkas $idMsHasilBerkas
 * @property PdmSpdp $idPerkara
 */
class PdmP24 extends \app\models\BaseModel
{
    public $no_urut_romawi;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p24';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p24', 'tgl_ba', 'id_pendapat'], 'required'],
            [[ 'tgl_ba', 'created_time', 'updated_time'], 'safe'],
            [['ket_saksi', 'ket_ahli', 'alat_bukti', 'benda_sitaan', 'ket_tersangka', 'fakta_hukum', 'yuridis', 'kesimpulan', 'pendapat', 'id_pendapat',  'saran', 'petunjuk','file_upload'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p24'], 'string', 'max' => 135],
            [['id_hasil'], 'string', 'max' => 1],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_pengantar'], 'string', 'max' => 135],
            [['saran_disetujui'], 'string', 'max' => 1],
            [['petunjuk_disetujui'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_p24'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p24' => 'Id P24',
            'id_berkas' => 'Id Berkas',
            'ket_saksi' => 'Ket Saksi',
            'ket_ahli' => 'Ket Ahli',
            'alat_bukti' => 'Alat Bukti',
            'benda_sitaan' => 'Benda Sitaan',
            'ket_tersangka' => 'Ket Tersangka',
            'fakta_hukum' => 'Fakta Hukum',
            'yuridis' => 'Yuridis',
            'kesimpulan' => 'Kesimpulan',
            'pendapat' => 'Pendapat',
            'id_pendapat' => 'Id Pendapat',
            'saran' => 'Saran',
            'petunjuk' => 'Petunjuk',
            'id_p17' => 'Id P17',
            'tgl_ba' => 'Tgl Ba',
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
    public function getPdmP18s()
    {
        return $this->hasMany(PdmP18::className(), ['id_p24' => 'id_p24']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP19s()
    {
        return $this->hasMany(PdmP19::className(), ['id_p24' => 'id_p24']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP21s()
    {
        return $this->hasMany(PdmP21::className(), ['id_p24' => 'id_p24']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBerkas()
    {
        return $this->hasOne(PdmBerkas::className(), ['id_berkas' => 'id_berkas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    /**
     * @return \yii\db\ActiveQuery
     */

}
