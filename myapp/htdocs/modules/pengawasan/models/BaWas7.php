<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_7".
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
 * @property integer $id_ba_was_7
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $tgl_ba_was_7
 * @property string $tempat
 * @property string $nip_penyampai
 * @property string $nrp_penyampai
 * @property string $nama_penyampai
 * @property string $pangkat_penyampai
 * @property string $golongan_penyampai
 * @property string $jabatan_penyampai
 * @property string $nip_penerima
 * @property string $nrp_penerima
 * @property string $nama_penerima
 * @property string $pangkat_penerima
 * @property string $golongan_penerima
 * @property string $jabatan_penerima
 * @property string $nip_saksi1
 * @property string $nrp_saksi1
 * @property string $nama_saksi1
 * @property string $pangkat_saksi1
 * @property string $golongan_saksi1
 * @property string $jabatan_saksi1
 * @property string $nip_saksi2
 * @property string $nrp_saksi2
 * @property string $nama_saksi2
 * @property string $pangkat_saksi2
 * @property string $golongan_saksi2
 * @property string $jabatan_saksi2
 * @property string $upload_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_7', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_7', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'created_by', 'updated_by','id_was_16b'], 'integer'],
            [['tgl_ba_was_7', 'created_time', 'updated_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['tempat', 'nama_penyampai', 'nama_terlapor', 'nama_saksi1', 'nama_saksi2','sk'], 'string', 'max' => 100],
            [['nip_penyampai', 'nip_terlapor', 'nip_saksi1', 'nip_saksi2', 'created_ip', 'updated_ip'], 'string', 'max' => 18],
            [['nrp_penyampai', 'nrp_terlapor', 'nrp_saksi1', 'nrp_saksi2'], 'string', 'max' => 10],
            [['pangkat_penyampai', 'pangkat_terlapor', 'pangkat_saksi1', 'pangkat_saksi2'], 'string', 'max' => 30],
            [['golongan_penyampai', 'golongan_terlapor', 'golongan_saksi1', 'golongan_saksi2','no_was_16b'], 'string', 'max' => 50],
            [['jabatan_penyampai', 'jabatan_terlapor'], 'string', 'max' => 65],
            [['jabatan_saksi1', 'jabatan_saksi2'], 'string', 'max' => 100],
            [['upload_file'], 'string', 'max' => 200],
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
            'id_ba_was_7' => 'Id Ba Was 7',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'tgl_ba_was_7' => 'Tgl Ba Was 7',
            'tempat' => 'Tempat',
            'nip_penyampai' => 'Nip Penyampai',
            'nrp_penyampai' => 'Nrp Penyampai',
            'nama_penyampai' => 'Nama Penyampai',
            'pangkat_penyampai' => 'Pangkat Penyampai',
            'golongan_penyampai' => 'Golongan Penyampai',
            'jabatan_penyampai' => 'Jabatan Penyampai',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama_terlapor' => 'Nama Terlapor',
            'pangkat_terlapor' => 'Pangkat Terlapor',
            'golongan_terlapor' => 'Golongan Terlapor',
            'jabatan_terlapor' => 'Jabatan Terlapor',
            'nip_saksi1' => 'Nip Saksi1',
            'nrp_saksi1' => 'Nrp Saksi1',
            'nama_saksi1' => 'Nama Saksi1',
            'pangkat_saksi1' => 'Pangkat Saksi1',
            'golongan_saksi1' => 'Golongan Saksi1',
            'jabatan_saksi1' => 'Jabatan Saksi1',
            'nip_saksi2' => 'Nip Saksi2',
            'nrp_saksi2' => 'Nrp Saksi2',
            'nama_saksi2' => 'Nama Saksi2',
            'pangkat_saksi2' => 'Pangkat Saksi2',
            'golongan_saksi2' => 'Golongan Saksi2',
            'jabatan_saksi2' => 'Jabatan Saksi2',
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
