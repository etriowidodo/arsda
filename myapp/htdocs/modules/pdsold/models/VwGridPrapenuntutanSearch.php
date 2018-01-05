<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\VwGridPrapenuntutan;
use yii\data\SqlDataProvider;
/**
 * VwGridPrapenuntutanSearch represents the model behind the search form about `app\modules\pidum\models\VwGridPrapenuntutan`.
 */
class VwGridPrapenuntutanSearch extends VwGridPrapenuntutan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'no_surat', 'tgl_surat', 'assurat', 'tgl_terima', 'no_p16', 'tgl_p16', 'jpu', 'tersangka', 'id_sys_menu', 'data_berkas'], 'safe'],
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
        $query = VwGridPrapenuntutan::find();
        $this->load($params);
		

       

        $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
            'tgl_terima' => $this->tgl_terima,
            'tgl_p16' => $this->tgl_p16,
        ]);
		if(!empty($params) && $this->id_perkara !=''){
			//var_dump($params)."--";echo $this->id_perkara;exit;
			$query->andFilterWhere(['like','upper(status)',strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like', 'upper(no_surat)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(assurat)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(jpu)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(no_p16)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(tersangka)',strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(data_berkas)',strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(undang_pasal)',strtoupper($this->id_perkara)]);
				   
			if(count(explode('-',$this->id_perkara)) == 3){
			      $query->orFilterWhere(['=', 'tgl_surat', $this->id_perkara ]);
			      $query->orFilterWhere(['=', 'tgl_terima', $this->id_perkara ]);
			      $query->orFilterWhere(['=', 'tgl_p16', $this->id_perkara ]);
			     
			}
			
		}
		
		 $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		 if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

     public function searchGridTahap1($params)
    {
        $query = VwGridPrapenuntutan::find();

       

        $this->load($params);
        

       

            //var_dump($params)."--";echo $this->id_perkara;exit;
            $query->andFilterWhere(['like','upper(no_surat)',strtoupper($this->no_surat)])
            ->orFilterWhere(['like','tgl_surat',strtoupper($this->no_surat)]);
                  
                   
            
        
        
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
         if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }


	
	public function searchNarkotika($params)
    {
		
        $query = " SELECT a.* from pidum.vw_grid_prapenuntutan a LEFT JOIN pidum.pdm_penetapan_barbuk b on a.id_perkara = b.id_perkara WHERE b.id_perkara IS NULL AND 1=1
 ";
		if($params['VwGridPrapenuntutanSearch']['no_surat']!=''){
			$query .= " AND upper(no_surat) LIKE upper('%".$params['VwGridPrapenuntutanSearch']['no_surat']."%')  ";
		}
		

	  $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


	$dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_perkara',
              'no_surat',
              'tgl_surat',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
		 return $dataProvider;
    }
}
