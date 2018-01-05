<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_agenda_persidangan".
 *
 * @property string $no_register_perkara
 * @property string $tgl_acara_sidang
 * @property integer $acara_sidang
 * @property integer $sidang_ke
 * @property string $majelis_hakim
 * @property string $penasehat_hukum
 * @property string $uraian_sidang
 * @property string $pengunjung
 * @property string $kesimpulan
 * @property string $pendapat
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
 * @property string $panitera
 * @property string $acara_sidang_ke
 */
class PdmAgendaPersidangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_agenda_persidangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'acara_sidang', 'created_by', 'updated_by', 'no_agenda'], 'required'],
            [['tgl_acara_sidang', 'created_time', 'updated_time'], 'safe'],
            [['acara_sidang', 'sidang_ke', 'created_by', 'updated_by', 'no_agenda'], 'integer'],
            [['majelis_hakim', 'penasehat_hukum', 'uraian_sidang', 'pengunjung', 'kesimpulan', 'pendapat', 'panitera', 'acara_sidang_ke'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
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
            'tgl_acara_sidang' => 'Tgl Acara Sidang',
            'acara_sidang' => 'Acara Sidang',
            'sidang_ke' => 'Sidang Ke',
            'majelis_hakim' => 'Majelis Hakim',
            'penasehat_hukum' => 'Penasehat Hukum',
            'uraian_sidang' => 'Uraian Sidang',
            'pengunjung' => 'Pengunjung',
            'kesimpulan' => 'Kesimpulan',
            'pendapat' => 'Pendapat',
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
            'panitera' => 'Panitera',
            'acara_sidang_ke' => 'Acara Sidang Ke',
        ];
    }
}
