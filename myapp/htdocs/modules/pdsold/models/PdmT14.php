<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t14".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t14
 * @property string $id_tersangka
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $no_pengadilan
 * @property string $tgl_pengadilan
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
 * @property string $no_reg_tahanan_jaksa
 * @property string $nama
 * @property string $ciriciri
 * @property string $nip_jaksa
 */
class PdmT14 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t14';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t14', 'id_tersangka', 'created_by', 'updated_by'], 'required'],
            [['tgl_pengadilan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['ciriciri'], 'string'],
            [['id_tersangka', 'lampiran'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t14'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['no_pengadilan'], 'string', 'max' => 32],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_reg_tahanan_jaksa', 'nip_jaksa'], 'string', 'max' => 60],
            [['nama'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_t14' => 'No Surat T14',
            'id_tersangka' => 'Id Tersangka',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'no_pengadilan' => 'No Pengadilan',
            'tgl_pengadilan' => 'Tgl Pengadilan',
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
            'no_reg_tahanan_jaksa' => 'No Reg Tahanan Jaksa',
            'nama' => 'Nama',
            'ciriciri' => 'Ciriciri',
            'nip_jaksa' => 'Nip Jaksa',
        ];
    }
}
