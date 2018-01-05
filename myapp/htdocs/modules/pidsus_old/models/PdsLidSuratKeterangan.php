<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_lid_surat_keterangan".
 *
 * @property string $id_pds_lid_surat_keterangan
 * @property string $id_pds_lid_surat
 * @property integer $no_urut
 * @property string $pertanyaan
 * @property string $jawaban
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsLidSuratKeterangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_lid_surat_keterangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['pertanyaan', 'jawaban'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_lid_surat_keterangan', 'id_pds_lid_surat'], 'string', 'max' => 25],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_lid_surat_keterangan' => 'Id Pds Lid Surat Keterangan',
            'id_pds_lid_surat' => 'Id Pds Lid Surat',
            'no_urut' => 'No Urut',
            'pertanyaan' => 'Pertanyaan',
            'jawaban' => 'Jawaban',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
