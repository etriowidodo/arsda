<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_15_rencana".
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
 * @property integer $id_was15_rencana
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property integer $id_terlapor_l_was2
 * @property string $nip_terlapor
 * @property string $nrp_terlapor
 * @property string $nama_terlapor
 * @property string $pangkat_terlapor
 * @property string $golongan_terlapor
 * @property string $jabatan_terlapor
 * @property string $satker_terlapor
 * @property string $saran_dari
 * @property string $jenis_hukuman
 * @property string $sk
 * @property string $pasal
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 */
class Was15Rencana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_15_rencana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was15_rencana', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was15_rencana', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_terlapor_l_was2', 'created_by'], 'integer'],
            [['created_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['nip_terlapor'], 'string', 'max' => 18],
            [['nrp_terlapor'], 'string', 'max' => 10],
            [['nama_terlapor'], 'string', 'max' => 65],
            [['pangkat_terlapor'], 'string', 'max' => 30],
            [['golongan_terlapor','kategori_hukuman'], 'string', 'max' => 50],
            [['jabatan_terlapor', 'satker_terlapor', 'saran_dari', 'sk', 'pasal', 'jenis_hukuman'], 'string', 'max' => 100],
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
            'id_was15_rencana' => 'Id Was15 Rencana',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'id_terlapor_l_was2' => 'Id Terlapor L Was2',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama_terlapor' => 'Nama Terlapor',
            'pangkat_terlapor' => 'Pangkat Terlapor',
            'golongan_terlapor' => 'Golongan Terlapor',
            'jabatan_terlapor' => 'Jabatan Terlapor',
            'satker_terlapor' => 'Satker Terlapor',
            'saran_dari' => 'Saran Dari',
            'jenis_hukuman' => 'Jenis Hukuman',
            'sk' => 'Sk',
            'pasal' => 'Pasal',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
