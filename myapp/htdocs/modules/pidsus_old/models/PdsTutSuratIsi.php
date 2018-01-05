<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat_isi".
 *
 * @property string $id_pds_tut_surat_isi
 * @property string $id_pds_tut_surat
 * @property string $label_isi_surat
 * @property string $isi_surat
 * @property string $jenis_field
 * @property string $sql_ddl
 * @property string $create_by
 * @property string $create_date
 * @property string $start_date
 * @property string $end_date
 * @property string $update_by
 * @property string $update_date
 * @property integer $no_urut
 * @property string $create_ip
 * @property string $update_ip
 * @property string $flag
 */
class PdsTutSuratIsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat_isi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'isi_surat','id_pds_tut_surat'], 'required'],
            [['isi_surat'], 'string'],
            [['create_date', 'update_date','start_date','end_date'], 'safe'],
            [['no_urut'], 'integer'],
            [['id_pds_tut_surat_isi', 'id_pds_tut_surat'], 'string', 'max' => 25],
            [['label_isi_surat'], 'string', 'max' => 50],
            [['jenis_field'], 'string', 'max' => 15],
            [['sql_ddl'], 'string', 'max' => 1000],
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
            'id_pds_tut_surat_isi' => 'Id Pds Tut Surat Isi',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'label_isi_surat' => 'Label Isi Surat',
            'isi_surat' => 'Field',
            'jenis_field' => 'Jenis Field',
            'sql_ddl' => 'Sql Ddl',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'no_urut' => 'No Urut',
            'create_ip' => 'Create Ip',
            'update_ip' => 'Update Ip',
            'flag' => 'Flag',
        ];
    }
}
