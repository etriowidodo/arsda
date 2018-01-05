<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat_detail".
 *
 * @property string $id_pds_tut_surat_detail
 * @property string $id_pds_tut_surat
 * @property string $tipe_surat_detail
 * @property integer $no_urut
 * @property integer $sub_no_urut
 * @property string $isi_surat_detail
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutSuratDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_no_urut','isi_surat_detail', 'id_pds_tut_surat', 'tipe_surat_detail'], 'required'],
            [['no_urut', 'sub_no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_surat_detail', 'id_pds_tut_surat'], 'string', 'max' => 25],
            [['tipe_surat_detail'], 'string', 'max' => 15],
            [['isi_surat_detail'], 'string', 'max' => 4000],
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
            'id_pds_tut_surat_detail' => 'Id Pds Tut Surat Detail',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'tipe_surat_detail' => 'Tipe Surat Detail',
            'no_urut' => 'No Urut',
            'sub_no_urut' => 'No Urut',
            'isi_surat_detail' => 'Field',
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
