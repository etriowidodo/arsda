<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_pratut_limpah".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_pratut_limpah
 * @property string $tembusan
 *
 * @property PdmPenyelesaianPratutLimpah $idPratutLimpah
 */
class PdmTembusanPratutLimpah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_pratut_limpah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut', 'id_pratut_limpah'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 112],
            [['id_pratut_limpah'], 'string', 'max' => 107],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id Tembusan',
            'no_urut' => 'No Urut',
            'id_pratut_limpah' => 'Id Pratut Limpah',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPratutLimpah()
    {
        return $this->hasOne(PdmPenyelesaianPratutLimpah::className(), ['id_pratut_limpah' => 'id_pratut_limpah']);
    }
}
