<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba15".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba15
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $no_p16a
 * @property string $penetapan
 * @property string $no_penetapan
 * @property string $tgl_penetapan
 * @property string $tgl_diterima
 * @property string $no_surat_t7
 * @property string $tgl_ba4
 * @property integer $id_tersangka
 * @property string $memerintahkan
 * @property integer $id_isipenetapan
 * @property string $nip_jaksa
 * @property string $nama_jaksa
 * @property string $jabatan_jaksa
 * @property string $tgl_awal_cara
 * @property string $tgl_akhir_cara
 * @property string $jenis_cara1
 * @property string $jenis_cara2
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_reg_tahanan
 * @property string $pangkat_jaksa
 */
class PdmBa15 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba15', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba15', 'tgl_sp', 'tgl_penetapan', 'tgl_diterima', 'tgl_ba4', 'tgl_awal_cara', 'tgl_akhir_cara', 'created_time', 'updated_time'], 'safe'],
            [['id_tersangka', 'id_isipenetapan', 'created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_sp'], 'string', 'max' => 32],
            [['no_p16a', 'no_surat_t7'], 'string', 'max' => 50],
            [['penetapan', 'pangkat_jaksa'], 'string', 'max' => 100],
            [['no_penetapan'], 'string', 'max' => 64],
            [['memerintahkan', 'jabatan_jaksa'], 'string', 'max' => 200],
            [['nip_jaksa'], 'string', 'max' => 20],
            [['nama_jaksa'], 'string', 'max' => 128],
            [['jenis_cara1', 'jenis_cara2'], 'string', 'max' => 10],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_reg_tahanan'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba15' => 'Tgl Ba15',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'no_p16a' => 'No P16a',
            'penetapan' => 'Penetapan',
            'no_penetapan' => 'No Penetapan',
            'tgl_penetapan' => 'Tgl Penetapan',
            'tgl_diterima' => 'Tgl Diterima',
            'no_surat_t7' => 'No Surat T7',
            'tgl_ba4' => 'Tgl Ba4',
            'id_tersangka' => 'Id Tersangka',
            'memerintahkan' => 'Memerintahkan',
            'id_isipenetapan' => 'Id Isipenetapan',
            'nip_jaksa' => 'Nip Jaksa',
            'nama_jaksa' => 'Nama Jaksa',
            'jabatan_jaksa' => 'Jabatan Jaksa',
            'tgl_awal_cara' => 'Tgl Awal Cara',
            'tgl_akhir_cara' => 'Tgl Akhir Cara',
            'jenis_cara1' => 'Jenis Cara1',
            'jenis_cara2' => 'Jenis Cara2',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'pangkat_jaksa' => 'Pangkat Jaksa',
        ];
    }
}
