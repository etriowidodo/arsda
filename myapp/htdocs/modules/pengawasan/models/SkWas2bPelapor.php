<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sk_was_2b_pelapor".
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
 * @property integer $id_sk_was_2b
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property integer $id_pelapor
 * @property string $nama_pelapor
 * @property string $alamat_pelapor
 * @property string $email_pelapor
 * @property string $telp_pelapor
 * @property string $pekerjaan_pelapor
 * @property string $sumber_lainnya
 * @property string $id_sumber_laporan
 * @property string $tempat_lahir_pelapor
 * @property string $tanggal_lahir_pelapor
 * @property string $kewarganegaraan_pelapor
 * @property string $agama_pelapor
 * @property string $pendidikan_pelapor
 * @property string $nama_kota_pelapor
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 */
class SkWas2bPelapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sk_was_2b_pelapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_2b', 'id_wilayah', 'id_level1', 'id_pelapor'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_2b', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_pelapor', 'created_by'], 'integer'],
            [['alamat_pelapor'], 'string'],
            [['tanggal_lahir_pelapor', 'created_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari', 'id_sumber_laporan'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['nama_pelapor', 'email_pelapor', 'sumber_lainnya', 'agama_pelapor', 'pendidikan_pelapor'], 'string', 'max' => 30],
            [['telp_pelapor'], 'string', 'max' => 13],
            [['pekerjaan_pelapor'], 'string', 'max' => 20],
            [['tempat_lahir_pelapor', 'kewarganegaraan_pelapor', 'nama_kota_pelapor'], 'string', 'max' => 50],
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
            'id_sk_was_2b' => 'Id Sk Was 2b',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'id_pelapor' => 'Id Pelapor',
            'nama_pelapor' => 'Nama Pelapor',
            'alamat_pelapor' => 'Alamat Pelapor',
            'email_pelapor' => 'Email Pelapor',
            'telp_pelapor' => 'Telp Pelapor',
            'pekerjaan_pelapor' => 'Pekerjaan Pelapor',
            'sumber_lainnya' => 'Sumber Lainnya',
            'id_sumber_laporan' => 'Id Sumber Laporan',
            'tempat_lahir_pelapor' => 'Tempat Lahir Pelapor',
            'tanggal_lahir_pelapor' => 'Tanggal Lahir Pelapor',
            'kewarganegaraan_pelapor' => 'Kewarganegaraan Pelapor',
            'agama_pelapor' => 'Agama Pelapor',
            'pendidikan_pelapor' => 'Pendidikan Pelapor',
            'nama_kota_pelapor' => 'Nama Kota Pelapor',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
