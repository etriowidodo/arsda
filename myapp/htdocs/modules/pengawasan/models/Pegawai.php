<?php

namespace app\modules\pengawasan\models;

use Yii;

class Pegawai extends \yii\db\ActiveRecord
{
  public $nama_penandatangan;
  public $nip;
  public $golongan;
  public $jabatan_penandatangan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_pegawai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
              [['peg_nip_baru'], 'string'],
              [['nama'], 'string'],
              
              [['jabatan'], 'string'],
              
              [['ref_jabatan_kd'], 'integer'],
              [['jabatan_panjang'], 'string'],
              [['gol_kd'], 'string'],
              [['gol_pangkat2'], 'string'],
              // [['unitkerja_kd'], 'string'],
              


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nip_baru' => 'Nip',
            'nama' => 'Nama Penandatangan',
            //'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'gol_pangkat2' => 'Pangkat',
            //'id_tingkat_wilayah' => 'Id Tingkat Wilayah',
            'jabatan' => 'Jabatann',
            'ref_jabatan_kd' => 'Ref Jabatan',
            'gol_kd' => 'Gol Kd'
        ];
    }
}
