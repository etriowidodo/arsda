<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_dik_surat_tersangka".
 *
 * @property string $id_pds_dik_surat_tersangka
 * @property string $id_pds_dik_surat
 * @property integer $no_urut
 * @property string $id_tersangka
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsDikSuratTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_dik_surat_tersangka';
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
            [['id_pds_dik_surat_tersangka', 'id_pds_dik_surat'], 'string', 'max' => 25],
            [['flag'], 'string', 'max' => 1],
            [['id_tersangka', 'create_by', 'update_by'], 'string', 'max' => 20]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_dik_surat_tersangka' => 'Id Pds Dik Surat Tersangka',
            'id_pds_dik_surat' => 'Id Pds Dik Surat',
            'no_urut' => 'No Urut',
            'id_tersangka' => 'Id Tersangka',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'flag' =>'flag'
        ];
    }
}
