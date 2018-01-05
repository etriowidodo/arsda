<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_20a".
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
 * @property integer $id_was_20a
 * @property string $no_was_20a
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property integer $kpd_was_20a
 * @property string $id_terlapor
 * @property string $nip_pegawai_terlapor
 * @property string $nrp_pegawai_terlapor
 * @property string $nama_pegawai_terlapor
 * @property string $pangkat_pegawai_terlapor
 * @property string $golongan_pegawai_terlapor
 * @property string $jabatan_pegawai_terlapor
 * @property string $satker_pegawai_terlapor
 * @property string $unit_kerja_terlapor
 * @property string $tgl_was_20a
 * @property string $tempat
 * @property integer $sifat_surat
 * @property string $lampiran
 * @property string $perihal
 * @property string $tgl_disampaikan_ba
 * @property string $tgl_keberatan_ba
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $jbtn_penandatangan
 * @property string $upload_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was20a extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_20a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_20a', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_20a', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4',  'sifat_surat', 'created_by', 'updated_by'], 'integer'],
            [['tgl_was_20a', 'tgl_disampaikan_ba', 'tgl_keberatan_ba', 'created_time', 'updated_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['no_was_20a', 'golongan_pegawai_terlapor', 'golongan_penandatangan' , 'sk'], 'string', 'max' => 50],
            [['id_terlapor'], 'string', 'max' => 16],
            [['nip_pegawai_terlapor'], 'string', 'max' => 18],
            [['nrp_pegawai_terlapor'], 'string', 'max' => 10],
            [['nama_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'tempat', 'kpd_was_20a' , 'nama_penandatangan'], 'string', 'max' => 100],
            [['pangkat_pegawai_terlapor', 'nip_penandatangan', 'pangkat_penandatangan'], 'string', 'max' => 30],
            [['satker_pegawai_terlapor', 'unit_kerja_terlapor', 'jabatan_penandatangan', 'jbtn_penandatangan'], 'string', 'max' => 65],
            [['lampiran'], 'string', 'max' => 20],
            [['perihal'], 'string', 'max' => 1000],
            [['upload_file'], 'string', 'max' => 200],
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
            'id_was15' => 'Id Was15',
            'id_was_20a' => 'Id Was 20a',
            'no_was_20a' => 'No Was 20a',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'kpd_was_20a' => 'Kpd Was 20a',
            'id_terlapor' => 'Id Terlapor',
            'nip_pegawai_terlapor' => 'Nip Pegawai Terlapor',
            'nrp_pegawai_terlapor' => 'Nrp Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'unit_kerja_terlapor' => 'Unit Kerja Terlapor',
            'tgl_was_20a' => 'Tgl Was 20a',
            'tempat' => 'Tempat',
            'sifat_surat' => 'Sifat Surat',
            'lampiran' => 'Lampiran',
            'perihal' => 'Perihal',
            'tgl_disampaikan_ba' => 'Tgl Disampaikan Ba',
            'tgl_keberatan_ba' => 'Tgl Keberatan Ba',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'jbtn_penandatangan' => 'Jbtn Penandatangan',
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
