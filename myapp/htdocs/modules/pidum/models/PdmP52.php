<?php

namespace app\modules\pidum\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pidum.pdm_p52".
 *
 * @property string $id_p52
 * @property string $id_perkara
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $stat_kawin
 * @property string $ortu
 * @property string $tgl_jth_pidana
 * @property string $no_put_penjara
 * @property string $tgl_put_penjara
 * @property string $syarat_bina
 * @property string $tgl_lepas_syarat
 * @property string $tgl_pelaksanaan
 * @property string $kejari_pengawas
 * @property string $balai_bapas
 * @property string $keterangan
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
class PdmP52 extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p52';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p52', 'id_tersangka'], 'required'],
            [['tgl_dikeluarkan', 'tgl_jth_pidana', 'tgl_put_penjara', 'tgl_lepas_syarat', 'tgl_pelaksanaan', 'created_time', 'updated_time'], 'safe'],
            [['keterangan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p52', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['stat_kawin'], 'string', 'max' => 32],
            [['ortu', 'no_put_penjara', 'syarat_bina', 'kejari_pengawas', 'balai_bapas'], 'string', 'max' => 128],
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
            'id_p52' => 'Id P52',
            'id_perkara' => 'Id Perkara',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'stat_kawin' => 'Stat Kawin',
            'ortu' => 'Ortu',
            'tgl_jth_pidana' => 'Tgl Jth Pidana',
            'no_put_penjara' => 'No Put Penjara',
            'tgl_put_penjara' => 'Tgl Put Penjara',
            'syarat_bina' => 'Syarat Bina',
            'tgl_lepas_syarat' => 'Tgl Lepas Syarat',
            'tgl_pelaksanaan' => 'Tgl Pelaksanaan',
            'kejari_pengawas' => 'Kejari Pengawas',
            'balai_bapas' => 'Balai Bapas',
            'keterangan' => 'Keterangan',
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
     * @return ActiveQuery
     */
    public function getIdTersangka()
    {
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
