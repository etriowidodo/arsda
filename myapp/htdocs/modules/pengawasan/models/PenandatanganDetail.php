<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.penandatangan_detail".
 *
 * @property integer $id_penandatangan_surat
 * @property integer $id_penandatangan_detail
 * @property string $nip_penandatangan
 * @property string $kode_jabatan
 * @property string $akronim
 * @property string $jbtn_alias_panjang
 * @property string $jabatan_asli
 */
class PenandatanganDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.penandatangan_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penandatangan_surat'], 'required'],
            [['id_penandatangan_surat'], 'integer'],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['kode_jabatan'], 'string', 'max' => 4],
            [['unitkerja_kd','unitkerja_alias'], 'string', 'max' => 30],
            [['akronim', 'jabatan_asli'], 'string', 'max' => 100],
            [['jbtn_alias_panjang'], 'string', 'max' => 150],
            [['id_penandatangan_surat', 'nip_penandatangan', 'kode_jabatan'], 'unique', 'targetAttribute' => ['id_penandatangan_surat', 'nip_penandatangan', 'kode_jabatan'], 'message' => 'The combination of Id Penandatangan Surat, Nip Penandatangan and Kode Jabatan has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_penandatangan_surat' => 'Id Penandatangan Surat',
            'id_penandatangan_detail' => 'Id Penandatangan Detail',
            'nip_penandatangan' => 'Nip Penandatangan',
            'kode_jabatan' => 'Kode Jabatan',
            'akronim' => 'Akronim',
            'jbtn_alias_panjang' => 'Jbtn Alias Panjang',
            'jabatan_asli' => 'Jabatan Asli',
        ];
    }
}
