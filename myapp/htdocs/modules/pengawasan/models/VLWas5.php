<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_l_was_5".
 *
 * @property string $inst_satkerkd
 * @property string $inst_nama
 * @property string $total_proses
 * @property string $total_selesai
 * @property string $total_terbukti
 * @property string $total_tdkterbukti
 * @property string $total_sblmblnini
 * @property string $total_blnini
 * @property string $jml_smpai_blninni
 */
class VLWas5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_l_was_5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_proses', 'total_selesai', 'total_terbukti', 'total_tdkterbukti', 'total_sblmblnini', 'total_blnini', 'jml_smpai_blninni'], 'integer'],
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
            'total_proses' => 'Total Proses',
            'total_selesai' => 'Total Selesai',
            'total_terbukti' => 'Total Terbukti',
            'total_tdkterbukti' => 'Total Tdkterbukti',
            'total_sblmblnini' => 'Total Sblmblnini',
            'total_blnini' => 'Total Blnini',
            'jml_smpai_blninni' => 'Jml Smpai Blninni',
        ];
    }
}
