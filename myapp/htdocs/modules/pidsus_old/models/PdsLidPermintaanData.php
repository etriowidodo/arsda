<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_permintaan_data".
 *
 * @property string $id_pds_lid_permintaan_data
 * @property string $id_pds_lid_surat
 * @property integer $jenis_permintaan_data
 * @property string $nama_tindakan_lain
 * @property string $nama_instansi
 * @property string $jaksa_pelaksaan
 * @property string $tempat_pelaksanaan
 * @property string $tgl_pelaksanaan
 * @property string $jam_pelaksanaan
 * @property string $keperluan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *  @property string @jabatan
 */
class PdsLidPermintaanData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_permintaan_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat', 'jenis_permintaan_data'], 'required'],
            [['jenis_permintaan_data'], 'integer'],
            [['tgl_pelaksanaan', 'jam_pelaksanaan', 'create_date', 'update_date'], 'safe'],
            [['id_pds_lid_permintaan_data', 'id_pds_lid_surat', 'jaksa_pelaksaan', 'tempat_pelaksanaan'], 'string', 'max' => 25],
            [['nama_tindakan_lain','nama_instansi','jabatan'], 'string', 'max' => 50],
           // [['nama_instansi'], 'string', 'max' => 15],
            [['keperluan'], 'string', 'max' => 4000],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_permintaan_data' => 'Id Pds Lid Permintaan Data',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'jenis_permintaan_data' => 'Jenis Permintaan Data',
            'nama_tindakan_lain' => 'Nama Tindakan Lain',
            'nama_instansi' => 'Nama Instansi',
            'jaksa_pelaksaan' => 'Jaksa Pelaksaan',
            'tempat_pelaksanaan' => 'Tempat Pelaksanaan',
            'tgl_pelaksanaan' => 'Tgl Pelaksanaan',
            'jam_pelaksanaan' => 'Jam Pelaksanaan',
            'keperluan' => 'Keperluan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'jabatan' => 'Jabatan',
        ];
    }
    

    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), [ 'peg_nik' => 'jaksa_pelaksaan'	]);
    }
}
