<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_renlid".
 *
 * @property string $id_pds_lid_renlid
 * @property string $id_pds_lid_surat
 * @property integer $no_urut
 * @property string $laporan
 * @property string $kasus_posisi
 * @property string $dugaan_pasal
 * @property string $alat_bukti
 * @property string $sumber
 * @property string $pelaksana
 * @property string $tindakan_hukum
 * @property string $koor_dan_dal
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $waktu_tempat
 */
class PdsLidRenlidforP3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_renlid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat','laporan','kasus_posisi','dugaan_pasal','alat_bukti','sumber','pelaksana','tindakan_hukum','waktu_tempat','koor_dan_dal','keterangan'], 'required'],
            [['no_urut'], 'integer'],
            [['laporan', 'kasus_posisi', 'dugaan_pasal', 'alat_bukti', 'sumber', 'pelaksana', 'tindakan_hukum', 'koor_dan_dal', 'keterangan'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_lid_renlid', 'id_pds_lid_surat'], 'string', 'max' => 25],
            [['create_by', 'update_by'], 'string', 'max' => 20],
            [['waktu_tempat'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_renlid' => 'Id Pds Lid Renlid',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'no_urut' => 'No Urut',
            'laporan' => 'Laporan',
            'kasus_posisi' => 'Kasus Posisi',
            'dugaan_pasal' => 'Dugaan Pasal',
            'alat_bukti' => 'Alat Bukti',
            'sumber' => 'Sumber',
            'pelaksana' => 'Pelaksana',
            'tindakan_hukum' => 'Tindakan Hukum',
            'koor_dan_dal' => 'Koor Dan Dal',
            'keterangan' => 'Keterangan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'waktu_tempat' => 'Waktu dan Tempat',
        ];
    }
}
