<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik".
 *
 * @property string $id_pds_dik
 * @property string $id_satker
 * @property string $tgl_diterima
 * @property string $penerima_spdp
 * @property string $asal_spdp
 * @property string $perihal_spdp
 * @property string $no_spdp
 * @property string $tgl_spdp
 * @property string $isi_spdp
 * @property string $uraian_spdp
 * @property string $penandatangan_lap
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property integer $id_status
 * @property string $id_satker_parent
 * @property string $no_berkas_perkara
 * @property integer $is_internal
 * @property string $tgl_register_perkara
 * @property string $kasus_posisi
 * @property string $tgl_selesai
 * @property string $create_ip
 * @property string $update_ip
 * @property string $id_pds_lid_parent
 * @property integer $jenis_kasus
 * @property string $id_jenis_surat
 * @property boolean $is_final
 * @property string $flag
 * @property integer $status_selesai
 * @property string $dugaan_pelaku
 */
class PdsDikforP6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_satker','jenis_kasus','asal_spdp','no_spdp','tgl_spdp','tgl_diterima','perihal_spdp','dugaan_pelaku','kasus_posisi','penerima_spdp','atasan_penerima_spdp'], 'required'],
            [['tgl_diterima', 'tgl_spdp', 'create_date', 'update_date', 'tgl_register_perkara', 'tgl_selesai'], 'safe'],
            [['id_status', 'is_internal', 'jenis_kasus', 'status_selesai'], 'integer'],
            [['kasus_posisi'], 'string'],
            [['is_final'], 'boolean'],
            [['id_pds_dik', 'id_pds_lid_parent', 'id_jenis_surat'], 'string', 'max' => 25],
            [['id_satker',  'id_satker_parent'], 'string', 'max' => 10],
            [['penerima_spdp','atasan_penerima_spdp', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['asal_spdp', 'perihal_spdp'], 'string', 'max' => 2000],
            [['no_spdp', 'no_berkas_perkara'], 'string', 'max' => 50],
            [['isi_spdp', 'uraian_spdp'], 'string', 'max' => 4000],
            [['create_ip', 'update_ip'], 'string', 'max' => 45],
            [['flag'], 'string', 'max' => 1],
            [['dugaan_pelaku'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik' => 'Id Pds Dik',
            'id_satker' => 'Id Satker',
            'tgl_diterima' => 'Tanggal Diterima',
            'penerima_spdp' => 'Penerima Laporan',
            'asal_spdp' => 'Asal Spdp',
            'perihal_spdp' => 'Perihal Spdp',
            'no_spdp' => 'Nomor Spdp',
            'tgl_spdp' => 'Tanggal Spdp',
            'isi_spdp' => 'Isi Spdp',
            'uraian_spdp' => 'Uraian Spdp',
            'atasan_penerima_spdp' => 'Atasan Penerima laporan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'id_status' => 'Id Status',
            'id_satker_parent' => 'Id Satker Parent',
            'no_berkas_perkara' => 'No Berkas Perkara',
            'is_internal' => 'Is Internal',
            'tgl_register_perkara' => 'Tgl Register Perkara',
            'kasus_posisi' => 'Kasus Posisi',
            'tgl_selesai' => 'Tgl Selesai',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'id_pds_lid_parent' => 'Id Pds Lid Parent',
            'jenis_kasus' => 'Jenis Kasus',
            'id_jenis_surat' => 'Id Jenis Surat',
            'is_final' => 'Is Final',
            'flag' => 'Flag',
            'status_selesai' => 'Status Selesai',
            'dugaan_pelaku' => 'Dugaan Pelaku',
        ];
    }
}
