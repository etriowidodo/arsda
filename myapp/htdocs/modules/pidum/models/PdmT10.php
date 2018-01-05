<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t10".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t10
 * @property string $nama
 * @property string $alamat
 * @property string $pekerjaan
 * @property string $hubungan
 * @property string $id_tersangka
 * @property string $keperluan
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $tgl_kunjungan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
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
 *
 * @property PdmTahapDua $noRegisterPerkara
 */
class PdmT10 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t10', 'created_by', 'updated_by'], 'required'],
            [['jam_mulai', 'jam_selesai', 'tgl_kunjungan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t10'], 'string', 'max' => 50],
            [['nama', 'alamat', 'keperluan', 'dikeluarkan'], 'string', 'max' => 128],
            [['pekerjaan'], 'string', 'max' => 64],
            [['hubungan'], 'string', 'max' => 32],
            [['id_tersangka', 'id_penandatangan'], 'string', 'max' => 20],
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
            'no_surat_t10' => 'No Surat T10',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'pekerjaan' => 'Pekerjaan',
            'hubungan' => 'Hubungan',
            'id_tersangka' => 'Id Tersangka',
            'keperluan' => 'Keperluan',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'tgl_kunjungan' => 'Tgl Kunjungan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoRegisterPerkara()
    {
        return $this->hasOne(PdmTahapDua::className(), ['no_register_perkara' => 'no_register_perkara']);
    }
}