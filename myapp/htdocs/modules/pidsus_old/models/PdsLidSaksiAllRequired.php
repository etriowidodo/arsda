<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_saksi".
 *
 * @property string $id_pds_lid_saksi
 * @property string $id_pds_lid
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
 */
class PdsLidSaksiAllRequired extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['tgl_lahir','tempat_lahir','jenis_kelamin','agama','pendidikan','kewarganegaraan','pekerjaan','nama_saksi', 'alamat'],'required'],	
            [['tgl_lahir', 'create_date', 'update_date'], 'safe'],
            [['jenis_kelamin', 'agama', 'pendidikan'], 'integer'],
            [['id_pds_lid_saksi', 'id_pds_lid', 'kewarganegaraan', 'pekerjaan'], 'string', 'max' => 25],
            [['tempat_lahir', 'pekerjaan'], 'string', 'max' => 50],
            [['nama_saksi', 'alamat'], 'string', 'max' => 100],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_saksi' => 'Id Pds Lid Saksi',
            'id_pds_lid' => 'Id Pds Lid',
            'nama_saksi' => 'Nama Saksi',
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
