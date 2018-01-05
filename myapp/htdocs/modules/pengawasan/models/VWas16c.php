<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_16c".
 *
 * @property string $id_was_16c
 * @property string $id_register
 * @property string $no_was_16c
 * @property string $tgl_was_16c
 * @property integer $lampiran
 * @property integer $kpd_was_16c
 * @property string $kejaksaan
 * @property string $di
 * @property string $sifat
 * @property string $kepada
 * @property string $nama_terlapor
 * @property string $nip_terlapor
 * @property string $nrp_terlapor
 * @property string $jabatan_terlapor
 * @property string $ttd_nip
 * @property string $ttd_nama
 * @property string $ttd_jabatan
 * @property string $bentuk_hukuman
 * @property string $perihal
 */
class VWas16c extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_16c';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_16c'], 'safe'],
            [['lampiran', 'kpd_was_16c'], 'integer'],
            [['jabatan_terlapor', 'ttd_jabatan'], 'string'],
            [['id_was_16c', 'id_register'], 'string', 'max' => 16],
            [['no_was_16c', 'nip_terlapor', 'ttd_nip'], 'string', 'max' => 20],
            [['kejaksaan', 'di'], 'string', 'max' => 100],
            [['sifat'], 'string', 'max' => 225],
            [['kepada'], 'string', 'max' => 200],
            [['nama_terlapor', 'ttd_nama'], 'string', 'max' => 65],
            [['nrp_terlapor'], 'string', 'max' => 12],
            [['bentuk_hukuman'], 'string', 'max' => 2000],
            [['perihal'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16c' => 'Id Was 16c',
            'id_register' => 'Id Register',
            'no_was_16c' => 'No Was 16c',
            'tgl_was_16c' => 'Tgl Was 16c',
            'lampiran' => 'Lampiran',
            'kpd_was_16c' => 'Kpd Was 16c',
            'kejaksaan' => 'Kejaksaan',
            'di' => 'Di',
            'sifat' => 'Sifat',
            'kepada' => 'Kepada',
            'nama_terlapor' => 'Nama Terlapor',
            'nip_terlapor' => 'Nip Terlapor',
            'nrp_terlapor' => 'Nrp Terlapor',
            'jabatan_terlapor' => 'Jabatan Terlapor',
            'ttd_nip' => 'Ttd Nip',
            'ttd_nama' => 'Ttd Nama',
            'ttd_jabatan' => 'Ttd Jabatan',
            'bentuk_hukuman' => 'Bentuk Hukuman',
            'perihal' => 'Perihal',
        ];
    }
}
