<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba19".
 *
 * @property string $id_ba19
 * @property string $id_perkara
 * @property string $tgl_surat
 * @property string $lokasi
 * @property string $berupa
 * @property string $nama
 * @property string $pekerjaan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $diserahkan_kpd
 *
 * @property PdmSpdp $idPerkara
 */
class PdmBa19 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba19';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba19'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['berupa'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_ba19', 'id_perkara'], 'string', 'max' => 16],
            [['lokasi', 'pekerjaan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 100],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['diserahkan_kpd'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba19' => 'Id Ba19',
            'id_perkara' => 'Id Perkara',
            'tgl_surat' => 'Tgl Surat',
            'lokasi' => 'Lokasi',
            'berupa' => 'Berupa',
            'nama' => 'Nama',
            'pekerjaan' => 'Pekerjaan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'diserahkan_kpd' => 'Diserahkan Kpd',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
