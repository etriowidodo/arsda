<?php

namespace app\modules\security\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\security\models\ConfigSatker;

/**
 * PdmConfigSearch represents the model behind the search form about `app\modules\pidum\models\PdmConfig`.
 */
class ConfigSatkerSearch extends ConfigSatker
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_satker', 'time_format', 'flag','p_tinggi','p_negeri'], 'safe'],
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
        $query = ConfigSatker::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kd_satker', $this->kd_satker])
            ->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }

    public function searchCustom($params){
		$sql = "select a.*, b.inst_nama from pidum.pdm_config a join kepegawaian.kp_inst_satker b on a.kd_satker = b.inst_satkerkd";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'pagination' => false,
        ]);

        return $dataProvider;
    }

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['act'], ENT_QUOTES);
		$kd_satker 		= htmlspecialchars($post['kd_satker'], ENT_QUOTES);
		$time_format 	= htmlspecialchars($post['time_format'], ENT_QUOTES);		
        $p_tinggi       = htmlspecialchars($post['p_tinggi'], ENT_QUOTES);
        $p_negeri       = htmlspecialchars($post['p_negeri'], ENT_QUOTES);


		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into pidum.pdm_config(kd_satker, time_format) values('".$kd_satker."', '".$time_format."')";
				$connection->createCommand($sql1)->execute();
			} else{
				$sql1 = "update pidum.pdm_config set kd_satker   = '".$kd_satker."', 
                                                     time_format = '".$time_format."',
                                                     p_tinggi    = '".$p_tinggi."',
                                                     p_negeri    =  '".$p_negeri."'";
               // echo $ql1;exit;
				$connection->createCommand($sql1)->execute();
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return $sql1;
		}
    }
}
