<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.satker".
 *
 * @property string $id_satker
 * @property string $nama
 * @property string $id_kota
 * @property string $alamat
 * @property string $lokasi_ttd
 * @property string $zona_waktu
 * @property string $no_telp
 * @property string $fax
 * @property string $email
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class Satker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.satker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_satker'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['id_satker', 'id_kota'], 'string', 'max' => 10],
            [['nama', 'lokasi_ttd'], 'string', 'max' => 50],
            [['alamat'], 'string', 'max' => 150],
            [['zona_waktu'], 'string', 'max' => 4],
            [['no_telp', 'fax'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 25],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_satker' => 'Id Satker',
            'nama' => 'Nama',
            'id_kota' => 'Id Kota',
            'alamat' => 'Alamat',
            'lokasi_ttd' => 'Lokasi Ttd',
            'zona_waktu' => 'Zona Waktu',
            'no_telp' => 'No Telp',
            'fax' => 'Fax',
            'email' => 'Email',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
