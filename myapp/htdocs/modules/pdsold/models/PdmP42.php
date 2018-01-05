<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p42".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p42
 * @property string $no_perkara
 * @property string $ket_saksi
 * @property string $ket_ahli
 * @property string $ket_surat
 * @property string $petunjuk
 * @property string $ket_tersangka
 * @property string $barbuk
 * @property string $unsur_dakwaan
 * @property string $memberatkan
 * @property string $meringankan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $uraian
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_penetapan_hakim
 * @property string $unsur_pasal
 * @property string $file_upload
 * @property string $tgl_baca_rentut
 */
class PdmP42 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p42';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p42', 'created_by', 'updated_by'], 'required'],
            [['ket_saksi', 'ket_ahli', 'ket_surat', 'petunjuk', 'ket_tersangka', 'barbuk', 'unsur_dakwaan', 'memberatkan', 'meringankan', 'uraian', 'unsur_pasal', 'file_upload'], 'string'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time', 'tgl_baca_rentut'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p42'], 'string', 'max' => 50],
            [['no_perkara'], 'string', 'max' => 32],
            [['id_penandatangan', 'no_penetapan_hakim'], 'string', 'max' => 20],
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
            'no_surat_p42' => 'No Surat P42',
            'no_perkara' => 'No Perkara',
            'ket_saksi' => 'Ket Saksi',
            'ket_ahli' => 'Ket Ahli',
            'ket_surat' => 'Ket Surat',
            'petunjuk' => 'Petunjuk',
            'ket_tersangka' => 'Ket Tersangka',
            'barbuk' => 'Barbuk',
            'unsur_dakwaan' => 'Unsur Dakwaan',
            'memberatkan' => 'Memberatkan',
            'meringankan' => 'Meringankan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'uraian' => 'Uraian',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_penetapan_hakim' => 'No Penetapan Hakim',
            'unsur_pasal' => 'Unsur Pasal',
            'file_upload' => 'File Upload',
            'tgl_baca_rentut' => 'Tgl Baca Rentut',
        ];
    }
}
