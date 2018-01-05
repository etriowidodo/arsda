<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "saksi_eksternal".
 *
 * @property string $id_saksi_eksternal
 * @property string $no_register
 * @property string $nama_saksi_eksternal
 * @property string $tempat_lahir_saksi_eksternal
 * @property string $tanggal_lahir_saksi_eksternal
 * @property string $id_negara_saksi_eksternal
 * @property integer $pendidikan
 * @property integer $id_agama_saksi_eksternal
 * @property string $alamat_saksi_eksternal
 * @property integer $dugaan_pelaporan
 * @property integer $nama_kota_saksi_eksternal
 * @property integer $pekerjaan_saksi_eksternal
 * @property integer $id_warganegara
 */
class SaksiEksternal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.saksi_eksternal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_saksi_eksternal'], 'required'],
            [['tanggal_lahir_saksi_eksternal'], 'safe'],
            [['pendidikan', 'id_agama_saksi_eksternal', 'id_warganegara','id_negara_saksi_eksternal'], 'integer'],
            [['id_saksi_eksternal'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['nama_saksi_eksternal'], 'string', 'max' => 20],
            [['tempat_lahir_saksi_eksternal'], 'string', 'max' => 60],
            [['pekerjaan_saksi_eksternal'], 'string', 'max' => 100],
            [['alamat_saksi_eksternal', 'nama_kota_saksi_eksternal'], 'string', 'max' => 30],
            // [['from_table'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_saksi_eksternal' => 'Id Saksi Eksternal',
            'no_register' => 'No Register',
            'nama_saksi_eksternal' => 'Nama Saksi Eksternal',
            'tempat_lahir_saksi_eksternal' => 'Tempat Lahir Saksi Eksternal',
            'tanggal_lahir_saksi_eksternal' => 'Tanggal Lahir Saksi Eksternal',
            'id_negara_saksi_eksternal' => 'Id Negara Saksi Eksternal',
            'pendidikan' => 'Pendidikan',
            'id_agama_saksi_eksternal' => 'Id Agama Saksi Eksternal',
            'alamat_saksi_eksternal' => 'Alamat Saksi Eksternal',
            // 'dugaan_pelaporan' => 'Dugaan Pelaporan',
            'nama_kota_saksi_eksternal' => 'Nama Kota Saksi Eksternal',
            'pekerjaan_saksi_eksternal' => 'Id Pekerjaan Saksi Eksternal',
            'id_warganegara' => 'Id Warganegara',
        ];
    }
}
