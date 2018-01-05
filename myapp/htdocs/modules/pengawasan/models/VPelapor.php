<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_pelapor".
 *
 * @property string $nama
 * @property string $alamat
 * @property string $id_register
 * @property string $id_pelapor
 */
class VPelapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_pelapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 60],
            [['alamat'], 'string', 'max' => 200],
            [['id_register', 'id_pelapor'], 'string', 'max' => 16]
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
            'id_register' => 'Id Register',
            'id_pelapor' => 'Id Pelapor',
        ];
    }
}
