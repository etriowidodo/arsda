<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.pdm_tim_jpu".
 *
 * @property integer $id
 * @property string $no_p16
 * @property string $nip_pegawai
 * @property string $peneliti
 * @property string $penuntut
 * @property string $eksekutor
 * @property string $upaya_hukum
 * @property string $golongan
 * @property string $jabatan
 *
 * @property P16 $noP16
 */
class PdmTimJpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.pdm_tim_jpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_p16', 'golongan', 'jabatan'], 'string', 'max' => 50],
            [['nip_pegawai'], 'string', 'max' => 20],
            [['peneliti', 'penuntut', 'eksekutor', 'upaya_hukum'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_p16' => 'No P16',
            'nip_pegawai' => 'Nip Pegawai',
            'peneliti' => 'Peneliti',
            'penuntut' => 'Penuntut',
            'eksekutor' => 'Eksekutor',
            'upaya_hukum' => 'Upaya Hukum',
            'golongan' => 'Golongan',
            'jabatan' => 'Jabatan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoP16()
    {
        return $this->hasOne(P16::className(), ['no_p16' => 'no_p16']);
    }

    public function getNamaPegawai()
    {
        return $this->hasOne(KpPegawai::className(), ['peg_nip' => 'nip_pegawai']);
    }
}
