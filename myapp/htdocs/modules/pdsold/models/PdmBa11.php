<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba11".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t8
 * @property string $tgl_ba11
 * @property string $id_tersangka
 * @property string $no_reg_perkara
 * @property string $no_reg_tahanan
 * @property string $tgl_penahanan
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $tindakan
 * @property integer $id_ms_loktahanan
 * @property string $tgl_mulai
 * @property string $kepala_rutan
 * @property string $id_perkara
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nip_jaksa
 * @property string $nama
 */
class PdmBa11 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t8', 'tgl_ba11', 'id_tersangka', 'tindakan', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba11', 'tgl_penahanan', 'tgl_sp', 'tgl_mulai', 'created_time', 'updated_time'], 'safe'],
            [['id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
            [['no_register_perkara', 'id_perkara'], 'string', 'max' => 30],
            [['no_surat_t8'], 'string', 'max' => 50],
            [['id_tersangka', 'no_reg_perkara', 'no_reg_tahanan', 'no_sp', 'tindakan', 'kepala_rutan'], 'string', 'max' => 32],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nip_jaksa', 'nama'], 'string', 'max' => 255]
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
            'tgl_ba11' => 'Tgl Ba11',
            'id_tersangka' => 'Id Tersangka',
            'no_reg_perkara' => 'No Reg Perkara',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'tgl_penahanan' => 'Tgl Penahanan',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'tindakan' => 'Tindakan',
            'id_ms_loktahanan' => 'Id Ms Loktahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'kepala_rutan' => 'Kepala Rutan',
            'id_perkara' => 'Id Perkara',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nip_jaksa' => 'Nip Jaksa',
            'nama' => 'Nama',
        ];
    }
}
