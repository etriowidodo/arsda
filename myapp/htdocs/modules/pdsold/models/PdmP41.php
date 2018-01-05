<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p41".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p41
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $no_persidangan
 * @property string $tgl_persidangan
 * @property string $pasal_bukti
 * @property string $kasus_posisi
 * @property string $kerugian_negara
 * @property string $mati
 * @property string $luka
 * @property string $akibat_lain
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_log
 * @property string $updated_time
 * @property string $id_penandatangan
 * @property string $usul
 * @property string $tgl_baca
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 */
class PdmP41 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p41';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p41', 'created_by', 'updated_by'], 'required'],
            [['tgl_dikeluarkan', 'tgl_persidangan', 'created_time', 'updated_time', 'tgl_baca'], 'safe'],
            [['pasal_bukti', 'kasus_posisi', 'updated_log', 'usul'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara', 'lampiran'], 'string', 'max' => 30],
            [['no_surat_p41', 'no_persidangan', 'kerugian_negara', 'mati', 'luka', 'akibat_lain'], 'string', 'max' => 50],
            [['sifat'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_penandatangan'], 'string', 'max' => 30],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p41' => 'No Surat P41',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'no_persidangan' => 'No Persidangan',
            'tgl_persidangan' => 'Tgl Persidangan',
            'pasal_bukti' => 'Pasal Bukti',
            'kasus_posisi' => 'Kasus Posisi',
            'kerugian_negara' => 'Kerugian Negara',
            'mati' => 'Mati',
            'luka' => 'Luka',
            'akibat_lain' => 'Akibat Lain',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_log' => 'Updated Log',
            'updated_time' => 'Updated Time',
            'id_penandatangan' => 'Id Penandatangan',
            'usul' => 'Usul',
            'tgl_baca' => 'Tgl Baca',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
        ];
    }
}
