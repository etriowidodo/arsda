<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p13".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p13
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $id_tersangka
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $ket_saksi
 * @property string $ket_ahli
 * @property string $ket_surat
 * @property string $petunjuk
 * @property string $ket_tersangka
 * @property string $hukum
 * @property string $yuridis
 * @property string $kesimpulan
 * @property string $saran
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmTahapDua $noRegisterPerkara
 */
class PdmP13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p13', 'sifat', 'lampiran', 'dikeluarkan', 'id_penandatangan', 'created_by', 'updated_by'], 'required'],
            [['tgl_sp', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['ket_saksi', 'ket_ahli', 'ket_surat', 'petunjuk', 'ket_tersangka', 'hukum', 'yuridis', 'kesimpulan', 'saran'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat_p13'], 'string', 'max' => 50],
            [['sifat'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'no_sp', 'dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 32],
            [['upload_file'], 'string', 'max' => 2000],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p13' => 'No Surat P13',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'id_tersangka' => 'Id Tersangka',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'ket_saksi' => 'Ket Saksi',
            'ket_ahli' => 'Ket Ahli',
            'ket_surat' => 'Ket Surat',
            'petunjuk' => 'Petunjuk',
            'ket_tersangka' => 'Ket Tersangka',
            'hukum' => 'Hukum',
            'yuridis' => 'Yuridis',
            'kesimpulan' => 'Kesimpulan',
            'saran' => 'Saran',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
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
    public function getNoRegisterPerkara()
    {
        return $this->hasOne(PdmTahapDua::className(), ['no_register_perkara' => 'no_register_perkara']);
    }
}