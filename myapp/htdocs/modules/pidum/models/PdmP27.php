<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p27".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p27
 * @property string $tgl_ba
 * @property string $no_putusan
 * @property string $tgl_putusan
 * @property string $id_tersangka
 * @property string $keterangan_tersangka
 * @property string $keterangan_saksi
 * @property string $dari_benda
 * @property string $dari_petunjuk
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
class PdmP27 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p27';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p27', 'tgl_ba', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba', 'tgl_putusan', 'tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['alasan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p27'], 'string', 'max' => 50],
            [['no_putusan'], 'string', 'max' => 32],
            [['id_tersangka', 'id_penandatangan'], 'string', 'max' => 20],
            [['keterangan_tersangka', 'keterangan_saksi', 'dari_benda', 'dari_petunjuk'], 'string', 'max' => 128],
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
            'no_surat_p27' => 'No Surat P27',
            'tgl_ba' => 'Tgl Ba',
            'no_putusan' => 'No Putusan',
            'tgl_putusan' => 'Tgl Putusan',
            'id_tersangka' => 'Id Tersangka',
            'keterangan_tersangka' => 'Keterangan Tersangka',
            'keterangan_saksi' => 'Keterangan Saksi',
            'dari_benda' => 'Dari Benda',
            'dari_petunjuk' => 'Dari Petunjuk',
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
