<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_surat_penyitaan".
 *
 * @property string $id_pds_dik_surat_penyitaan
 * @property string $id_pds_dik_surat
 * @property integer $no_urut
 * @property string $nama_jabatan
 * @property string $tempat_lokasi
 * @property string $dari_dan_tempat
 * @property string $id_jaksa_pelaksana
 * @property string $waktu_pelaksanaan
 * @property string $keperluan
 * @property string $flag
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsDikSuratPenyitaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_surat_penyitaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date','waktu_pelaksanaan'], 'safe'],
            [['id_pds_dik_surat_penyitaan', 'id_pds_dik_surat'], 'string', 'max' => 25],
            [['flag'], 'string', 'max' => 1],
            [['nama_jabatan'], 'string', 'max' => 100],
            [['tempat_lokasi','dari_dan_tempat'], 'string', 'max' => 500],
            [['keterangan','keperluan'], 'string', 'max' => 4000],
            [['create_by', 'update_by','id_jaksa_pelaksana'], 'string', 'max' => 20]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik_surat_pemanggilan' => 'Id Pds Dik Surat Panggilan',
            
        ];
    }
    
    public function getPegawai()
    {
    	return $this->hasOne(KpPegawai::className(), ['peg_nik' => 'id_jaksa_pelaksana']);
    }
}
