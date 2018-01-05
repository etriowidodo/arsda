<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_27_inspeksi_detail_terlapor".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_was_27_inspeksi
 * @property integer $id_was_27_detail_terlapor
 * @property string $nip_pegawai_terlapor
 * @property string $nrp_pegawai_terlapor
 * @property string $nama_pegawai_terlapor
 * @property string $pangkat_pegawai_terlapor
 * @property string $golongan_pegawai_terlapor
 * @property string $jabatan_pegawai_terlapor
 * @property string $satker_pegawai_terlapor
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was27InspeksiDetailTerlapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_inspeksi_detail_terlapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was_27_inspeksi', 'id_was_27_detail_terlapor'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was_27_inspeksi', 'id_was_27_detail_terlapor', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['nip_pegawai_terlapor'], 'string', 'max' => 18],
            [['nrp_pegawai_terlapor'], 'string', 'max' => 10],
            [['nama_pegawai_terlapor', 'satker_pegawai_terlapor'], 'string', 'max' => 65],
            [['pangkat_pegawai_terlapor'], 'string', 'max' => 30],
            [['golongan_pegawai_terlapor'], 'string', 'max' => 50],
            [['jabatan_pegawai_terlapor'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tingkat' => 'Id Tingkat',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'no_register' => 'No Register',
            'id_sp_was2' => 'Id Sp Was2',
            'id_ba_was2' => 'Id Ba Was2',
            'id_l_was2' => 'Id L Was2',
            'id_was_27_inspeksi' => 'Id Was 27 Inspeksi',
            'id_was_27_detail_terlapor' => 'Id Was 27 Detail Terlapor',
            'nip_pegawai_terlapor' => 'Nip Pegawai Terlapor',
            'nrp_pegawai_terlapor' => 'Nrp Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
