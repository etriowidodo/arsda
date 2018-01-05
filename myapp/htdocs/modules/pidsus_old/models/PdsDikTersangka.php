<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_tersangka".
 *
 * @property string $id_pds_dik_tersangka
 * @property string $id_pds_dik
 * @property string $nama_tersangka
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property integer $jenis_kelamin
 * @property string $kewarganegaraan
 * @property string $alamat
 * @property integer $agama
 * @property string $pekerjaan
 * @property integer $pendidikan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property integer $jenis_id
 * @property string $nomor_id
 * @property string $suku
 * @property string $flag
 */
class PdsDikTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir', 'create_date', 'update_date'], 'safe'],
            [['jenis_kelamin', 'agama', 'pendidikan','jenis_id'], 'integer'],
            [['id_pds_dik_tersangka', 'id_pds_dik', 'kewarganegaraan','suku'], 'string', 'max' => 25],
            [['nama_tersangka', 'alamat'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 255],
            [['tempat_lahir', 'pekerjaan','nomor_id'], 'string', 'max' => 50],
            [['flag'], 'string', 'max' => 1],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik_tersangka' => 'Id Pds Dik Tersangka',
            'id_pds_dik' => 'Id Pds Dik',
            'nama_tersangka' => 'Nama Tersangka',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'kewarganegaraan' => 'Kewarganegaraan',
            'alamat' => 'Alamat',
            'agama' => 'Agama',
            'pekerjaan' => 'Pekerjaan',
            'pendidikan' => 'Pendidikan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
