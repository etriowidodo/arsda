<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backup_config".
 *
 * @property integer $id
 * @property string $host
 * @property string $db
 * @property string $port
 * @property string $schema
 * @property string $username
 * @property string $password
 * @property string $target_file
 * @property string $command_path
 * @property string $command_args
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class BackupConfig extends \yii\db\ActiveRecord
{
    public $restore_path;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backup_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host', 'db', 'port', 'username', 'password', 'target_file', 'command_path', 'command_args'], 'required'],
            [['host', 'db', 'port', 'schema', 'username', 'password', 'target_file', 'command_path', 'command_args'], 'string'],
            [['createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host' => 'Host',
            'db' => 'Db',
            'port' => 'Port',
            'schema' => 'Schema',
            'username' => 'Username',
            'password' => 'Password',
            'target_file' => 'Target File',
            'command_path' => 'Command Path',
            'command_args' => 'Command Args',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
