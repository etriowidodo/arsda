<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "pengawasan.pdm_trx_pemrosesan".
 *
 * @property string $no_register
 * @property string $id_sys_menu
 * @property string $id_user_login
 * @property string $durasi
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class WasTrxPemrosesan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_trx_pemrosesan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['no_register'], 'required'],
            [['durasi', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register'], 'string', 'max' => 56],
            [['id_sys_menu', 'id_user_login'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1],
            [['user_id'], 'string', 'max' => 4],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_level1','id_level2','id_level3','id_level4','id_wilayah'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register' => 'Id Perkara',
            'id_sys_menu' => 'Id Sys Menu',
            'id_user_login' => 'Id User Login',
            'durasi' => 'Durasi',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
