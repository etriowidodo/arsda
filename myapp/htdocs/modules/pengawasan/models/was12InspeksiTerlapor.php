<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_12".
 *
 * @property string $id_was10
 * @property string $id_was_12
 * @property string $tanggal_was12
 * @property string $perihal_was12
 * @property string $lampiran_was12
 * @property string $kepada_was12
 * @property string $di_was12
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $was12_file
 * @property integer $sifat_surat
 * @property string $jbtn_penandatangan
 * @property string $no_surat
 * @property string $inst_satkerkd
 */
class Was12InspeksiTerlapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was12_inspeksi_terlapor';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['tanggal_pemeriksaan','jam_pemeriksaan','created_time','updated_time'], 'safe'],
            [['id_was_12','id_surat_was10','created_by','updated_by','id_sp_was2','id_pegawai_terlapor','id_was12_terlapor'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['hari_pemeriksaan'], 'string', 'max' => 20],
            [['golongan_pegawai_terlapor','golongan_pemeriksa'], 'string', 'max' => 50],
            [['nama_pegawai_terlapor','nama_pemeriksa'], 'string', 'max' => 65],
            [['pangkat_pegawai_terlapor'], 'string', 'max' => 30],
            [['satker_pemeriksaan'], 'string', 'max' => 70],
            [['nip_pegawai_terlapor','nip_pemeriksa'], 'string', 'max' => 18],
            [['jabatan_pemeriksa', 'jabatan_pegawai_terlapor','pangkat_pemeriksa','tempat_pemeriksaan'], 'string', 'max' => 100],
            [['nrp_pegawai_terlapor','nrp_pemeriksa'], 'string', 'max' => 10],
			[['created_ip','updated_ip'], 'string', 'max' => 15],
            [['id_tingkat','id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register' => 'no_register',
            
        ];
    }
}
