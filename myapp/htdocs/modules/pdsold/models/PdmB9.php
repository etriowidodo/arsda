<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b9".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_b9
 * @property string $tgl_b9
 * @property string $putusan_negeri
 * @property string $tgl_pn
 * @property string $amar_pn
 * @property string $barbuk
 * @property string $putusan_tinggi
 * @property string $tgl_pt
 * @property string $amar_pt
 * @property string $no_ma
 * @property string $tgl_ma
 * @property string $amar_ma
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nip_jaksa
 * @property string $nip_petugas
 * @property string $nama_petugas
 */
class PdmB9 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_b9', 'created_by', 'updated_by'], 'required'],
            [['tgl_b9', 'tgl_pn', 'tgl_pt', 'tgl_ma', 'created_time', 'updated_time'], 'safe'],
            [['putusan_negeri', 'barbuk', 'putusan_tinggi'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_b9'], 'string', 'max' => 50],
            [['amar_pn', 'amar_pt', 'amar_ma'], 'string', 'max' => 256],
            [['no_ma'], 'string', 'max' => 32],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nip_jaksa', 'nip_petugas'], 'string', 'max' => 60],
            [['nama_petugas'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_b9' => 'No Surat B9',
            'tgl_b9' => 'Tgl B9',
            'putusan_negeri' => 'Putusan Negeri',
            'tgl_pn' => 'Tgl Pn',
            'amar_pn' => 'Amar Pn',
            'barbuk' => 'Barbuk',
            'putusan_tinggi' => 'Putusan Tinggi',
            'tgl_pt' => 'Tgl Pt',
            'amar_pt' => 'Amar Pt',
            'no_ma' => 'No Ma',
            'tgl_ma' => 'Tgl Ma',
            'amar_ma' => 'Amar Ma',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nip_jaksa' => 'Nip Jaksa',
            'nip_petugas' => 'Nip Petugas',
            'nama_petugas' => 'Nama Petugas',
        ];
    }
}
