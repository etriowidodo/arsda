<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_amar_putusp29".
 *
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property integer $id_ms_rentut
 * @property integer $bulan_kurung
 * @property integer $hari_kurung
 * @property integer $tahun_coba
 * @property integer $bulan_coba
 * @property integer $hari_coba
 * @property integer $tahun_badan
 * @property integer $bulan_badan
 * @property integer $hari_badan
 * @property string $denda
 * @property string $biaya_perkara
 * @property integer $tahun_sidair
 * @property integer $bulan_sidair
 * @property integer $hari_sidair
 * @property string $pidana_tambahan
 * @property integer $id_ms_pidanapengawasan
 * @property string $flag
 */
class PdmAmarPutusP29 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_amar_putusp29';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_amar'], 'required'],
            [['id_ms_rentut', 'bulan_kurung', 'hari_kurung', 'tahun_coba', 'bulan_coba', 'hari_coba', 'tahun_badan', 'bulan_badan', 'hari_badan', 'tahun_sidair', 'bulan_sidair', 'hari_sidair', 'id_ms_pidanapengawasan'], 'integer'],
            [['denda', 'biaya_perkara'], 'number'],
            [['pidana_tambahan'], 'string'],
            [['is_surat'], 'string', 'max' => 5],
            [['id_amar', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_amar' => 'Id Amar',
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'id_ms_rentut' => 'Id Ms Rentut',
            'bulan_kurung' => 'Bulan Kurung',
            'hari_kurung' => 'Hari Kurung',
            'tahun_coba' => 'Tahun Coba',
            'bulan_coba' => 'Bulan Coba',
            'hari_coba' => 'Hari Coba',
            'tahun_badan' => 'Tahun Badan',
            'bulan_badan' => 'Bulan Badan',
            'hari_badan' => 'Hari Badan',
            'denda' => 'Denda',
            'biaya_perkara' => 'Biaya Perkara',
            'tahun_sidair' => 'Tahun Sidair',
            'bulan_sidair' => 'Bulan Sidair',
            'hari_sidair' => 'Hari Sidair',
            'pidana_tambahan' => 'Pidana Tambahan',
            'id_ms_pidanapengawasan' => 'Id Ms Pidanapengawasan',
            'is_surat' => 'Is Surat',
            'flag' => 'Flag',
        ];
    }
}
