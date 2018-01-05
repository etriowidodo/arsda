<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;


/**
 * pdmba10Search represents the model behind the search form about `app\modules\pidum\models\pdmba10`.
 */
class pdmba7Search extends PdmBa7
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_ba7', 'no_surat_t7', 'no_register_perkara', 'kepala_rutan'], 'safe'],
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
    public function search($no_register_perkara, $params)
    {
       $query = new Query;
        // $session = new Session();

        $query->select('*')
                    ->from('pidum.pdm_ba7')   
                    ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
