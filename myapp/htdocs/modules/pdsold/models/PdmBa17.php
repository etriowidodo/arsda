<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba17".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_ba17
 * @property string $no_akta
 * @property string $id_perkara
 * @property string $tgl_surat
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $id_tersangka
 * @property string $nama_kepala_rutan
 * @property string $nama_rutan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa17 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_ba17'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_surat_ba17', 'no_akta', 'id_perkara', 'id_tersangka'], 'string', 'max' => 20],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['nama', 'jabatan', 'nama_kepala_rutan', 'nama_rutan'], 'string', 'max' => 200],
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
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_ba17' => 'No Surat Ba17',
            'no_akta' => 'No Akta',
            'id_perkara' => 'Id Perkara',
            'tgl_surat' => 'Tgl Surat',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'id_tersangka' => 'Id Tersangka',
            'nama_kepala_rutan' => 'Nama Kepala Rutan',
            'nama_rutan' => 'Nama Rutan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
