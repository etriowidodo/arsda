<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba4_tersangka".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba4
 * @property string $id_peneliti
 * @property string $no_reg_tahanan
 * @property string $no_reg_perkara
 * @property string $alasan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property integer $no_urut_tersangka
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
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmTahapDua $noRegisterPerkara
 */
class PdmBa4Tersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba4_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba4', 'no_urut_tersangka', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba4', 'tgl_lahir', 'created_time', 'updated_time'], 'safe'],
            [['alasan'], 'string'],
            [['no_urut_tersangka', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'created_by', 'updated_by'], 'integer'],
            [['umur'], 'number'],
            [['no_register_perkara'], 'string', 'max' => 16],
            [['id_peneliti', 'tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['no_reg_tahanan', 'no_reg_perkara', 'id_penandatangan'], 'string', 'max' => 20],
            [['upload_file'], 'string', 'max' => 128],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba4' => 'Tgl Ba4',
            'id_peneliti' => 'Id Peneliti',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_reg_perkara' => 'No Reg Perkara',
            'alasan' => 'Alasan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'no_urut_tersangka' => 'No Urut Tersangka',
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
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoRegisterPerkara()
    {
        return $this->hasOne(PdmTahapDua::className(), ['no_register_perkara' => 'no_register_perkara']);
    }
}
