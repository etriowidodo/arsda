<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p39".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p39
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property integer $sidang_ke
 * @property string $hakim
 * @property string $panitera
 * @property string $penuntut_umum
 * @property string $penasihat_hukum
 * @property string $uraian_sidang
 * @property string $pengunjung
 * @property string $kesimpulan
 * @property string $pendapat
 * @property string $id_penandatangan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $no_agenda
 * @property integer $acara_sidang
 * @property string $acara_sidang_ke
 * @property string $file_upload
 */
class PdmP39 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p39';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p39', 'created_by', 'updated_by'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['sidang_ke', 'created_by', 'updated_by', 'no_agenda', 'acara_sidang'], 'integer'],
            [['hakim', 'panitera', 'penuntut_umum', 'penasihat_hukum', 'uraian_sidang', 'pengunjung', 'kesimpulan', 'pendapat', 'acara_sidang_ke', 'file_upload'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p39'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['lampiran'], 'string', 'max' => 16],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p39' => 'No Surat P39',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'sidang_ke' => 'Sidang Ke',
            'hakim' => 'Hakim',
            'panitera' => 'Panitera',
            'penuntut_umum' => 'Penuntut Umum',
            'penasihat_hukum' => 'Penasihat Hukum',
            'uraian_sidang' => 'Uraian Sidang',
            'pengunjung' => 'Pengunjung',
            'kesimpulan' => 'Kesimpulan',
            'pendapat' => 'Pendapat',
            'id_penandatangan' => 'Id Penandatangan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_agenda' => 'No Agenda',
            'acara_sidang' => 'Acara Sidang',
            'acara_sidang_ke' => 'Acara Sidang Ke',
            'file_upload' => 'File Upload',
        ];
    }
}
