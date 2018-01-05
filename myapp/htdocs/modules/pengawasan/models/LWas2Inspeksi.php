<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_2_inspeksi".
 *
 * @property string $id_tingkat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $no_register
 * @property integer $id_sp_was2
 * @property integer $id_ba_was2
 * @property integer $id_l_was2
 * @property integer $id_wilayah
 * @property integer $id_level1
 * @property integer $id_level2
 * @property integer $id_level3
 * @property integer $id_level4
 * @property string $tanggal_l_was_2
 * @property string $tempat_l_was_2
 * @property string $isi_permasalahan
 * @property string $isi_data
 * @property string $isi_analisa
 * @property string $isi_kesimpulan
 * @property string $isi_pendapat
 * @property string $isi_pendapat_pasal_pelanggaran
 * @property string $isi_pertimbangan
 * @property string $isi_saran
 * @property string $file_l_was_2
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property integer $updated_by
 * @property string $updated_ip
 * @property string $updated_time
 */
class LWas2Inspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_2_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_wilayah', 'id_level1'], 'required'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_l_was_2', 'created_time', 'updated_time'], 'safe'],
            [['isi_permasalahan', 'isi_data', 'isi_analisa', 'isi_kesimpulan', 'isi_pendapat', 'isi_pertimbangan', 'isi_saran'], 'string'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['tempat_l_was_2'], 'string', 'max' => 50],
            [['isi_pendapat_pasal_pelanggaran', 'file_l_was_2'], 'string', 'max' => 100],
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
            'id_wilayah' => 'Id Wilayah',
            'id_level1' => 'Id Level1',
            'id_level2' => 'Id Level2',
            'id_level3' => 'Id Level3',
            'id_level4' => 'Id Level4',
            'tanggal_l_was_2' => 'Tanggal L Was 2',
            'tempat_l_was_2' => 'Tempat L Was 2',
            'isi_permasalahan' => 'Isi Permasalahan',
            'isi_data' => 'Isi Data',
            'isi_analisa' => 'Isi Analisa',
            'isi_kesimpulan' => 'Isi Kesimpulan',
            'isi_pendapat' => 'Isi Pendapat',
            'isi_pendapat_pasal_pelanggaran' => 'Isi Pendapat Pasal Pelanggaran',
            'isi_pertimbangan' => 'Isi Pertimbangan',
            'isi_saran' => 'Isi Saran',
            'file_l_was_2' => 'File L Was 2',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
            'updated_time' => 'Updated Time',
        ];
    }
}
