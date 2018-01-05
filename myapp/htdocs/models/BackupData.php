<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backup".
 *
 * @property string $last_backup
 * @property string $file
 */
class BackupData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_backup'], 'required'],
            [['last_backup'], 'safe'],
            [['file'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'last_backup' => 'Last Backup',
            'file' => 'File',
        ];
    }
}
