<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_maxdatep16".
 *
 * @property string $id_p16
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $flag
 */
class VwMaxdatep16 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_maxdatep16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_dikeluarkan'], 'safe'],
            [['id_p16', 'id_perkara'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p16' => 'Id P16',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'flag' => 'Flag',
        ];
    }
}
