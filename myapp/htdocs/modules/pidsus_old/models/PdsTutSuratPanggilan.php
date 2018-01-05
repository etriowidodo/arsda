<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat_panggilan".
 *
 * @property string $id_pds_tut_surat_panggilan
 * @property string $id_pds_tut_surat
 * @property string $jenis_terpanggil
 * @property string $id_terpanggil
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 * @property string $nama_terpanggil
 */
class PdsTutSuratPanggilan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat_panggilan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_pds_tut_surat'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_surat_panggilan', 'id_pds_tut_surat', 'id_terpanggil'], 'string', 'max' => 25],
            [['keterangan'], 'string', 'max' => 500],
            [['nama_terpanggil'], 'string', 'max' => 100],
            [['create_ip', 'update_ip'], 'string', 'max' => 45],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_surat_panggilan' => 'Id Pds Tut Surat Saksi',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'no_urut' => 'No Urut',
            'id_saksi' => 'Id Saksi',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'flag' => 'Flag',
        ];
    }
}
