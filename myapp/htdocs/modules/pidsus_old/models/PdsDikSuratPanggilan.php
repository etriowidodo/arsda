<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_surat_panggilan".
 *
 * @property string $id_pds_dik_surat_panggilan
 * @property string $id_pds_dik_surat
 * @property integer $no_urut
 * @property string $nama_lengkap
 * @property string $alamat
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsDikSuratPanggilan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_surat_panggilan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_dik_surat_panggilan', 'id_pds_dik_surat'], 'string', 'max' => 25],
            [['flag'], 'string', 'max' => 1],
            [['nama_lengkap'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 500],
            [['keterangan'], 'string', 'max' => 4000],
            [['create_by', 'update_by'], 'string', 'max' => 20]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik_surat_panggilan' => 'Id Pds Dik Surat Panggilan',
            'id_pds_dik_surat' => 'Id Pds Dik Surat',
            'no_urut' => 'No Urut',
            'nama_lengkap' => 'Nama Lengkap',
            'alamat' => 'Alamat',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'keterangan' => 'Keterangan',
            'flag' =>'flag'
        ];
    }
}
