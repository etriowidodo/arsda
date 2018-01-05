<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_putusan_pn".
 *
 * @property string $no_register_perkara
 * @property string $no_surat
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
 * @property string $pengadilan
 * @property string $usul
 * @property integer $status_yakum
 * @property string $no_akta
 * @property string $tgl_baca
 * @property string $file_upload
 * @property string $sikap_jaksa
 */
class PdmPutusanPn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_putusan_pn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat', 'created_by', 'updated_by'], 'required'],
            [['tgl_dikeluarkan', 'tgl_persidangan', 'created_time', 'updated_time', 'tgl_baca'], 'safe'],
            [['pasal_bukti', 'kasus_posisi', 'updated_log', 'usul', 'file_upload'], 'string'],
            [['created_by', 'updated_by', 'status_yakum'], 'integer'],
            [['no_register_perkara', 'lampiran'], 'string', 'max' => 30],
            [['no_surat', 'no_persidangan', 'kerugian_negara', 'mati', 'luka', 'akibat_lain', 'pengadilan'], 'string', 'max' => 50],
            [['sifat'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_akta'], 'string', 'max' => 60],
            [['sikap_jaksa'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat' => 'No Surat',
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
            'pengadilan' => 'Pengadilan',
            'usul' => 'Usul',
            'status_yakum' => 'Status Yakum',
            'no_akta' => 'No Akta',
            'tgl_baca' => 'Tgl Baca',
            'file_upload' => 'File Upload',
            'sikap_jaksa' => 'Sikap Jaksa',
        ];
    }
}
