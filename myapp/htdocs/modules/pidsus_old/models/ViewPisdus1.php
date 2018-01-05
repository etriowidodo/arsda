<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "ViewPisdus1".
 *
 * @property integer $id_laporan
 * @property integer $nama_kejaksaan
 * @property integer $nomor_surat
 */
class ViewPisdus1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ViewPisdus1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_laporan', 'nama_kejaksaan', 'nomor_surat'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_laporan' => 'Id Laporan',
            'nama_kejaksaan' => 'Nama Kejaksaan',
            'nomor_surat' => 'Nomor Surat',
        ];
    }
}
