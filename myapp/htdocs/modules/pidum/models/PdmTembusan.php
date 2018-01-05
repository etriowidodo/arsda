<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan".
 *
 * @property string $id_tembusan
 * @property string $kode_table
 * @property string $id_table
 * @property string $nip
 * @property string $keterangan
 * @property string $id_perkara
 * @property string $flag
 * @property integer $no_urut
 * @property string $tembusan
 */
class PdmTembusan extends \yii\db\ActiveRecord
{
    public $id_tmp_tembusan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'id_perkara'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 16],
			[['id_perkara'], 'string', 'max' => 56],
            [['kode_table'], 'string', 'max' => 30],
            [['id_table'], 'string', 'max' => 56],
            [['nip'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['tembusan'], 'string', 'max' => 128],
            [['id_tembusan'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id Tembusan',
            'kode_table' => 'Kode Table',
            'id_table' => 'Id Table',
            'nip' => 'Nip',
            'keterangan' => 'Keterangan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }
}
