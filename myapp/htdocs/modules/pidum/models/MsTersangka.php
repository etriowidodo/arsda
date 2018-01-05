<?php

namespace app\modules\pidum\models;

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
 * This is the model class for table "pidum.ms_tersangka".
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
 *
 * @property PdmSpdp $idPerkara
 * @property MsAgama $idAgama
 * @property MsIdentitas $idIdentitas
 * @property MsJkl $idJkl
 * @property MsPendidikan $idPendidikan
 * @property MsWarganegara $warganegara0
 */
class MsTersangka extends ActiveRecord
{
    
    public $nama_update;
    public $s_ter;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_tersangka';
    }
	public $imageFile;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka','nama','no_urut'], 'required'],//jaka |CMS_PIDUM001_14 | tambah required nama 
            [['tgl_lahir'],'safe'],
            [['no_hp'], 'number'],
            [['id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'integer'],
            [['warganegara'], 'integer'],
            [['id_tersangka'], 'string', 'max' => 60],
			[['id_perkara'], 'string', 'max' => 56],
            [['tmpt_lahir', 'suku'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
			[['umur'], 'number'],
			[['no_urut'], 'integer'],
            [['id_tersangka'], 'unique'],
        ]; 


//upload file
move_uploaded_file($lokasi_file,$direktori_file);
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
			'umur' => 'Umur',
            'ciri_khusus' => 'Ciri Khusus',
        ];
    }
	
	/**
     * fetch stored image url
     * @return string
     */
  /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
   
 
    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
   
	
  public function search2($params) {
        $query = new Query;
		$session = new Session();
      $idPerkara=$session->get('id_perkara');
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_perkara='" . $idPerkara . "' ");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id_tersangka,
           
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
                ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }
  public function search3($params) {
        $query = new Query;
		$session = new Session();
      $idPerkara=$session->get('id_perkara');
        $query->select('*')
                ->from('pidum.ms_tersangka')
                //Begin CMD_PIDUM00-PenampilanTersangka EtrioWidodo
                ->where("id_perkara='" . $idPerkara . "' AND flag='1' ");
                //END CMD_PIDUM00-PenampilanTersangka EtrioWidodo
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id_tersangka,
           
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
                ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }
  public function search4($params) {
        $query = new Query;
		$session = new Session();			
		$idPerkara=$session->get('id_perkara');
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("pidum.ms_tersangka.id_perkara='" . $idPerkara . "' AND pidum.ms_tersangka.id_tersangka NOT IN (select id_tersangka from pidum.pdm_tahanan_penyidik,pidum.pdm_berkas
where pidum.pdm_berkas.id_berkas=pidum.pdm_tahanan_penyidik.id_berkas)");
				
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id_tersangka,
           
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
                ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }
	
	/**
     * @return ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return ActiveQuery
     */
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
    public function getWarganegara0()
    {
        return $this->hasOne(MsWarganegara::className(), ['id' => 'warganegara']);
    }
	


    public function searchPdmTahanan($params) {
        $query = new Query;
        $session = new Session();
      $idPerkara=$session->get('id_perkara');
        $query->select('*,pidum.ms_tersangka.nama as nama_tersangka')
                ->from('pidum.ms_tersangka')
                ->join ('left join','public.ms_warganegara d','pidum.ms_tersangka.warganegara = d.id')
                ->where("pidum.ms_tersangka.id_perkara='".$idPerkara."'");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id_tersangka,
           
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
                ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)]);
        return $dataProvider;
    }
}
