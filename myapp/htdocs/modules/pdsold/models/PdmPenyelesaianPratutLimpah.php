<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penyelesaian_pratut_limpah".
 *
 * @property string $id_pratut_limpah
 * @property string $id_pratut
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $perihal
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmPenyelesaianPratutLimpah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penyelesaian_pratut_limpah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut_limpah', 'no_surat', 'sifat', 'lampiran'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['lampiran'], 'string', 'max' => 16],
            [['id_pratut_limpah'], 'string', 'max' => 107],
            [['id_pratut'], 'string', 'max' => 56],
            [['no_surat'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['kd_satker_pelimpahan'], 'string', 'max' => 8],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['perihal'], 'string', 'max' => 255],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['pangkat'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pratut_limpah' => 'Id Pratut Limpah',
            'id_pratut' => 'Id Pratut',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'perihal' => 'Perihal',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
