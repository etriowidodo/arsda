<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penyelesaian_pratut_limpah_jaksa".
 *
 * @property string $id_pratut_limpah_jaksa
 * @property string $peg_nip
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 */
class PdmPenyelesaianPratutLimpahJaksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penyelesaian_pratut_limpah_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut_limpah_jaksa'], 'required'],
            [['id_pratut_limpah_jaksa'], 'string', 'max' => 128],
            [['id_pratut_limpah'], 'string', 'max' => 107],
            [['peg_nip'], 'string', 'max' => 20],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['pangkat'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pratut_limpah_jaksa' => 'Id Pratut Limpah Jaksa',
            'peg_nip' => 'Peg Nip',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
        ];
    }
}
