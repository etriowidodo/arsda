<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.lookup_item".
 *
 * @property string $kd_lookup_group
 * @property string $kd_lookup_item
 * @property string $nm_lookup_item
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class LookupItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.lookup_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_lookup_group', 'kd_lookup_item'], 'required'],
            [['is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['kd_lookup_group'], 'string', 'max' => 2],
            [['kd_lookup_item'], 'string', 'max' => 1],
            [['nm_lookup_item'], 'string', 'max' => 225],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_lookup_group' => 'Kd Lookup Group',
            'kd_lookup_item' => 'Kd Lookup Item',
            'nm_lookup_item' => 'Nm Lookup Item',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
