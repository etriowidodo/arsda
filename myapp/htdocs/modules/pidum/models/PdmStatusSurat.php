<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_status_surat".
 *
 * @property string $id_perkara
 * @property string $id_sys_menu
 * @property string $id_user_login
 * @property string $durasi
 * @property string $flag
 */
class PdmStatusSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_status_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'id_sys_menu', 'id_user_login', 'durasi'], 'required'],
            [['durasi'], 'safe'],
            [['id_perkara'], 'string', 'max' => 56],
            [['id_sys_menu', 'id_user_login'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
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
        ];
    }
}
