<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_matrix_perkara".
 *
 * @property string $id_pds_lid_matrix_perkara
 * @property string $id_pds_lid_surat
 * @property integer $no_urut
 * @property string $kasus_posisi
 * @property string $pasal_disangkakan
 * @property string $uraian_fakta
 * @property string $alat_bukti
 * @property string $barang_bukti
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 * @property string $nama_calon_tersangka
 */
class PdsLidMatrixPerkara extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_matrix_perkara';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_pds_lid_surat'], 'required'],
            [['create_date','update_date'], 'safe'],
            [['no_urut'], 'integer'],
            [['kasus_posisi','pasal_disangkakan','uraian_fakta','alat_bukti','barang_bukti','keterangan'], 'string'],
            [['create_by','update_by'], 'string', 'max' => 20],
            [['id_pds_lid_matrix_perkara', 'id_pds_lid_surat'], 'string', 'max' => 25],
            [['nama_calon_tersangka'], 'string', 'max' => 100],
            [['flag'], 'string', 'max' => 1],
            [['create_ip','update_ip'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        		'no_urut'=>'No',
        		'kasus_posisi'=>'Kasus Posisi',
        		'pasal_disangkakan'=>'Pasal Disangkakan',
        		'uraian_fakta'=>'Uraian Fakta',
        		'alat_bukti'=>'Alat Bukti',
        		'barang_bukti'=>'Barang Bukti',
        		'keterangan'=>'Keterangan',
        ];
    }    
}
