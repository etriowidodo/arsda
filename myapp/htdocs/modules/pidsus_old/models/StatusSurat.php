<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "pidsus.status_surat".
 *
 * @property string $id_jenis_surat
 * @property integer $id_status
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_date
 * @property string $updated_by
 * @property string $title
 */
class StatusSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidsus.status_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_surat'], 'required'],
            [['id_status'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['id_jenis_surat'], 'string', 'max' => 10],
            [['created_by', 'updated_by'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_surat' => 'Id Jenis Surat',
            'id_status' => 'Id Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'title' => 'Title',
        ];
    }
}
