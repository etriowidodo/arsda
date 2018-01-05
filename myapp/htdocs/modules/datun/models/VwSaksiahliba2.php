<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_saksiahliba2".
 *
 * @property string $id_perkara
 * @property string $nama
 * @property string $alamat
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 */
class VwSaksiahliba2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_saksiahliba2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir'], 'safe'],
            [['id_perkara'], 'string', 'max' => 16],
            [['nama'], 'string', 'max' => 255],
            [['alamat'], 'string', 'max' => 128],
            [['tmpt_lahir'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
        ];
    }
}
