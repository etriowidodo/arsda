<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p41_terdakwa".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p41
 * @property integer $status_rentut
 * @property string $no_reg_tahanan
 * @property integer $id_ms_rentut
 * @property integer $masa_percobaan_tahun
 * @property integer $masa_percobaan_bulan
 * @property integer $masa_percobaan_hari
 * @property integer $pidana_badan_tahun
 * @property integer $pidana_badan_bulan
 * @property integer $pidana_badan_hari
 * @property string $denda
 * @property integer $subsidair_tahun
 * @property integer $subsidair_bulan
 * @property integer $subsidair_hari
 * @property string $biaya_perkara
 * @property string $pidana_tambahan
 * @property integer $id_ms_pidana_pengawasan
 * @property integer $id_tindakan_bebas
 * @property string $tgl_baca_rentut
 * @property string $memberatkan
 * @property string $meringankan
 * @property string $tolak_ukur
 * @property integer $kurungan_bulan
 * @property integer $kurungan_hari
 * @property string $undang_undang
 * @property string $usuljpu
 * @property integer $no_urut_tersangka
 */
class PdmP41Terdakwa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p41_terdakwa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p41', 'status_rentut', 'no_reg_tahanan'], 'required'],
            [['status_rentut', 'id_ms_rentut', 'masa_percobaan_tahun', 'masa_percobaan_bulan', 'masa_percobaan_hari', 'pidana_badan_tahun', 'pidana_badan_bulan', 'pidana_badan_hari', 'subsidair_tahun', 'subsidair_bulan', 'subsidair_hari', 'id_ms_pidana_pengawasan', 'id_tindakan_bebas', 'kurungan_bulan', 'kurungan_hari', 'no_urut_tersangka'], 'integer'],
            [['denda', 'biaya_perkara'], 'number'],
            [['pidana_tambahan', 'memberatkan', 'meringankan', 'tolak_ukur', 'undang_undang', 'usuljpu'], 'string'],
            [['tgl_baca_rentut'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p41'], 'string', 'max' => 50],
            [['no_reg_tahanan'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p41' => 'No Surat P41',
            'status_rentut' => 'Status Rentut',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'id_ms_rentut' => 'Id Ms Rentut',
            'masa_percobaan_tahun' => 'Masa Percobaan Tahun',
            'masa_percobaan_bulan' => 'Masa Percobaan Bulan',
            'masa_percobaan_hari' => 'Masa Percobaan Hari',
            'pidana_badan_tahun' => 'Pidana Badan Tahun',
            'pidana_badan_bulan' => 'Pidana Badan Bulan',
            'pidana_badan_hari' => 'Pidana Badan Hari',
            'denda' => 'Denda',
            'subsidair_tahun' => 'Subsidair Tahun',
            'subsidair_bulan' => 'Subsidair Bulan',
            'subsidair_hari' => 'Subsidair Hari',
            'biaya_perkara' => 'Biaya Perkara',
            'pidana_tambahan' => 'Pidana Tambahan',
            'id_ms_pidana_pengawasan' => 'Id Ms Pidana Pengawasan',
            'id_tindakan_bebas' => 'Id Tindakan Bebas',
            'tgl_baca_rentut' => 'Tgl Baca Rentut',
            'memberatkan' => 'Memberatkan',
            'meringankan' => 'Meringankan',
            'tolak_ukur' => 'Tolak Ukur',
            'kurungan_bulan' => 'Kurungan Bulan',
            'kurungan_hari' => 'Kurungan Hari',
            'undang_undang' => 'Undang Undang',
            'usuljpu' => 'Usuljpu',
            'no_urut_tersangka' => 'No Urut Tersangka',
        ];
    }
}
