<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sk_was_3a_pemeriksa".
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
 * @property integer $id_sk_was_3a
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property integer $id_pemeriksa_sp_was2
 * @property string $nip_pemeriksa
 * @property string $nrp_pemeriksa
 * @property string $nama_pemeriksa
 * @property string $pangkat_pemeriksa
 * @property string $jabatan_pemeriksa
 * @property string $golongan_pemeriksa
 * @property integer $created_by
 * @property string $created_time
 * @property string $created_ip
 */
class SkWas3aPemeriksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sk_was_3a_pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
         //   [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_3a', 'id_wilayah', 'id_level1', 'id_pemeriksa_sp_was2'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_sk_was_3a', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_pemeriksa_sp_was2', 'created_by'], 'integer'],
            [['created_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['nip_pemeriksa'], 'string', 'max' => 18],
            [['nrp_pemeriksa'], 'string', 'max' => 10],
            [['nama_pemeriksa'], 'string', 'max' => 65],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['jabatan_pemeriksa'], 'string', 'max' => 100],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
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
            'id_sk_was_3a' => 'Id Sk Was 3a',
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'id_pemeriksa_sp_was2' => 'Id Pemeriksa Sp Was2',
            'nip_pemeriksa' => 'Nip Pemeriksa',
            'nrp_pemeriksa' => 'Nrp Pemeriksa',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'created_ip' => 'Created Ip',
        ];
    }
}
