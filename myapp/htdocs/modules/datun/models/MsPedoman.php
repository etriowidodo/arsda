<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_pedoman".
 *
 * @property string $uu
 * @property string $pasal
 * @property integer $kategori
 * @property integer $ancaman_hari
 * @property integer $ancaman_bulan
 * @property integer $ancaman_tahun
 * @property double $denda
 */
class MsPedoman extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_pedoman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu', 'pasal', 'kategori'], 'required'],
            [['kategori', 'ancaman_hari', 'ancaman_bulan', 'ancaman_tahun'], 'integer'],
            [['denda'], 'number'],
            [['uu'], 'string', 'max' => 50],
            [['pasal'], 'string', 'max' => 100],
            [['tuntutan_pidana','ancaman'], 'string', 'max' => 100],
			[['uu', 'pasal', 'kategori'], 'unique', 'targetAttribute' => ['uu', 'pasal', 'kategori']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uu' => 'Uu',
            'pasal' => 'Pasal',
            'kategori' => 'Kategori',
            'ancaman_hari' => 'Ancaman Hari',
            'ancaman_bulan' => 'Ancaman Bulan',
            'ancaman_tahun' => 'Ancaman Tahun',
            'denda' => 'Denda',
            'ancaman' => 'Ancaman',
            'tuntutan_pidana' => 'tuntutan_pidana',
        ];
    }
}
