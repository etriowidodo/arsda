<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_saksi".
 *
 * @property string $id_pds_tut_saksi
 * @property string $id_pds_tut
 * @property string $nama_saksi
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
 * @property string $tempat_lahir
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutSaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tut'], 'required'],
            [['tgl_lahir', 'create_date', 'update_date'], 'safe'],
            [['jenis_kelamin', 'agama', 'pendidikan'], 'integer'],
            [['id_pds_tut_saksi', 'id_pds_tut', 'kewarganegaraan', 'pekerjaan'], 'string', 'max' => 25],
            [['nama_saksi', 'alamat'], 'string', 'max' => 100],
            [['create_by', 'update_by'], 'string', 'max' => 20],
            [['tempat_lahir'], 'string', 'max' => 50],
            [['create_ip', 'update_ip'], 'string', 'max' => 45],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_saksi' => 'Id Pds Tut Saksi',
            'id_pds_tut' => 'Id Pds Tut',
            'nama_saksi' => 'Nama Saksi',
            'tgl_lahir' => 'Tgl Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'kewarganegaraan' => 'Kewarganegaraan',
            'alamat' => 'Alamat',
            'agama' => 'Agama',
            'pekerjaan' => 'Pekerjaan',
            'pendidikan' => 'pendidikan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'tempat_lahir' => 'Tempat Lahir',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'flag' => 'Flag',
        ];
    }
}
