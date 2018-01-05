<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_15_inspeksi_kasus".
 *
 * @property string $tgl
 * @property string $pejabat_sp_was_2
 * @property string $no_sp_was_2
 * @property string $tgl_sp_was_2
 * @property string $id_register
 */
class VWas15InspeksiKasus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_15_inspeksi_kasus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl', 'tgl_sp_was_2'], 'safe'],
            [['pejabat_sp_was_2'], 'string', 'max' => 200],
            [['no_sp_was_2'], 'string', 'max' => 20],
            [['id_register'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tgl' => 'Tgl',
            'pejabat_sp_was_2' => 'Pejabat Sp Was 2',
            'no_sp_was_2' => 'No Sp Was 2',
            'tgl_sp_was_2' => 'Tgl Sp Was 2',
            'id_register' => 'Id Register',
        ];
    }
}
