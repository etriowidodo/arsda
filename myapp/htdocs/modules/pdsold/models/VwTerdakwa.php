<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_terdakwa".
 *
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property string $nama
 * @property string $alamat
 * @property string $is_agama
 * @property string $is_identitas
 * @property string $is_jkl
 * @property string $tgl_lahir
 * @property string $tmpt_lahir
 * @property string $pekerjaan
 * @property string $is_pendidikan
 * @property string $warganegara
 */
class VwTerdakwa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_terdakwa';
    }

    /**
     * @return string
     */
    public static function primaryKey()
    {
        return ['id_perkara'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir'], 'safe'],
            [['id_perkara', 'id_tersangka', 'is_jkl'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
            [['alamat'], 'string', 'max' => 128],
            [['is_agama', 'is_identitas', 'is_pendidikan'], 'string', 'max' => 50],
            [['tmpt_lahir', 'warganegara'], 'string', 'max' => 32],
            [['pekerjaan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'is_agama' => 'Is Agama',
            'is_identitas' => 'Is Identitas',
            'is_jkl' => 'Is Jkl',
            'tgl_lahir' => 'Tgl Lahir',
            'tmpt_lahir' => 'Tmpt Lahir',
            'pekerjaan' => 'Pekerjaan',
            'is_pendidikan' => 'Is Pendidikan',
            'warganegara' => 'Warganegara',
        ];
    }
}
