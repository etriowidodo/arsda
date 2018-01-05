<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_template_tembusan".
 *
 * @property integer $id_tmp_tembusan
 * @property string $kd_berkas
 * @property string $no_urut
 * @property string $tembusan
 * @property string $flag
 */
class PdmTemplateTembusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_template_tembusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_berkas'], 'string', 'max' => 16],
            [['no_urut'], 'string', 'max' => 4],
            [['tembusan'], 'string', 'max' => 128],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tmp_tembusan' => 'Id Tmp Tembusan',
            'kd_berkas' => 'Kode Persuratan',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
            'flag' => 'Flag',
        ];
    }
}
