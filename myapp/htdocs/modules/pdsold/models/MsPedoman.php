<?php

namespace app\modules\pdsold\models;

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
            [['id', 'id_pasal', 'kategori'], 'required'],
            [['kategori', 'ancaman_hari', 'ancaman_bulan', 'ancaman_tahun'], 'integer'],
            [['denda'], 'number'],
            [['id'], 'string', 'max' => 2],
            [['id_pasal'], 'string', 'max' => 3],
            [['tuntutan_pidana','ancaman'], 'string', 'max' => 100],
			[['id', 'id_pasal', 'kategori'], 'unique', 'targetAttribute' => ['id', 'id_pasal', 'kategori']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID UU',
            'id_pasal' => 'ID Pasal',
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
