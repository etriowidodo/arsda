<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_trx_pemrosesan".
 *
 * @property string $id_perkara
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
class PdmTrxPemrosesan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_trx_pemrosesan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara'], 'required'],
            [['durasi', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_perkara','no_register_perkara'], 'string', 'max' => 56],
            [['id_sys_menu', 'id_user_login'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
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
