<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_saksi_eksternal".
 *
 * @property string $nama
 * @property string $alamat
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $pekerjaan
 * @property string $agama
 * @property string $pendidikan
 * @property string $kewarganegaraan
 * @property string $id_register
 * @property string $id_saksi_eksternal
 */
class VSaksiEksternal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_saksi_eksternal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir'], 'safe'],
            [['nama'], 'string', 'max' => 60],
            [['alamat'], 'string', 'max' => 200],
            [['tempat_lahir', 'pekerjaan'], 'string', 'max' => 30],
            [['agama', 'pendidikan','kewarganegaraan'], 'string', 'max' => 50],
            [['id_register', 'id_saksi_eksternal'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'pekerjaan' => 'Pekerjaan',
            'agama' => 'Agama',
            'pendidikan' => 'Pendidikan',
			'kewarganegaraan' => 'Kewarganegaraan',
            'id_register' => 'Id Register',
            'id_saksi_eksternal' => 'Id Saksi Eksternal',
        ];
    }
}
