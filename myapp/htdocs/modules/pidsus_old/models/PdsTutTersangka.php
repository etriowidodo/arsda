<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_tersangka".
 *
 * @property string $id_pds_tut_tersangka
 * @property string $id_pds_tut
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
class PdsTutTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tut'], 'required'],
            [['tgl_lahir', 'create_date', 'update_date'], 'safe'],
            [['jenis_kelamin', 'agama', 'pendidikan', 'jenis_id'], 'integer'],
            [['id_pds_tut_tersangka', 'id_pds_tut', 'kewarganegaraan', 'suku'], 'string', 'max' => 25],
            [['nama_tersangka'], 'string', 'max' => 100],
            [['tempat_lahir', 'pekerjaan', 'nomor_id'], 'string', 'max' => 50],
            [['alamat'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_tersangka' => 'Id Pds Tut Tersangka',
            'id_pds_tut' => 'Id Pds Tut',
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
            'jenis_id' => 'Jenis ID',
            'nomor_id' => 'Nomor ID',
            'suku' => 'Suku',
            'flag' => 'Flag',
        ];
    }
}
