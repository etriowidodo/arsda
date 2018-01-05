<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_surat".
 *
 * @property string $id_pds_lid_surat
 * @property string $id_pds_lid
 * @property string $id_jenis_surat
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_last_surat
 * @property string $lokasi_surat
 * @property string $sifat_surat
 * @property string $lampiran_surat
 * @property string $perihal_lap
 * @property string $kepada
 * @property string $kepada_lokasi
 * @property string $id_ttd
 * @property string $create_by
 * @property string $create_ip
 * @property string $update_ip
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $id_pds_lid_surat_parent
 * @property integer $id_status
 * @property string $jam_surat
 * @property string $dari
 */
class PdsLidSuratforPidsus11 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid', 'id_jenis_surat','tgl_surat','jam_surat'], 'required'],
            [['tgl_surat', 'tgl_last_surat', 'create_date', 'update_date', 'jam_surat'], 'safe'],
            [['id_status','sifat_surat'], 'integer'],
            [['id_pds_lid_surat', 'id_pds_lid', 'id_jenis_surat', 'id_pds_lid_surat_parent'], 'string', 'max' => 25],
            [['no_surat'], 'string', 'max' => 50],
            [['create_ip','update_ip'], 'string', 'max' => 45],
            [['lokasi_surat',  'lampiran_surat','dari'], 'string', 'max' => 100],
            [['perihal_lap', 'kepada', 'kepada_lokasi'], 'string', 'max' => 200],
            [['id_ttd','id_ttd2'], 'string', 'max' => 20],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'id_pds_lid' => 'Id Pds Lid',
            'id_jenis_surat' => 'Id Jenis Surat',
            'no_surat' => 'Nomor Surat',
            'tgl_surat' => 'Tanggal Surat',
            'lokasi_surat' => 'Lokasi Surat',
            'sifat_surat' => 'Sifat Surat',
            'lampiran_surat' => 'Lampiran',
            'perihal_lap' => 'Perihal',
            'kepada' => 'Kepada Yth.',
            'kepada_lokasi' => 'Di',
            'id_ttd' => 'Penandatangan',
			'id_ttd2' => 'Id Ttd2',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'id_pds_lid_surat_parent' => 'Id Pds Lid Surat Parent',
            'id_status' => 'Id Status',
            'jam_surat' => 'Jam Surat',
        ];
    }
}
