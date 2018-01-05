<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_14b".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_was14b
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $no_was14b
 * @property integer $sifat_was14b
 * @property string $lampiran_was14b
 * @property string $perihal_was14b
 * @property string $tgl_was14b
 * @property string $kepada_was14b
 * @property string $di_was14b
 * @property string $nip_terlapor
 * @property string $nrp_terlapor
 * @property string $nama_terlapor
 * @property string $pangkat_terlapor
 * @property string $golongan_terlapor
 * @property string $pasal_pelanggaran
 * @property string $satker_terlapor
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
class Was14b extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_14b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_terlapor'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was14b', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'sifat_was14b', 'created_by'], 'integer'],
            [['tgl_was14b', 'created_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['no_was14b', 'di_was14b', 'golongan_terlapor', 'golongan_penandatangan'], 'string', 'max' => 50],
            [['lampiran_was14b'], 'string', 'max' => 20],
            [['kepada_was14b', 'perihal_was14b', 'pasal_pelanggaran', 'satker_terlapor', 'nama_penandatangan','upload_file','hukdis'], 'string', 'max' => 100],
            [['nip_terlapor'], 'string', 'max' => 18],
            [['nrp_terlapor'], 'string', 'max' => 10],
            [['nama_terlapor', 'jabatan_penandatangan', 'jbtn_penandatangan'], 'string', 'max' => 65],
            [['pangkat_terlapor', 'nip_penandatangan', 'pangkat_penandatangan'], 'string', 'max' => 30],
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
            'id_was14b' => 'Id Was14b',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'no_was14b' => 'No Was14b',
            'sifat_was14b' => 'Sifat Was14b',
            'lampiran_was14b' => 'Lampiran Was14b',
            'perihal_was14b' => 'Perihal Was14b',
            'tgl_was14b' => 'Tgl Was14b',
            'kepada_was14b' => 'Kepada Was14b',
            'di_was14b' => 'Di Was14b',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama_terlapor' => 'Nama Terlapor',
            'pangkat_terlapor' => 'Pangkat Terlapor',
            'golongan_terlapor' => 'Golongan Terlapor',
            'pasal_pelanggaran' => 'Pasal Pelanggaran',
            'satker_terlapor' => 'Satker Terlapor',
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
