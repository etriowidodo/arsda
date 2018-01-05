<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_u_undang".
 *
 * @property string $uu
 * @property string $deskripsi
 * @property string $tentang
 * @property string $tanggal
 */
class MsUUndang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_u_undang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu','id'], 'required'],
            [['uu','id'], 'unique'],
            [['tanggal'], 'safe'],
            [['uu'], 'string', 'max' => 50],
            [['id'], 'string', 'max' => 2],
            [['jns_tindak_pidana'], 'string', 'max' => 1],
            [['deskripsi'], 'string', 'max' => 255],
            [['tentang'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uu' => 'Uu',
            'id' => 'ID',
            'deskripsi' => 'Deskripsi',
            'tentang' => 'Tentang',
            'tanggal' => 'Tanggal',
        ];
    }
}
