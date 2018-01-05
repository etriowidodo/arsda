<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.laporan_p7".
 *
 * @property string $id_p7
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 */
class LaporanP7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.laporan_p7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p7'], 'required'],
            [['tgl_dikeluarkan'], 'safe'],
            [['id_p7', 'id_penandatangan'], 'string', 'max' => 16],
            [['dikeluarkan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p7' => 'Id P7',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
        ];
    }
}
