<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_tersangka_pt".
 *
 * @property string $id_tersangka
 * @property string $id_perkara
 * @property string $nama
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $no_identitas
 * @property string $no_hp
 * @property string $warganegara
 * @property string $pekerjaan
 * @property string $suku
 * @property string $is_agama
 * @property string $is_jkl
 * @property string $is_identitas
 * @property string $is_pendidikan
 * @property string $umur
 */
class VwTersangkaPt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_tersangka_pt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir'], 'safe'],
            [['umur'], 'number'],
            [['id_tersangka'], 'string', 'max' => 60],
            [['id_perkara'], 'string', 'max' => 56],
            [['nama'], 'string', 'max' => 255],
            [['tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['warganegara', 'is_agama', 'is_identitas', 'is_pendidikan'], 'string', 'max' => 50],
            [['pekerjaan'], 'string', 'max' => 64],
            [['is_jkl'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tersangka' => 'Id Tersangka',
            'id_perkara' => 'Id Perkara',
            'nama' => 'Nama',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'no_hp' => 'No Hp',
            'warganegara' => 'Warganegara',
            'pekerjaan' => 'Pekerjaan',
            'suku' => 'Suku',
            'is_agama' => 'Is Agama',
            'is_jkl' => 'Is Jkl',
            'is_identitas' => 'Is Identitas',
            'is_pendidikan' => 'Is Pendidikan',
            'umur' => 'Umur',
        ];
    }
}
