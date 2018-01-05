<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penyelesaian_pratut_limpah_tersangka".
 *
 * @property string $id_pratut_limpah_tersangka
 * @property string $id_ms_tersangka_berkas
 * @property string $status_penahanan
 */
class PdmPenyelesaianPratutLimpahTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penyelesaian_pratut_limpah_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut_limpah_tersangka', 'id_ms_tersangka_berkas'], 'required'],
            [['id_pratut_limpah_tersangka'], 'string', 'max' => 300],
            [['id_pratut_limpah'], 'string', 'max' => 107],
            [['status_penahanan'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pratut_limpah_tersangka' => 'Id Pratut Limpah Tersangka',
            'id_ms_tersangka_berkas' => 'Id Ms Tersangka Berkas',
            'status_penahanan' => 'Status Penahanan',
        ];
    }
}
