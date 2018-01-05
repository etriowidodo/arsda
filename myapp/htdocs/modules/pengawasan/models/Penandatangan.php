<?php

namespace app\modules\pengawasan\models;

use Yii;

class Penandatangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.penandatangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nip'], 'string'],
            // [['nip'], 'required'],
			[['nama_penandatangan'], 'string'],
            [['pangkat_penandatangan'], 'string'],
            [['golongan_penandatangan'], 'string'],
            [['id_tingkat_wilayah'], 'integer'],
            [['jabatan_penandatangan'], 'string'],
            [['kode_level'], 'string'],
            [['unitkerja_kd'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nip' => 'Nip',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan',
            'id_tingkat_wilayah' => 'Id Tingkat Wilayah',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
        ];
    }
}
