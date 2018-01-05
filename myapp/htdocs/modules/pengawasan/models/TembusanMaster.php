<?php

namespace app\modules\pengawasan\models;

use Yii;

class TembusanMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_tembusan_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan'], 'string', 'max' => 4],
            [['nama_tembusan'], 'string', 'max' => 65],
            [['for_tabel'], 'string', 'max' => 20],
            [['kode_wilayah'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id Tembusan',
            'nama_tembusan' => 'Nama Tembusan',
            'for_tabel' => 'For Tabel',
            'kode_wilayah' => 'Kode Wilayah',
        ];
    }
}
