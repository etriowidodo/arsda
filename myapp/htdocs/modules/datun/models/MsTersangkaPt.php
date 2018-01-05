<?php

namespace app\modules\datun\models;

use Yii;
use yii\db\Query;
use yii\web\Session;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "pidum.ms_tersangka_pt".
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
class MsTersangkaPt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_tersangka_pt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['suku','no_identitas','umur','pekerjaan','alamat','id_identitas','tmpt_lahir','tgl_lahir','warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan'], 'required'],
            [['tgl_lahir'], 'safe'],
            [['id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'tinggi', 'is_status', 'no_urut'], 'integer'],
            [['ciri_khusus'], 'string'],
            [['umur'], 'number'],
            [['id_tersangka'], 'string', 'max' => 60],
            [['id_ppt'], 'string', 'max' => 16],
            [['id_perkara'], 'string', 'max' => 56],
            [['tmpt_lahir', 'no_hp', 'suku', 'kulit', 'muka', 'id_t5'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
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
	
	public function searchT5($params) {
		if(trim($params["MsTersangkaPt"]["nama"]) !=""){
			$where = " AND upper(a.nama) LIKE upper('%".$params["MsTersangkaPt"]["nama"]."%') ";
		}else{
			$where = "";
		}
		
        $query = new Query;
		$session = new Session();
      $idPerkara=$session->get('id_perkara');
        $query->select('a.*')
                ->from('pidum.ms_tersangka_pt a')
				->join ('left join','pidum.pdm_t5_tersangka b','a.id_tersangka = b.id_tersangka AND a.id_perkara = b.id_perkara')
				->join ('left join','pidum.pdm_t5 d','a.id_t5 = b.id_t5 AND a.id_perkara = b.id_perkara')
				->join ('left join','pidum.pdm_t4 c','a.id_tersangka = c.id_tersangka AND a.id_perkara = c.id_perkara')
                ->where("a.id_perkara='" . $idPerkara . "' ".$where."  AND a.id_tersangka Not In (select id_tersangka from pidum.pdm_t5_tersangka where id_perkara='" .$idPerkara. "') AND (d.id_t5 = '' OR d.id_t5 is null) AND (c.id_tersangka = '' OR c.id_tersangka is null) GROUP BY a.id_tersangka ");
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
