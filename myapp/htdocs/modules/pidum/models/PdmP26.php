<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p26".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p26
 * @property string $tgl_ba
 * @property string $no_persetujuan
 * @property string $tgl_persetujuan
 * @property string $id_tersangka
 * @property string $kasus_posisi
 * @property string $pasal_disangka
 * @property string $barbuk
 * @property string $alasan
 * @property string $dikeluarkan
 * @property string $tgl_surat
 * @property string $id_penandatangan
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
class PdmP26 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p26';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p26', 'tgl_ba', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba', 'tgl_persetujuan', 'tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['kasus_posisi', 'pasal_disangka', 'barbuk', 'alasan'], 'string'],
            [['created_by', 'updated_by','no_urut_jaksa_p16a'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p26','no_surat_p16a'], 'string', 'max' => 50],
            [['no_persetujuan'], 'string', 'max' => 32],
            [['id_tersangka', 'id_penandatangan'], 'string', 'max' => 20],
            [['dikeluarkan'], 'string', 'max' => 64],
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
            'no_surat_p26' => 'No Surat P26',
            'tgl_ba' => 'Tgl Ba',
            'no_persetujuan' => 'No Persetujuan',
            'tgl_persetujuan' => 'Tgl Persetujuan',
            'id_tersangka' => 'Id Tersangka',
            'kasus_posisi' => 'Kasus Posisi',
            'pasal_disangka' => 'Pasal Disangka',
            'barbuk' => 'Barbuk',
            'alasan' => 'Alasan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_surat' => 'Tgl Surat',
            'id_penandatangan' => 'Id Penandatangan',
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