<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sumber_laporan".
 *
 * @property string $nama_sumber_laporan
 * @property string $id_sumber_laporan
 */
class SumberLaporanMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sumber_laporan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['nama_sumber_laporan'], 'string', 'max' => 30],
            [['id_sumber_laporan'], 'string', 'max' => 2],
            [['akronim'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sumber_laporan' => 'Id Sumber Laporan',
            'nama_sumber_laporan' => 'Nama Sumber Laporan',
            'akronim' => 'Akronim'
        ];
    }
}
