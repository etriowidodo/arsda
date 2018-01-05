<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_rentut".
 *
 * @property string $id_pds_tut_rentut
 * @property string $id_pds_tut_surat
 * @property integer $no_urut
 * @property string $kasus_posisi
 * @property string $pasal_disangkakan
 * @property string $alat_bukti
 * @property string $tindakan_hukum
 * @property string $waktu_tempat
 * @property string $koor_dan_dal
 * @property string $keterangan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutRentut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_rentut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_pds_tut_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['kasus_posisi', 'pasal_disangkakan', 'alat_bukti', 'tindakan_hukum', 'waktu_tempat', 'koor_dan_dal', 'keterangan'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_rentut', 'id_pds_tut_surat'], 'string', 'max' => 25],
            [['create_by', 'update_by'], 'string', 'max' => 20],
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
            'id_pds_tut_rentut' => 'Id Pds Tut Rentut',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'no_urut' => 'No Urut',
            'kasus_posisi' => 'Kasus Posisi',
            'pasal_disangkakan' => 'Pasal Disangkakan',
            'alat_bukti' => 'Alat Bukti',
            'tindakan_hukum' => 'Tindakan Hukum',
            'waktu_tempat' => 'Waktu Tempat',
            'koor_dan_dal' => 'Koor Dan Dal',
            'keterangan' => 'Keterangan',
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
