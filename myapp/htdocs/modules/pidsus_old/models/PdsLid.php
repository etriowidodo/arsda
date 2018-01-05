<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid".
 *
 * @property string $id_pds_lid
 * @property string $id_satker
 * @property string $id_satker_kirim
 * @property string $no_lap
 * @property string $tgl_diterima
 * @property string $penerima_lap
 * @property string $lokasi_lap
 * @property string $pelapor
 * @property string $perihal_lap
 * @property string $asal_surat_lap
 * @property string $no_surat_lap
 * @property string $tgl_lap
 * @property string $isi_surat_lap
 * @property string $uraian_surat_lap
 * @property string $penandatangan_lap
 * @property string $create_by
 * @property string $create_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $update_by
 * @property string $update_date
 * @property integer $id_status
 * @property integer $jenis_kasus
 */
class PdsLid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_satker'], 'required'],
            [['tgl_diterima', 'tgl_lap', 'create_date', 'update_date'], 'safe'],
            [['id_status','jenis_kasus','status_selesai'], 'integer'],
            [['id_pds_lid', 'no_lap'], 'string', 'max' => 25],
            [['id_satker','id_satker_kirim', 'penandatangan_lap'], 'string', 'max' => 10],
            [['penerima_lap', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['lokasi_lap'], 'string', 'max' => 100],
            [['pelapor', 'perihal_lap'], 'string', 'max' => 2000],
            [['asal_surat_lap'], 'string', 'max' => 150],
            [['no_surat_lap'], 'string', 'max' => 50],
            [['create_ip','update_ip'], 'string', 'max' => 45],
            [['isi_surat_lap', 'uraian_surat_lap'], 'string', 'max' => 4000],
            [['flag_dirahasiakan','is_final'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid' => 'Id Pds Lid',
            'id_satker' => 'Id Satker',
            'no_lap' => 'No Lap',
            'tgl_diterima' => 'Tgl Diterima',
            'penerima_lap' => 'Penerima Lap',
            'lokasi_lap' => 'Lokasi Lap',
            'pelapor' => 'Pelapor',
            'perihal_lap' => 'Perihal Lap',
            'asal_surat_lap' => 'Asal Surat Lap',
            'no_surat_lap' => 'No Surat Lap',
            'tgl_lap' => 'Tgl Lap',
            'isi_surat_lap' => 'Isi Surat Lap',
            'uraian_surat_lap' => 'Uraian Surat Lap',
            'penandatangan_lap' => 'Penandatangan Lap',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'id_status' => 'Id Status',
            'jenis_kasus' => 'Jenis kasus',
            'flag_dirahasiakan' => 'Flag dirahasiakan',
            'is_final' => 'Final Status',
            'status_selesai' => 'Penyelesaian',
        ];
    }
    

    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), ['peg_nik' => 'kepada']);
    }
}
