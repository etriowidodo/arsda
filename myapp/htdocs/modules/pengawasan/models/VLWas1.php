<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_l_was_1".
 *
 * @property string $id_l_was_1
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_lwas1
 * @property string $analisa
 * @property integer $ttd_sp_was_1
 * @property string $no_sp_was_1
 * @property string $tgl_sp_was_1
 * @property string $kejaksaan
 * @property string $pejabat_lwas1
 * @property string $uraian
 * @property string $inst_lokinst
 */
class VLWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_l_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lwas1', 'tgl_sp_was_1'], 'safe'],
            [['ttd_sp_was_1'], 'integer'],
            [['uraian'], 'string'],
            [['id_l_was_1', 'id_register'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['analisa'], 'string', 'max' => 2000],
            [['no_sp_was_1'], 'string', 'max' => 20],
            [['kejaksaan', 'inst_lokinst'], 'string', 'max' => 100],
            [['pejabat_lwas1'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_l_was_1' => 'Id L Was 1',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_lwas1' => 'Tgl Lwas1',
            'analisa' => 'Analisa',
            'ttd_sp_was_1' => 'Ttd Sp Was 1',
            'no_sp_was_1' => 'No Sp Was 1',
            'tgl_sp_was_1' => 'Tgl Sp Was 1',
            'kejaksaan' => 'Kejaksaan',
            'pejabat_lwas1' => 'Pejabat Lwas1',
            'uraian' => 'Uraian',
            'inst_lokinst' => 'Inst Lokinst',
        ];
    }
}
