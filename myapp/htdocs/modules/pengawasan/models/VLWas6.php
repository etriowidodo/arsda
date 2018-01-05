<?php

namespace app\modules\pengawasan\models;


use Yii;

/**
 * This is the model class for table "was.v_l_was_6".
 *
 * @property string $inst_satkerkd
 * @property string $inst_nama
 * @property string $ringan_tu
 * @property string $ringan_jaksa
 * @property string $sedang_tu
 * @property string $sedang_jaksa
 * @property string $berat_tu
 * @property string $berat_jaksa
 */
class VLWas6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_l_was_6';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ringan_tu', 'ringan_jaksa', 'sedang_tu', 'sedang_jaksa', 'berat_tu', 'berat_jaksa'], 'integer'],
            [['inst_satkerkd'], 'string', 'max' => 50],
            [['inst_nama'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inst_satkerkd' => 'Inst Satkerkd',
            'inst_nama' => 'Inst Nama',
            'ringan_tu' => 'Ringan Tu',
            'ringan_jaksa' => 'Ringan Jaksa',
            'sedang_tu' => 'Sedang Tu',
            'sedang_jaksa' => 'Sedang Jaksa',
            'berat_tu' => 'Berat Tu',
            'berat_jaksa' => 'Berat Jaksa',
        ];
    }
}
