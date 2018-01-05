<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_tersangka_pt".
 *
 * @property string $id_tersangka
 * @property string $id_perpanjangan
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
 * @property integer $no_urut
 * @property string $no_surat_penahanan
 */
class MsTersangkaPt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_tersangka_pt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka', 'id_perpanjangan', 'no_surat_penahanan'], 'required'],
            [['suku','no_identitas','umur','pekerjaan','alamat','id_identitas','tmpt_lahir','tgl_lahir','warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan','nama','no_urut'], 'required'],
            [['suku','no_identitas','umur','pekerjaan','alamat','id_identitas','tmpt_lahir','tgl_lahir','warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan','nama','no_urut','no_surat_penahanan'], 'required'],
            [['tgl_lahir'], 'safe'],
            [['warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'no_urut'], 'integer'],
            [['umur'], 'number'],
            [['id_tersangka'], 'string', 'max' => 126],
            [['id_perpanjangan'], 'string', 'max' => 121],
            [['tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan', 'no_surat_penahanan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
            [['id_tersangka'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tersangka' => 'Id Tersangka',
            'id_perpanjangan' => 'Id Perpanjangan',
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
            'no_urut' => 'No Urut',
            'no_surat_penahanan' => 'No Surat Penahanan',
        ];
    }
}
