<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_saksi".
 *
 * @property string $no_register_perkara
 * @property integer $no_urut
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $no_identitas
 * @property string $no_hp
 * @property integer $warganegara
 * @property string $pekerjaan
 * @property string $suku
 * @property string $nama
 * @property integer $id_jkl
 * @property integer $id_identitas
 * @property integer $id_agama
 * @property integer $id_pendidikan
 * @property string $umur
 * @property integer $jenis
 * @property string $id_saksi
 */
class PdmMsSaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'jenis', 'id_saksi'], 'required'],
            [['no_urut', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'jenis'], 'integer'],
            [['tgl_lahir'], 'safe'],
            [['umur'], 'number'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
            [['id_saksi'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_urut' => 'No Urut',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'no_hp' => 'No Hp',
            'warganegara' => 'Warganegara',
            'pekerjaan' => 'Pekerjaan',
            'suku' => 'Suku',
            'nama' => 'Nama',
            'id_jkl' => 'Id Jkl',
            'id_identitas' => 'Id Identitas',
            'id_agama' => 'Id Agama',
            'id_pendidikan' => 'Id Pendidikan',
            'umur' => 'Umur',
            'jenis' => 'Jenis',
            'id_saksi' => 'Id Saksi',
        ];
    }
}
