<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_status_data".
 *
 * @property integer $id
 * @property string $nama
 * @property string $keterangan
 * @property string $is_group
 * @property string $flag
 */
class PdmMsStatusData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_status_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_group'], 'required'],
            [['id'], 'integer'],
            [['nama'], 'string', 'max' => 64],
            [['keterangan'], 'string', 'max' => 128],
            [['is_group'], 'string', 'max' => 5],
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
            'nama' => 'Nama',
            'keterangan' => 'Keterangan',
            'is_group' => 'Is Group',
            'flag' => 'Flag',
        ];
    }
}
