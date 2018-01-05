<?php

namespace app\modules\pengawasan\models;

use Yii;

class PenandatanganSurat extends \yii\db\ActiveRecord
{
    public $kode_level;
    public $nama_penandatangan;
    public $jabatan_penandatangan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.penandatangan_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat'], 'string'],
			[['nip'], 'string'],
            [['id_jabatan'], 'string'],
            [['unitkerja_kd'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_surat' => 'Kode Surat',
            'nip' => 'Nip',
            'id_jabatan' => 'Id Jabatan',
            'unitkerja_kd' => 'Unit Kerja'
        ];
    }
}
