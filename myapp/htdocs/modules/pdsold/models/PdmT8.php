<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t8".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t8
 * @property string $tgl_permohonan
 * @property string $id_tersangka
 * @property string $no_surat_t7
 * @property string $tgl_penahanan
 * @property string $tgl_penangguhan
 * @property string $tgl_mulai
 * @property string $jaminan
 * @property string $hari_lapor
 * @property string $kepala_rutan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property integer $id_ms_status_t8
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_surat_p16a
 * @property integer $no_urut_jaksa_p16a
 */
class PdmT8 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t8';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t8', 'created_by', 'updated_by'], 'required'],
            [['tgl_permohonan', 'tgl_penahanan','tgl_ba4', 'tgl_penangguhan', 'tgl_mulai', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['id_ms_status_t8', 'created_by', 'updated_by', 'no_urut_jaksa_p16a','id_tersangka'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t8', 'no_surat_p16a'], 'string', 'max' => 50],
            [['id_tersangka', 'id_penandatangan'], 'string', 'max' => 20],
            [['no_surat_t7'], 'string', 'max' => 32],
            [['jaminan'], 'string', 'max' => 2000],
            [['hari_lapor'], 'string', 'max' => 12],
            [['kepala_rutan'], 'string', 'max' => 256],
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
            'no_surat_t8' => 'No Surat T8',
            'tgl_permohonan' => 'Tgl Permohonan',
            'id_tersangka' => 'Id Tersangka',
            'no_surat_t7' => 'No Surat T7',
            'tgl_penahanan' => 'Tgl Penahanan',
            'tgl_penangguhan' => 'Tgl Penangguhan',
            'tgl_mulai' => 'Tgl Mulai',
            'jaminan' => 'Jaminan',
            'hari_lapor' => 'Hari Lapor',
            'kepala_rutan' => 'Kepala Rutan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'id_ms_status_t8' => 'Id Ms Status T8',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_surat_p16a' => 'No Surat P16a',
            'no_urut_jaksa_p16a' => 'No Urut Jaksa P16a',
        ];
    }
}
