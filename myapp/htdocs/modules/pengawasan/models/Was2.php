<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "was.was_2".
 *
 * @property string $id_was2
 * @property string $no_was_2
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $tgl_was_2
 * @property integer $kpd_was_2
 * @property integer $ttd_was_2
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
class Was2 extends \yii\db\ActiveRecord
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
        return 'was.was2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was2','no_register'], 'string', 'max' => 25],
            [['id_tingkat_wilayah'], 'string', 'max' => 1],
            [['id_kepada_was2','id_dari_was2'], 'string', 'max' => 3],
            [['nama_kepada_was2','nama_penandatangan','jabatan_penandatangan'], 'string', 'max' => 65],
            [['was2_tanggal'], 'safe'],
            [['was2_lampiran'], 'string', 'max' => 15],
			[['jbtn_penandatangan'], 'string', 'max' => 100],
            [['was2_perihal'], 'string'],
            [['was2_file'], 'string', 'max' => 20],
            [['pangkat_penandatangan','was2_no_surat'], 'string', 'max' => 50],
            [['golongan_penandatangan'], 'string', 'max' => 50],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
           // [['inst_satkerkd'], 'string', 'max' => 10],
			[['status_penandatangan'],'string','max' =>1],
            // [['inst_satkerkd'], 'string', 'max' => 10],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was2' => 'Id Was 2',
            'no_register' => 'No Register',
            'id_kepada_was2' => 'Kepada Was2',
            'id_dari_was2' => 'Dari was2',
            'id_tingkat_wilayah' => 'Tinhkat Wilayah',
            'nama_kepada_was2' => 'Nama Kepada Was2',
            'nama_penandatangan' => 'Was 2 Nama Penandatangan',
            'jabatan_penandatangan' => 'Was2 Jabatan Penandatangan',
            'was2_tanggal' => 'was2 tanggal',
            'was2_lampiran' => 'Was2 lampiran',
            'was2_perihal' => 'was2 Perihal',
            'was2_file' => 'Was2 File',
            'pangkat_penandatangan' => 'Was2 Pangkat Penandatangan',
            'golongan_penandatangan' => 'was2 Golongan',
            'id_terlapor_awal' => 'id_terlapor Awal',
			'status_penandatangan'=>'Status Penandatangan',
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
