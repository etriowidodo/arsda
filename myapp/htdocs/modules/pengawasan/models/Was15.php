<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_15".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_was15
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $kepada_was15
 * @property string $dari_was15
 * @property string $tgl_was15
 * @property string $no_was15
 * @property integer $sifat_was15
 * @property string $lampiran_was15
 * @property string $perihal_was15
 * @property string $isi_pelapor_was15
 * @property string $isi_permasalahan_was15
 * @property string $data_analisa_was15
 * @property string $kesimpulan_was15
 * @property string $pertimbangan_berat_was15
 * @property string $pertimbangan_ringan_was15
 * @property string $keputusan_was15
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $jbtn_penandatangan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 */
class Was15 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'sifat_was15', 'created_by'], 'integer'],
            [['tgl_was15', 'created_time','tanggal_saran_jamwas'], 'safe'],
            [['isi_pelapor_was15', 'isi_permasalahan_was15', 'data_analisa_was15', 'kesimpulan_was15', 'pertimbangan_berat_was15', 'pertimbangan_ringan_was15', 'keputusan_was15','saran_jamwas','perihal_was15'], 'string'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['kepada_was15', 'dari_was15', 'nama_penandatangan','upload_file'], 'string', 'max' => 100],
            [['no_was15', 'golongan_penandatangan'], 'string', 'max' => 50],
            [['lampiran_was15'], 'string', 'max' => 20],
            [['nip_penandatangan', 'pangkat_penandatangan'], 'string', 'max' => 30],
            [['jabatan_penandatangan', 'jbtn_penandatangan'], 'string', 'max' => 65],
            [['created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tingkat' => 'Id Tingkat',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'no_register' => 'No Register',
            'id_sp_was2' => 'Id Sp Was2',
            'id_ba_was2' => 'Id Ba Was2',
            'id_l_was2' => 'Id L Was2',
            'id_was15' => 'Id Was15',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'kepada_was15' => 'Kepada Was15',
            'dari_was15' => 'Dari Was15',
            'tgl_was15' => 'Tgl Was15',
            'no_was15' => 'No Was15',
            'sifat_was15' => 'Sifat Was15',
            'lampiran_was15' => 'Lampiran Was15',
            'perihal_was15' => 'Perihal Was15',
            'isi_pelapor_was15' => 'Isi Pelapor Was15',
            'isi_permasalahan_was15' => 'Isi Permasalahan Was15',
            'data_analisa_was15' => 'Data Analisa Was15',
            'kesimpulan_was15' => 'Kesimpulan Was15',
            'pertimbangan_berat_was15' => 'Pertimbangan Berat Was15',
            'pertimbangan_ringan_was15' => 'Pertimbangan Ringan Was15',
            'keputusan_was15' => 'Keputusan Was15',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'jbtn_penandatangan' => 'Jbtn Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
