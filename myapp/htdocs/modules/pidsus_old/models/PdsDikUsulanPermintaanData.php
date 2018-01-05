<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_usulan_permintaan_data".
 *
 * @property string $id_pds_dik_usulan_permintaan_data
 * @property string $id_pds_dik_surat
 * @property string $nama
 * @property string $waktu_pelaksanaan
 * @property string $jaksa_pelaksanaan
 * @property string $keperluan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $jabatan_nama
 */
class PdsDikUsulanPermintaanData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_usulan_permintaan_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_surat'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_dik_usulan_permintaan_data', 'id_pds_dik_surat', 'jaksa_pelaksanaan'], 'string', 'max' => 25],
            [['nama', 'waktu_pelaksanaan'], 'string', 'max' => 500],
            [['jabatan_nama'], 'string', 'max' => 100],
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
            'id_pds_dik_usulan_permintaan_data' => 'Id Pds Dik Usulan Permintaan Data',
            'id_pds_dik_surat' => 'Id Pds Dik Surat',
            'nama' => 'Nama',
            'waktu_pelaksanaan' => 'Waktu Pelaksanaan',
            'jaksa_pelaksanaan' => 'Jaksa Pelaksanaan',
            'keperluan' => 'Keperluan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
