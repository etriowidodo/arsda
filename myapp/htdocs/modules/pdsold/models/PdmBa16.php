<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba16".
 *
 * @property string $id_ba16
 * @property string $id_perkara
 * @property string $tgl_surat
 * @property string $id_tersangka
 * @property string $nama1
 * @property integer $umur1
 * @property string $pekerjaan1
 * @property string $nama2
 * @property integer $umur2
 * @property string $pekerjaan2
 * @property string $penggeledahan
 * @property string $nama_geledah
 * @property string $alamat_geledah
 * @property string $pekerjaan_geledah
 * @property string $penyitaan
 * @property string $nama_sita
 * @property string $alamat_sita
 * @property string $pekerjaan_sita
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 */
class PdmBa16 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba16'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['umur1', 'umur2', 'created_by', 'updated_by'], 'integer'],
            [['penggeledahan', 'penyitaan'], 'string'],
            [['id_ba16', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['nama1', 'pekerjaan1', 'nama2', 'pekerjaan2', 'nama_geledah', 'nama_sita', 'pekerjaan_sita'], 'string', 'max' => 64],
            [['alamat_geledah', 'alamat_sita'], 'string', 'max' => 128],
            [['pekerjaan_geledah'], 'string', 'max' => 100],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba16' => 'Id Ba16',
            'id_perkara' => 'Id Perkara',
            'tgl_surat' => 'Tgl Surat',
            'id_tersangka' => 'Id Tersangka',
            'nama1' => 'Nama1',
            'umur1' => 'Umur1',
            'pekerjaan1' => 'Pekerjaan1',
            'nama2' => 'Nama2',
            'umur2' => 'Umur2',
            'pekerjaan2' => 'Pekerjaan2',
            'penggeledahan' => 'Penggeledahan',
            'nama_geledah' => 'Nama Geledah',
            'alamat_geledah' => 'Alamat Geledah',
            'pekerjaan_geledah' => 'Pekerjaan Geledah',
            'penyitaan' => 'Penyitaan',
            'nama_sita' => 'Nama Sita',
            'alamat_sita' => 'Alamat Sita',
            'pekerjaan_sita' => 'Pekerjaan Sita',
            'flag' => 'Flag',
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
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
