<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tut_surat_tersangka".
 *
 * @property string $id_pds_tut_surat_tersangka
 * @property string $id_pds_tut_surat
 * @property integer $no_urut
 * @property string $id_tersangka
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $flag
 */
class PdsTutSuratTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tut_surat_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tut_surat'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tut_surat_tersangka', 'id_pds_tut_surat'], 'string', 'max' => 25],
            [['id_tersangka', 'create_by', 'update_by'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tut_surat_tersangka' => 'Id Pds Tut Surat Tersangka',
            'id_pds_tut_surat' => 'Id Pds Tut Surat',
            'no_urut' => 'No Urut',
            'id_tersangka' => 'Id Tersangka',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'flag' => 'Flag',
        ];
    }
    

    public function getTersangka()
    {
    	return $this->hasOne(PdsTutTersangka::className(), [ 'id_pds_tut_tersangka' => 'id_tersangka'	]);
    }
}
