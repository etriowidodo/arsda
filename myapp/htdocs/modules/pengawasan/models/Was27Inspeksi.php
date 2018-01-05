<?php

namespace app\modules\pengawasan\models;

use Yii;

class Was27Inspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was_27_inspeksi', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was_27_inspeksi', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'sifat_was_27', 'created_by', 'updated_by'], 'integer'],
            [['tgl_was_27', 'tgl_persetujuan_was_27', 'created_time', 'updated_time'], 'safe'],
            [['permasalahan_was_27', 'data_was_27', 'analisa_was_27', 'kesimpulan_was_27', 'rencana_penghentian_pemeriksaan_was_27', 'persetujuan_was_27'], 'string'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['kepada_was_27', 'dari_was_27'], 'string', 'max' => 100],
            [['no_was_27_inspeksi', 'perihal_was_27', 'nama_penandatangan'], 'string', 'max' => 50],
            [['lampiran_was_27'], 'string', 'max' => 20],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['jabatan_penandatangan'], 'string', 'max' => 65],
            [['file_was_27'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
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
            'id_was_27_inspeksi' => 'Id Was 27 Inspeksi',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'kepada_was_27' => 'Kepada Was 27',
            'dari_was_27' => 'Dari Was 27',
            'tgl_was_27' => 'Tgl Was 27',
            'no_was_27_inspeksi' => 'No Was 27 Inspeksi',
            'sifat_was_27' => 'Sifat Was 27',
            'lampiran_was_27' => 'Lampiran Was 27',
            'perihal_was_27' => 'Perihal Was 27',
            'permasalahan_was_27' => 'Permasalahan Was 27',
            'data_was_27' => 'Data Was 27',
            'analisa_was_27' => 'Analisa Was 27',
            'kesimpulan_was_27' => 'Kesimpulan Was 27',
            'rencana_penghentian_pemeriksaan_was_27' => 'Rencana Penghentian Pemeriksaan Was 27',
            'persetujuan_was_27' => 'Persetujuan Was 27',
            'tgl_persetujuan_was_27' => 'Tgl Persetujuan Was 27',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'file_was_27' => 'File Was 27',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
            'updated_time' => 'Updated Time',
        ];
    }
}
