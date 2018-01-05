<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p32".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p32
 * @property string $no_reg_tahanan
 * @property string $no_reg_bukti
 * @property integer $id_ms_jnspengadilan
 * @property string $tgl_pelimpahan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $alamat_pengadilan
 * @property string $jam
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $lokasi_pengadilan
 */
class PdmP32 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p32';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p32', 'created_by', 'updated_by', 'lokasi_pengadilan'], 'required'],
            [['id_ms_jnspengadilan', 'created_by', 'updated_by'], 'integer'],
            [['tgl_pelimpahan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p32'], 'string', 'max' => 50],
            [['no_reg_tahanan', 'no_reg_bukti', 'dikeluarkan'], 'string', 'max' => 32],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['alamat_pengadilan'], 'string', 'max' => 255],
            [['jam'], 'string', 'max' => 6],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['lokasi_pengadilan'], 'string', 'max' => 70]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p32' => 'No Surat P32',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_reg_bukti' => 'No Reg Bukti',
            'id_ms_jnspengadilan' => 'Id Ms Jnspengadilan',
            'tgl_pelimpahan' => 'Tgl Pelimpahan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'alamat_pengadilan' => 'Alamat Pengadilan',
            'jam' => 'Jam',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'lokasi_pengadilan' => 'Lokasi Pengadilan',
        ];
    }
}
