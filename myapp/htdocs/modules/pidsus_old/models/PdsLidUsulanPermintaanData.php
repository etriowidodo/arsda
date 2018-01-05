<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_usulan_permintaan_data".
 *
 * @property string $id_pds_lid_usulan_permintaan_data
 * @property string $id_pds_lid_surat
 * @property string $nama
 * @property string $nama_instansi
 * @property string $waktu_pelaksanaan
 * @property string $jaksa_pelaksanaan
 * @property string $keperluan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsLidUsulanPermintaanData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_usulan_permintaan_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat','waktu_pelaksanaan','jaksa_pelaksanaan','nama', 'nama_instansi','jabatan','keperluan'], 'required'],
            [['create_date','waktu_pelaksanaan', 'update_date'], 'safe'],
            [['id_pds_lid_usulan_permintaan_data', 'id_pds_lid_surat', 'jaksa_pelaksanaan'], 'string', 'max' => 25],
            [['nama', 'nama_instansi','jabatan'], 'string', 'max' => 500],
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
            'id_pds_lid_usulan_permintaan_data' => 'Id Pds Lid Usulan Permintaan Data',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'nama_instansi' => 'Nama Instansi',
            'waktu_pelaksanaan' => 'Waktu Pelaksanaan',
            'jaksa_pelaksanaan' => 'Jaksa Pelaksanaan',
            'keperluan' => 'Keperluan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    

    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), [ 'peg_nik' => 'jaksa_pelaksanaan'	]);
    }
}
