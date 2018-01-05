<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_sys_menu".
 *
 * @property integer $id
 * @property string $kd_berkas
 * @property string $no_urut
 * @property integer $durasi
 * @property string $keterangan
 * @property string $url
 * @property integer $id__group_perkara
 * @property string $flag
 */
class PdmSysMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_sys_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'durasi', 'id__group_perkara'], 'integer'],
            [['kd_berkas'], 'string', 'max' => 16],
            [['no_urut'], 'string', 'max' => 4],
            [['keterangan'], 'string', 'max' => 124],
            [['url'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_berkas' => 'Kd Berkas',
            'no_urut' => 'No Urut',
            'durasi' => 'Durasi',
            'keterangan' => 'Keterangan',
            'url' => 'Url',
            'id__group_perkara' => 'Id  Group Perkara',
            'flag' => 'Flag',
        ];
    }
}
