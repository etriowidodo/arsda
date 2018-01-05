<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sk_was_4b".
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
 * @property integer $id_sk_was_4b
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $no_sk_was_4b
 * @property string $tgl_lapdu
 * @property string $pasal
 * @property string $waktu_kejadian
 * @property string $id_terlapor
 * @property string $nip_pegawai_terlapor
 * @property string $nrp_pegawai_terlapor
 * @property string $nama_pegawai_terlapor
 * @property string $pangkat_pegawai_terlapor
 * @property string $golongan_pegawai_terlapor
 * @property string $jabatan_pegawai_terlapor
 * @property string $satker_pegawai_terlapor
 * @property string $unit_kerja_terlapor
 * @property string $pangkat_pegawai_turun_terlapor
 * @property string $golongan_pegawai_turun_terlapor
 * @property string $jabatan_pegawai_turun_terlapor
 * @property string $di_tempat
 * @property string $tgl_sk_was_4b
 * @property string $tgl_diterima_sk_was_4b
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $upload_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class SkWas4b extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sk_was_4b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_4b', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_4b', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'created_by', 'updated_by'], 'integer'],
            [['tgl_sk_was_4b', 'tgl_diterima_sk_was_4b', 'created_time', 'updated_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['tgl_lapdu'], 'string', 'max' => 10],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['no_sk_was_4b', 'golongan_pegawai_terlapor', 'golongan_pegawai_turun_terlapor'], 'string', 'max' => 50],
            [['pasal', 'nama_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'jabatan_pegawai_turun_terlapor', 'nama_penandatangan'], 'string', 'max' => 100],
            [['waktu_kejadian', 'pangkat_pegawai_terlapor', 'pangkat_pegawai_turun_terlapor', 'pangkat_penandatangan'], 'string', 'max' => 30],
            [['id_terlapor'], 'string', 'max' => 16],
            [['nip_pegawai_terlapor', 'nip_penandatangan'], 'string', 'max' => 18],
            [['nrp_pegawai_terlapor'], 'string', 'max' => 10],
            [['satker_pegawai_terlapor', 'unit_kerja_terlapor', 'jabatan_penandatangan'], 'string', 'max' => 65],
            [['di_tempat'], 'string', 'max' => 70],
            [['golongan_penandatangan'], 'string', 'max' => 5],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['pelanggaran'], 'string']
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
            'id_sk_was_4b' => 'Id Sk Was 4b',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'no_sk_was_4b' => 'No Sk Was 4b',
            'tgl_lapdu' => 'Tgl Lapdu',
            'pasal' => 'Pasal',
            'waktu_kejadian' => 'Waktu Kejadian',
            'id_terlapor' => 'Id Terlapor',
            'nip_pegawai_terlapor' => 'Nip Pegawai Terlapor',
            'nrp_pegawai_terlapor' => 'Nrp Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'unit_kerja_terlapor' => 'Unit Kerja Terlapor',
            'pangkat_pegawai_turun_terlapor' => 'Pangkat Pegawai Turun Terlapor',
            'golongan_pegawai_turun_terlapor' => 'Golongan Pegawai Turun Terlapor',
            'jabatan_pegawai_turun_terlapor' => 'Jabatan Pegawai Turun Terlapor',
            'di_tempat' => 'Di Tempat',
            'tgl_sk_was_4b' => 'Tgl Sk Was 4b',
            'tgl_diterima_sk_was_4b' => 'Tgl Diterima Sk Was 4b',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'upload_file' => 'Upload File',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
