<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_2_terlapor".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_terlapor_l_was_2
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $nip_terlapor
 * @property string $nrp_terlapor
 * @property string $nama_terlapor
 * @property string $pangkat_terlapor
 * @property string $golongan_terlapor
 * @property string $jabatan_terlapor
 * @property string $satker_terlapor
 * @property integer $saran_l_was_2
 * @property integer $pendapat_l_was_2
 * @property string $saran_pasal
 * @property string $pendapat_pasal
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 */
class LWas2Terlapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_2_terlapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_terlapor_l_was_2', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_terlapor_l_was_2', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'saran_l_was_2', 'pendapat_l_was_2', 'created_by'], 'integer'],
            [['created_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['nip_terlapor'], 'string', 'max' => 18],
            [['nrp_terlapor', 'saran_pasal', 'pendapat_pasal'], 'string', 'max' => 10],
            [['nama_terlapor'], 'string', 'max' => 65],
            [['pangkat_terlapor'], 'string', 'max' => 30],
            [['golongan_terlapor'], 'string', 'max' => 50],
            [['jabatan_terlapor', 'satker_terlapor','bentuk_pelanggaran'], 'string', 'max' => 100],
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
            'id_terlapor_l_was_2' => 'Id Terlapor L Was 2',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama_terlapor' => 'Nama Terlapor',
            'pangkat_terlapor' => 'Pangkat Terlapor',
            'golongan_terlapor' => 'Golongan Terlapor',
            'jabatan_terlapor' => 'Jabatan Terlapor',
            'satker_terlapor' => 'Satker Terlapor',
            'saran_l_was_2' => 'Saran L Was 2',
            'pendapat_l_was_2' => 'Pendapat L Was 2',
            'saran_pasal' => 'Saran Pasal',
            'pendapat_pasal' => 'Pendapat Pasal',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
