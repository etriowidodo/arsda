<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat".
 *
 * @property string $id_pds_tut_surat
 * @property string $id_pds_tut
 * @property string $id_jenis_surat
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_last_surat
 * @property string $lokasi_surat
 * @property integer $sifat_surat
 * @property string $lampiran_surat
 * @property string $perihal_lap
 * @property string $kepada
 * @property string $kepada_lokasi
 * @property string $kepada_melalui
 * @property string $id_ttd
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $id_pds_tut_surat_parent
 * @property integer $id_status
 * @property string $jam_surat
 * @property string $create_ip
 * @property string $update_ip
 * @property string $dari
 * @property string $flag
 */
class PdsTutSuratforP43 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tut', 'id_jenis_surat','no_surat','sifat_surat','lampiran_surat','perihal_lap','lokasi_surat','tgl_surat','kepada','kepada_lokasi','id_ttd'], 'required'],
            [['tgl_surat','tgl_last_surat', 'create_date', 'update_date', 'jam_surat'], 'safe'],
            [['sifat_surat', 'id_status'], 'integer'],
            [['id_pds_tut_surat', 'id_pds_tut', 'id_jenis_surat', 'id_pds_tut_surat_parent'], 'string', 'max' => 25],
            [['no_surat'], 'string', 'max' => 50],
            [['lokasi_surat', 'lampiran_surat', 'dari'], 'string', 'max' => 100],
            [['perihal_lap', 'kepada', 'kepada_lokasi','kepada_melalui'], 'string', 'max' => 200],
            [['id_ttd', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['create_ip', 'update_ip'], 'string', 'max' => 45],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'id_pds_tut' => 'Id Pds Tut',
            'id_jenis_surat' => 'Id Jenis Surat',
            'no_surat' => 'Nomor Surat',
            'tgl_surat' => 'Tanggal Surat',
            'lokasi_surat' => 'Lokasi Surat',
            'sifat_surat' => 'Sifat Surat',
            'lampiran_surat' => 'Lampiran',
            'perihal_lap' => 'Perihal',
            'kepada' => 'Kepada',
            'kepada_lokasi' => 'Di',
            'id_ttd' => 'Penandatangan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'id_pds_tut_surat_parent' => 'Id Pds Tut Surat Parent',
            'id_status' => 'Id Status',
            'jam_surat' => 'Jam Surat',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'dari' => 'Dari',
            'flag' => 'Flag',
            'kepada_melalui' => 'Kepada Melalui',
        ];
    }
}
