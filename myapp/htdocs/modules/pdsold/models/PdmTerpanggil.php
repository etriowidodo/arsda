<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_terpanggil".
 *
 * @property string $id_terpanggil
 * @property string $id_d1
 * @property string $nama
 * @property string $alamat
 * @property string $pekerjaan
 */
class PdmTerpanggil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_terpanggil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_terpanggil', 'id_d1'], 'required'],
            [['id_terpanggil', 'id_d1'], 'string', 'max' => 16],
            [['nama', 'pekerjaan'], 'string', 'max' => 64],
            [['alamat'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_terpanggil' => 'Id Terpanggil',
            'id_d1' => 'Id D1',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'pekerjaan' => 'Pekerjaan',
        ];
    }
}
