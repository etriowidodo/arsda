<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_pengembalian_berkas".
 *
 * @property string $id_pengembalian
 * @property string $id_berkas
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $tgl_dikeluarkan
 * @property string $dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $perihal
 * @property string $file_upload
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property string $updated_by
 * @property string $updated_time
 * @property string $alasan
 */
class PdmPengembalianBerkas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pengembalian_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengembalian', 'id_berkas', 'no_surat'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['alasan'], 'string'],
            [['id_pengembalian'], 'string', 'max' => 121],
            [['id_berkas'], 'string', 'max' => 70],
            [['no_surat'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['lampiran'], 'string', 'max' => 16],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['perihal'], 'string', 'max' => 255],
            [['file_upload', 'pangkat'], 'string', 'max' => 100],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['created_by', 'updated_by'], 'string', 'max' => 18],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pengembalian' => 'Id Pengembalian',
            'id_berkas' => 'Id Berkas',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'dikeluarkan' => 'Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'perihal' => 'Perihal',
            'file_upload' => 'File Upload',
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
            'alasan' => 'Alasan',
        ];
    }
}
