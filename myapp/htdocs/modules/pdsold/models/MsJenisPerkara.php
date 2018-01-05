<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_jenis_perkara".
 *
 * @property integer $kode_pidana
 * @property integer $jenis_perkara
 * @property string $nama
 */
class MsJenisPerkara extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_jenis_perkara';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_pidana'], 'required'],
            [['kode_pidana', 'jenis_perkara'], 'integer'],
            [['nama'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_pidana' => 'Kode Pidana',
            'jenis_perkara' => 'Jenis Perkara',
            'nama' => 'Nama',
        ];
    }
}
