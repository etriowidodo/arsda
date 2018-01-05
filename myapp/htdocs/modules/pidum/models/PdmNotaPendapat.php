<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_nota_pendapat".
 *
 * @property string $no_register_perkara
 * @property string $jenis_nota_pendapat
 * @property integer $id_nota_pendapat
 * @property string $kepada
 * @property string $dari_nip_jaksa_p16a
 * @property string $dari_nama_jaksa_p16a
 * @property string $dari_jabatan_jaksa_p16a
 * @property string $dari_pangkat_jaksa_p16a
 * @property string $tgl_nota
 * @property string $perihal_nota
 * @property string $dasar_nota
 * @property string $pendapat_nota
 * @property integer $flag_saran
 * @property string $saran_nota
 * @property integer $flag_pentunjuk
 * @property string $petunjuk_nota
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $no_urut_tersangka
 * @property string $tgl_ba4
 * @property string $nama_tersangka_ba4
 * @property string $file_upload
 */
class PdmNotaPendapat extends \yii\db\ActiveRecord
{
    ///public $selection;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_nota_pendapat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'jenis_nota_pendapat', 'id_nota_pendapat', 'created_by', 'updated_by', 'no_urut_tersangka', 'tgl_ba4'], 'required'],
            [['id_nota_pendapat', 'flag_saran', 'flag_pentunjuk', 'created_by', 'updated_by', 'no_urut_tersangka'], 'integer'],
            [['tgl_nota', 'created_time', 'updated_time', 'tgl_ba4'], 'safe'],
            [['dasar_nota', 'pendapat_nota', 'saran_nota', 'petunjuk_nota', 'file_upload'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['jenis_nota_pendapat'], 'string', 'max' => 5],
            [['kepada'], 'string', 'max' => 100],
            [['dari_nip_jaksa_p16a'], 'string', 'max' => 20],
            [['dari_nama_jaksa_p16a'], 'string', 'max' => 128],
            [['dari_jabatan_jaksa_p16a', 'nama_tersangka_ba4'], 'string', 'max' => 200],
            [['dari_pangkat_jaksa_p16a', 'perihal_nota'], 'string', 'max' => 256],
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
            'jenis_nota_pendapat' => 'Jenis Nota Pendapat',
            'id_nota_pendapat' => 'Id Nota Pendapat',
            'kepada' => 'Kepada',
            'dari_nip_jaksa_p16a' => 'Dari Nip Jaksa P16a',
            'dari_nama_jaksa_p16a' => 'Dari Nama Jaksa P16a',
            'dari_jabatan_jaksa_p16a' => 'Dari Jabatan Jaksa P16a',
            'dari_pangkat_jaksa_p16a' => 'Dari Pangkat Jaksa P16a',
            'tgl_nota' => 'Tgl Nota',
            'perihal_nota' => 'Perihal Nota',
            'dasar_nota' => 'Dasar Nota',
            'pendapat_nota' => 'Pendapat Nota',
            'flag_saran' => 'Flag Saran',
            'saran_nota' => 'Saran Nota',
            'flag_pentunjuk' => 'Flag Pentunjuk',
            'petunjuk_nota' => 'Petunjuk Nota',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_urut_tersangka' => 'No Urut Tersangka',
            'tgl_ba4' => 'Tgl Ba4',
            'nama_tersangka_ba4' => 'Nama Tersangka Ba4',
            'file_upload' => 'File Upload',
        ];
    }
}
