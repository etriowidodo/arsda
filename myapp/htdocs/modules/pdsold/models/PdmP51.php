<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p51".
 *
 * @property string $id_p51
 * @property string $id_perkara
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $stat_kawin
 * @property string $ortu
 * @property string $tgl_jth_pidana
 * @property string $tgl_hkm_tetap
 * @property string $denda
 * @property string $pokok
 * @property string $tambahan
 * @property string $percobaan
 * @property string $tgl_awal_coba
 * @property string $tgl_akhir_coba
 * @property string $syarat
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property MsTersangka $idTersangka
 * @property PdmSpdp $idPerkara
 */
class PdmP51 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p51';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p51', 'id_tersangka'], 'required'],
            [['tgl_dikeluarkan', 'tgl_jth_pidana', 'tgl_hkm_tetap', 'tgl_awal_coba', 'tgl_akhir_coba', 'created_time', 'updated_time'], 'safe'],
            [['denda', 'pokok'], 'number'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p51', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['dikeluarkan', 'tambahan', 'percobaan'], 'string', 'max' => 64],
            [['stat_kawin'], 'string', 'max' => 32],
            [['ortu', 'syarat'], 'string', 'max' => 128],
            [['id_penandatangan'], 'string', 'max' => 20],
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
            'id_p51' => 'Id P51',
            'id_perkara' => 'Id Perkara',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'stat_kawin' => 'Stat Kawin',
            'ortu' => 'Ortu',
            'tgl_jth_pidana' => 'Tgl Jth Pidana',
            'tgl_hkm_tetap' => 'Tgl Hkm Tetap',
            'denda' => 'Denda',
            'pokok' => 'Pokok',
            'tambahan' => 'Tambahan',
            'percobaan' => 'Percobaan',
            'tgl_awal_coba' => 'Tgl Awal Coba',
            'tgl_akhir_coba' => 'Tgl Akhir Coba',
            'syarat' => 'Syarat',
            'id_penandatangan' => 'Id Penandatangan',
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
    public function getIdTersangka()
    {
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
