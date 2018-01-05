<?php

namespace app\modules\pidum\models;

use Yii;
use app\models\MsAgama;
use app\models\MsIdentitas;
use app\models\MsJkl;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\web\Session;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * This is the model class for table "pidum.ms_tersangka_berkas".
 *
 * @property string $id_tersangka
 * @property string $id_perkara
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $no_identitas
 * @property string $no_hp
 * @property integer $warganegara
 * @property string $pekerjaan
 * @property string $suku
 * @property string $nama
 * @property integer $id_jkl
 * @property integer $id_identitas
 * @property integer $id_agama
 * @property integer $id_pendidikan
 * @property string $flag
 * @property integer $tinggi
 * @property string $kulit
 * @property string $muka
 * @property string $ciri_khusus
 * @property string $foto
 * @property integer $is_status
 * @property string $umur
 * @property integer $no_urut
 * @property string $id_t5
 * @property string $status
 */
class MsTersangkaBerkas extends \yii\db\ActiveRecord
{
	public $nama_update;
    public $s_ter;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_tersangka_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama','no_identitas','alamat','id_identitas','tmpt_lahir','tgl_lahir','warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'required'],
            [['tgl_lahir'], 'safe'],
            [['id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'tinggi', 'is_status', 'no_urut'], 'integer'],
            [['ciri_khusus'], 'string'],
            [['umur'], 'number'],
            [['id_tersangka', 'id_pengantar'], 'string', 'max' => 16],
            [['tmpt_lahir', 'no_hp', 'suku', 'kulit', 'muka', 'id_t5'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
			[['id_perkara'], 'string', 'max' => 56],
            [['nama'], 'string', 'max' => 255],
            [['flag'], 'string', 'max' => 1],
            [['foto'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 10],
            [['id_tersangka'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tersangka' => 'Id Tersangka',
            'id_perkara' => 'Id Perkara',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'no_hp' => 'No Hp',
            'warganegara' => 'Warganegara',
            'pekerjaan' => 'Pekerjaan',
            'suku' => 'Suku',
            'nama' => 'Nama',
            'id_jkl' => 'Id Jkl',
            'id_identitas' => 'Id Identitas',
            'id_agama' => 'Id Agama',
            'id_pendidikan' => 'Id Pendidikan',
            'flag' => 'Flag',
            'tinggi' => 'Tinggi',
            'kulit' => 'Kulit',
            'muka' => 'Muka',
            'ciri_khusus' => 'Ciri Khusus',
            'foto' => 'Foto',
            'is_status' => 'Is Status',
            'umur' => 'Umur',
            'no_urut' => 'No Urut',
            'id_t5' => 'Id T5',
            'status' => 'Status',
        ];
    }
	public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $files = UploadedFile::getInstance($this, 'foto');
 
        // if no image was uploaded abort the upload
        if (empty($files)) {
            return false;
        }
 
        // store the source file name
        $this->filename = $files->name;
        $ext = end((explode(".", $files->name)));
 
        // generate a unique file name
        $this->foto = Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $files;
    }
 
 
 public function getIdAgama()
    {
        return $this->hasOne(MsAgama::className(), ['id_agama' => 'id_agama']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdIdentitas()
    {
        return $this->hasOne(MsIdentitas::className(), ['id_identitas' => 'id_identitas']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdJkl()
    {
        return $this->hasOne(MsJkl::className(), ['id_jkl' => 'id_jkl']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdPendidikan()
    {
        return $this->hasOne(MsPendidikan::className(), ['id_pendidikan' => 'id_pendidikan']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWarganegara()
    {
        return $this->hasOne(MsWarganegara::className(), ['id' => 'warganegara']);
    }
	

}
