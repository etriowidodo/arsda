<?php



namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.lapdu".
 *
 * @property string $no_register
 * @property string $tanggal_surat_terima
 * @property string $nomor_surat_lapdu
 * @property string $perihal_lapdu
 * @property string $tanggal_surat_lapdu
 * @property string $ringkasan_lapdu
 * @property string $file_lapdu
 * @property string $id_media_pelaporan
 * @property string $inst_satkerkd
 */
class Was1 extends \yii\db\ActiveRecord
{
    public $satker_terlapor_awal;
    public $isi_saran_was1;
    public $tempat;
    public $tglcetak;
    public $nip_1;
    public $status;
	public $jabatan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['was1_tgl_surat','was1_tgl_disposisi','tgl_cetak','created_time','updated_time'], 'safe'],
            [['was1_perihal', 'was1_narasi_awal','was1_permasalahan','data','was1_analisa','was1_kesimpulan','was1_uraian','was1_isi_disposisi'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['was1_lampiran','created_ip','updated_ip'], 'string', 'max' => 15],
            [['was1_dari','was1_kepada'], 'string', 'max' => 30],
            /*[['id_was1'], 'string', 'max' => 16],*/
            [['id_jabatan'], 'string', 'max' => 3],
            [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['was1_file_disposisi','no_surat'], 'string', 'max' => 50],
            // [['status_penandatangan'], 'string', 'max' => 1],
            [['nama_penandatangan'], 'string', 'max' => 100],
            [['golongan_penandatangan'], 'string', 'max' => 65],
            [['id_saran','id_level_was1'], 'string', 'max' => 1],
            [['pangkat_penandatangan'], 'string', 'max' => 30],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['created_by','updated_by'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            /*'id_was1' => 'Id Was1',*/
            'was1_dari' => 'Id Was1',
            'was1_kepada' => 'Id Was1',
            'was1_tgl_surat' => 'Tanggal Surat Was1',
            'was1_permasalahan' => 'Tanggal Surat Was1',
            'data' => 'Tanggal Surat Was1',
            'was1_kesimpulan' => 'Tanggal Surat Was1',
            'no_register' => 'Nomor Surat Lapdu',
            'no_surat' => 'Nomor Surat Lapdu',
            'was1_perihal'=> 'Perihal Was1',
            'was1_uraian'=> 'Perihal Was1',
            'isi_disposisi_inspektur'=> 'Perihal Was1',
            'isi_disposisi_irmud'=> 'Perihal Was1',
            'isi_disposisi_jamwas'=> 'Perihal Was1',
            //'tgl_disposisi_inspektur' => 'tanggal Disposisi inspektur',
            //'tgl_disposisi_jamwas' => 'Tanggal disposisi Jamwas',
           /* 'tgl_disposisi_irmud' => 'Tanggal disposisi irmud',
            'tgl_disposisi_irmud' => 'Tanggal disposisi irmud',*/
            'file_disposisi_irmud' => 'File Irmud',
            'file_disposisi_inspektur' => 'File inspektur',
            'file_disposisi_jamwas' => 'File Jamwas',
            'file_disposisi_jamwas' => 'File Jamwas',
            'was1_golongan_penandatangan' => 'Id Media Pelaporan',
            'was1_pangkat_penandatangan' => 'Id Media Pelaporan',
            'was1_jabatan_penandatangan' => 'Id Media Pelaporan',
            /*'id_saran' => 'Inst Satkerkd',
            'inst_satkerkd' => 'was1 analisa',*/
            'was1_analisa' => 'was1 analisa',
            'nip_penandatangan' => 'was1 analisa',
            'tgl_cetak' => 'Tgl Cetak',
            'status_penandatangan' => 'status penandatangan',
        ];
    }
}
