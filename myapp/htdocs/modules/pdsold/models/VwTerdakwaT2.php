<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_terdakwat2".
 *
 * @property string $no_register_perkara
 * @property string $no_reg_tahanan
 * @property integer $no_urut_tersangka
 * @property string $nama
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $is_jkl
 * @property string $alamat
 * @property string $is_agama
 * @property string $pekerjaan
 * @property string $is_pendidikan
 * @property string $is_identitas
 */
class VwTerdakwaT2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_terdakwat2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_urut_tersangka','warganegara'], 'integer'],
            [['tgl_lahir'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t7','warganegara1'], 'string', 'max' => 50],
            [['no_reg_tahanan', 'is_jkl'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
            [['tmpt_lahir'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['umur'], 'number'],
            [['is_agama', 'is_pendidikan', 'is_identitas'], 'string', 'max' => 50],
            [['pekerjaan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_urut_tersangka' => 'No Urut Tersangka',
            'nama' => 'Nama',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'is_jkl' => 'Is Jkl',
            'alamat' => 'Alamat',
            'is_agama' => 'Is Agama',
            'pekerjaan' => 'Pekerjaan',
            'is_pendidikan' => 'Is Pendidikan',
            'is_identitas' => 'Is Identitas',
            'is_identitas' => 'Is Identitas',
            'no_surat_t7' => 'No Surat T7',
            'warganegara1' => 'Warganegara1',
            'warganegara' => 'Warganegara',
        ];
    }
}
