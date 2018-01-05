<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_saksi_ahli".
 *
 * @property string $id_saksi_ahli
 * @property string $nama
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property integer $id_jkl
 * @property string $warganegara
 * @property string $alamat
 * @property string $no_identitas
 * @property string $pekerjaan
 * @property integer $id_agama
 * @property integer $id_pendidikan
 * @property string $flag
 *
 * @property PdmBa3[] $pdmBa3s
 */
class PdmMsSaksiAhli extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_saksi_ahli';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_saksi_ahli', 'nama'], 'required'],
            [['tgl_lahir'], 'safe'],
            [['id_jkl', 'id_agama', 'id_pendidikan'], 'integer'],
            [['id_saksi_ahli'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
            [['tmpt_lahir', 'warganegara'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 128],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_saksi_ahli' => 'Id Saksi Ahli',
            'nama' => 'Nama',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'id_jkl' => 'Id Jkl',
            'warganegara' => 'Warganegara',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'pekerjaan' => 'Pekerjaan',
            'id_agama' => 'Id Agama',
            'id_pendidikan' => 'Id Pendidikan',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmBa3s()
    {
        return $this->hasMany(PdmBa3::className(), ['id_ms_saksi_ahli' => 'id_saksi_ahli']);
    }
}
