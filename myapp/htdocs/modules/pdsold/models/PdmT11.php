<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t11".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t11
 * @property string $tgl_sp_penahanan
 * @property string $no_sp_penahanan
 * @property string $dasar
 * @property string $dokter
 * @property string $tempat_periksa
 * @property string $tempat_rs
 * @property string $tgl_pemeriksaan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $id_tersangka
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property integer $updated_by
 * @property string $updated_ip
 * @property string $updated_time
 *
 * @property PdmTahapDua $noRegisterPerkara
 */
class PdmT11 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t11'], 'required'],
            [['tgl_sp_penahanan', 'tgl_pemeriksaan', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['dasar'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara', 'id_tersangka'], 'string', 'max' => 30],
            [['no_surat_t11'], 'string', 'max' => 50],
            [['no_sp_penahanan', 'tempat_rs', 'dikeluarkan', 'id_penandatangan'], 'string', 'max' => 32],
            [['peg_nip'], 'string', 'max' => 64],
            [['tempat_periksa'], 'string', 'max' => 128],
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
            'no_surat_t11' => 'No Surat T11',
            'tgl_sp_penahanan' => 'Tgl Sp Penahanan',
            'no_sp_penahanan' => 'No Sp Penahanan',
            'dasar' => 'Dasar',
            'dokter' => 'Dokter',
            'tempat_periksa' => 'Tempat Periksa',
            'tempat_rs' => 'Tempat Rs',
            'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'id_tersangka' => 'Id Tersangka',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
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