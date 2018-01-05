<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_13".
 *
 * @property string $id_was_13
 * @property string $kejaksaan
 * @property string $hari
 * @property string $tgl_was
 * @property string $ttd_peg_nik
 * @property string $pengirim
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $menerima_nama
 * @property string $id_register
 */
class VWas13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was', 'tgl_surat'], 'safe'],
            [['no_surat'], 'string'],
            [['id_was_13', 'id_register'], 'string', 'max' => 16],
            [['kejaksaan'], 'string', 'max' => 100],
            [['hari'], 'string', 'max' => 10],
            [['ttd_peg_nik'], 'string', 'max' => 20],
            [['pengirim'], 'string', 'max' => 65],
            [['menerima_nama'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_13' => 'Id Was 13',
            'kejaksaan' => 'Kejaksaan',
            'hari' => 'Hari',
            'tgl_was' => 'Tgl Was',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'pengirim' => 'Pengirim',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'menerima_nama' => 'Menerima Nama',
            'id_register' => 'Id Register',
        ];
    }
}
