<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was20a ;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was20aSearch represents the model behind the search form about `app\modules\pengawasan\models\Was20a`.
 */
class Was20aSearch extends Was20a
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'no_was_20a', 'id_terlapor', 'nip_pegawai_terlapor', 'nrp_pegawai_terlapor', 'nama_pegawai_terlapor', 'pangkat_pegawai_terlapor', 'golongan_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'satker_pegawai_terlapor', 'unit_kerja_terlapor', 'tgl_was_20a', 'tempat', 'lampiran', 'perihal', 'tgl_disampaikan_ba', 'tgl_keberatan_ba', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'jbtn_penandatangan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time','sk'], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_20a', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'kpd_was_20a', 'sifat_surat', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

     public function search($params)
    {
      /*select a.*,b.* from was.was_16b a inner join was.was_16b_isi b
                on a.id_was_16b=b.id_was_16b
                order by a.id_was_16b,b.no_urut_isi*/
        $query="select*from was.was_20a where no_register='".$_SESSION['was_register']."'  and id_tingkat='".$_SESSION['kode_tk']."' 
                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          // $query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or nip_terlapor ='".$keyWord."'";
          // $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(pangkat_terlapor) like'%".strtoupper($keyWord)."%'";
          
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function search_old($params)
    {
        $query = Was20a::find();

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
            'id_sp_was2' => $this->id_sp_was2,
            'id_ba_was2' => $this->id_ba_was2,
            'id_l_was2' => $this->id_l_was2,
            'id_was15' => $this->id_was15,
            'id_was_20a' => $this->id_was_20a,
            'id_wilayah' => $this->id_wilayah,
            'id_level1' => $this->id_level1,
            'id_level2' => $this->id_level2,
            'id_level3' => $this->id_level3,
            'id_level4' => $this->id_level4,
            'kpd_was_20a' => $this->kpd_was_20a,
            'tgl_was_20a' => $this->tgl_was_20a,
            'sifat_surat' => $this->sifat_surat,
            'tgl_disampaikan_ba' => $this->tgl_disampaikan_ba,
            'tgl_keberatan_ba' => $this->tgl_keberatan_ba,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_tingkat', $this->id_tingkat])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'no_was_20a', $this->no_was_20a])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'nip_pegawai_terlapor', $this->nip_pegawai_terlapor])
            ->andFilterWhere(['like', 'nrp_pegawai_terlapor', $this->nrp_pegawai_terlapor])
            ->andFilterWhere(['like', 'nama_pegawai_terlapor', $this->nama_pegawai_terlapor])
            ->andFilterWhere(['like', 'pangkat_pegawai_terlapor', $this->pangkat_pegawai_terlapor])
            ->andFilterWhere(['like', 'golongan_pegawai_terlapor', $this->golongan_pegawai_terlapor])
            ->andFilterWhere(['like', 'jabatan_pegawai_terlapor', $this->jabatan_pegawai_terlapor])
            ->andFilterWhere(['like', 'satker_pegawai_terlapor', $this->satker_pegawai_terlapor])
            ->andFilterWhere(['like', 'unit_kerja_terlapor', $this->unit_kerja_terlapor])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'nip_penandatangan', $this->nip_penandatangan])
            ->andFilterWhere(['like', 'nama_penandatangan', $this->nama_penandatangan])
            ->andFilterWhere(['like', 'pangkat_penandatangan', $this->pangkat_penandatangan])
            ->andFilterWhere(['like', 'golongan_penandatangan', $this->golongan_penandatangan])
            ->andFilterWhere(['like', 'jabatan_penandatangan', $this->jabatan_penandatangan])
            ->andFilterWhere(['like', 'jbtn_penandatangan', $this->jbtn_penandatangan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

     public function searchTerlapor($params)
    {
        /*saran jamwas sk pemberhentian tidak hormat*/
        $query="select * from was.ba_was_6 where no_register='".$_SESSION['was_register']."'  
                and id_tingkat='".$_SESSION['kode_tk']."' 
                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          $query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or nip_terlapor ='".$keyWord."'";
          $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(pangkat_terlapor) like'%".strtoupper($keyWord)."%'";
          
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='was9'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }
}
