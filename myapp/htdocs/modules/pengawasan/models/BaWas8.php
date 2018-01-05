<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_8".
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
 * @property integer $id_ba_was_8
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $tgl_ba_was_8
 * @property string $tempat
 * @property string $id_terlapor
 * @property string $nip_terlapor
 * @property string $nrp_terlapor
 * @property string $nama_terlapor
 * @property string $pangkat_terlapor
 * @property string $golongan_terlapor
 * @property string $jabatan_terlapor
 * @property integer $terima_tolak
 * @property string $nip_menerima
 * @property string $nrp_menerima
 * @property string $nama_menerima
 * @property string $pangkat_menerima
 * @property string $golongan_menerima
 * @property string $jabatan_menerima
 * @property string $upload_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas8 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_8';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_8', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_8', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'terima_tolak', 'created_by', 'updated_by'], 'integer'],
            [['tgl_ba_was_8', 'created_time', 'updated_time','tanggal_pemberitahuan_ba'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['tempat', 'nama_terlapor', 'nama_menerima','sk'], 'string', 'max' => 100],
            [['id_terlapor'], 'string', 'max' => 16],
            [['nip_terlapor', 'nip_menerima', 'created_ip', 'updated_ip'], 'string', 'max' => 18],
            [['nrp_terlapor', 'nrp_menerima'], 'string', 'max' => 10],
            [['pangkat_terlapor', 'pangkat_menerima'], 'string', 'max' => 30],
            [['golongan_terlapor', 'golongan_menerima'], 'string', 'max' => 50],
            [['jabatan_terlapor', 'jabatan_menerima'], 'string', 'max' => 100],
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
            'id_ba_was_8' => 'Id Ba Was 8',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'tgl_ba_was_8' => 'Tgl Ba Was 8',
            'tempat' => 'Tempat',
            'id_terlapor' => 'Id Terlapor',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama_terlapor' => 'Nama Terlapor',
            'pangkat_terlapor' => 'Pangkat Terlapor',
            'golongan_terlapor' => 'Golongan Terlapor',
            'jabatan_terlapor' => 'Jabatan Terlapor',
            'terima_tolak' => 'Terima Tolak',
            'nip_menerima' => 'Nip Menerima',
            'nrp_menerima' => 'Nrp Menerima',
            'nama_menerima' => 'Nama Menerima',
            'pangkat_menerima' => 'Pangkat Menerima',
            'golongan_menerima' => 'Golongan Menerima',
            'jabatan_menerima' => 'Jabatan Menerima',
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
