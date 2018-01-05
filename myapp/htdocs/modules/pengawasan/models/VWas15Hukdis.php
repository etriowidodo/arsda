<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_15_hukdis".
 *
 * @property string $nama
 * @property string $nip
 * @property string $nrp
 * @property string $jabatan
 * @property string $pasal
 * @property string $risedber
 * @property string $aturan_hukum
 * @property integer $rncn_jatuh_hukdis_was_15
 * @property string $isi_hukuman_disiplin
 */
class VWas15Hukdis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_15_hukdis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan'], 'string'],
            [['rncn_jatuh_hukdis_was_15'], 'integer'],
            [['nama'], 'string', 'max' => 65],
            [['nip'], 'string', 'max' => 20],
            [['nrp'], 'string', 'max' => 12],
            [['pasal'], 'string', 'max' => 60],
            [['risedber', 'aturan_hukum'], 'string', 'max' => 100],
            [['isi_hukuman_disiplin'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nama' => 'Nama',
            'nip' => 'Nip',
            'nrp' => 'Nrp',
            'jabatan' => 'Jabatan',
            'pasal' => 'Pasal',
            'risedber' => 'Risedber',
            'aturan_hukum' => 'Aturan Hukum',
            'rncn_jatuh_hukdis_was_15' => 'Rncn Jatuh Hukdis Was 15',
            'isi_hukuman_disiplin' => 'Isi Hukuman Disiplin',
        ];
    }
}
