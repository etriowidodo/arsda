<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.pds_tembusan".
 *
 * @property string $id_pds_tembusan
 * @property string $id_pds_surat
 * @property integer $no_urut
 * @property string $tembusan
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class PdsTembusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.pds_tembusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_tembusan'], 'required'],
            [['no_urut'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['id_pds_tembusan', 'id_pds_surat'], 'string', 'max' => 25],
            [['tembusan'], 'string', 'max' => 150],
            [['create_by', 'update_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pds_tembusan' => 'Id Pds Tembusan',
            'id_pds_surat' => 'Id Pds Surat',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
