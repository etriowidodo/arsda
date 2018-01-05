<?php

namespace app\modules\pengawasan\models;

use Yii;

class DasarSpWasMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.dasar_sp_was_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_dasar_spwas'], 'string'],
			[['isi_dasar_spwas'], 'required'],
            [['isi_dasar_spwas'], 'string'],
            [['tahun'], 'string', 'max' => 4],
            [['created_by'], 'integer'],
            [['updated_by'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            // 'id_dasar_spwas' => 'Id Dasar Sp Was Master',
            'isi_dasar_spwas' => 'Isi Dasar Sp Was Master',
            'tahun' => 'Tahun Dasar Sp Was',
        ];
    }
}
