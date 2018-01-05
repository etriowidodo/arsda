<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_saksi_ahli".
 *
 * @property string $id_p11
 * @property string $id_saksi_ahli
 * @property string $nama
 * @property string $tgl_lahir
 * @property string $tmp_lahir
 * @property string $alamat
 * @property integer $id_ms_agama
 * @property string $pekerjaan
 * @property string $id_perkara
 * @property string $flag
 */
class PdmSaksiAhli extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_saksi_ahli';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir'], 'safe'],
            [['id_ms_agama'], 'integer'],
            [['id_perkara'], 'required'],
            [['id_p11', 'tmp_lahir', 'pekerjaan'], 'string', 'max' => 32],
            [['id_saksi_ahli', 'id_perkara'], 'string', 'max' => 16],
            [['nama'], 'string', 'max' => 64],
            [['alamat'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p11' => 'Id P11',
            'id_saksi_ahli' => 'Id Saksi Ahli',
            'nama' => 'Nama',
            'tgl_lahir' => 'Tgl Lahir',
            'tmp_lahir' => 'Tmp Lahir',
            'alamat' => 'Alamat',
            'id_ms_agama' => 'Id Ms Agama',
            'pekerjaan' => 'Pekerjaan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
        ];
    }
}
