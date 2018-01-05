<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b1".
 *
 * @property string $id_b1
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $barbuk
 * @property string $simpan_di
 * @property string $penyitaan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $telah_diduga 
 * @property string $dikuasai 
 * @property string $barang_diduga
 */
class PdmB1 extends \app\models\BaseModel
{
    public $wilayah_kerja;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b1','sifat','id_penandatangan'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['barbuk'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_b1', 'id_perkara', 'lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'dikuasai'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['simpan_di', 'penyitaan', 'upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['telah_diduga', 'barang_diduga'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b1' => 'Id B1',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'barbuk' => 'Barbuk',
            'simpan_di' => 'Simpan Di',
            'penyitaan' => 'Penyitaan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'telah_diduga' => 'Telah Diduga', 
            'dikuasai' => 'Dikuasai', 
            'barang_diduga' => 'Barang Diduga', 
        ];
    }
}
