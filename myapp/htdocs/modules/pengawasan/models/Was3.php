<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "was.was_3".
 *
 * @property string $id_was3
 * @property string $no_was_3
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $tgl_was_3
 * @property integer $kpd_was_3
 * @property integer $ttd_was_3
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property integer $id_terlapor
 * @property string $ttd_peg_nik
 * @property string $upload_file
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $ttd_id_jabatan
 */
class Was3 extends \yii\db\ActiveRecord
{
    
    // public $no_register;
    // public $inst_nama;
    // public $ttd_peg_nama;
    // public $ttd_peg_nip;
    // public $ttd_peg_pangkat;
    // public $ttd_peg_jabatan;
    // public $id_was2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was3','no_register'], 'string', 'max' => 25],
            [['was3_kepada','was3_dari','jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['was3_tanggal','created_time','updated_time'], 'safe'],
            [['was3_lampiran','created_ip','updated_ip'], 'string', 'max' => 15],
            [['was3_perihal'], 'string'],
            [['nama_penandatangan','pangkat_penandatangan','was3_file'], 'string', 'max' => 30],
            [['golongan_penandatangan','no_surat'], 'string', 'max' => 50],
			[['nip_penandatangan'], 'string', 'max' => 18],
			[['id_terlapor_awal','id_pelapor'], 'string', 'max' => 7],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
         //   [['inst_satkerkd'], 'string', 'max' => 10],
			[['created_by'], 'integer'],
            // [['inst_satkerkd'], 'string', 'max' => 10],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was3' => 'Id Was 3',
            'no_register' => 'No Register',
            'no_surat' => 'No Surat',
            'was3_kepada' => 'Kepada Was3',
            'was3_dari' => 'Dari was3',
            'nama_penandatangan' => 'Was 3 Nama Penandatangan',
            'jabatan_penandatangan' => 'Was 3 Jabatan Penandatangan',
            'was3_tanggal' => 'Was3 tanggal',
            'was3_lampiran' => 'Was3 lampiran',
            'was3_perihal' => 'Was3 Perihal',
            'was3_file' => 'Was2 File',
            'pangkat_penandatangan' => 'Was3 Pangkat Penandatangan',
            'golongan_penandatangan' => 'Was3 Golongan',
            'id_terlapor_awal' => 'id_terlapor Awal',
            // 'inst_satkerkd' => 'inst_satkerkd'
        ];
    }
    
    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getFileWas() 
    {
        return isset($this->upload_file) ? Yii::$app->params['uploadPath'] . $this->upload_file : null;
    }
 
    /**
     * fetch stored image url
     * @return string
     */
    public function getWasUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->upload_file) ? $this->upload_file : '';
        return \Yii::$app->params['uploadUrl'] . $avatar;
    }
 
    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $files = UploadedFile::getInstance($this, 'upload_file');
 
        // if no image was uploaded abort the upload
        if (empty($files)) {
            return false;
        }
 
        // store the source file name
        $this->filename = $files->name;
        $ext = end((explode(".", $files->name)));
 
        // generate a unique file name
        $this->upload_file = Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $files;
    }
 
    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        $file = $this->getImageFile();
 
        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }
 
        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }
 
        // if deletion successful, reset your file attributes
        $this->upload_file = null;
       
 
        return true;
    }
}
