<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmBerkasTahap1Grid;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "pidum.pdm_berkas_tahap1".
 *
 * @property string $id_berkas
 * @property string $id_perkara
 * @property string $no_berkas
 * @property string $tgl_berkas
 *
 * @property PdmSpdp $idPerkara
 */
class PdmBerkasTahap1GridSearch extends  PdmBerkasTahap1Grid
{

    public function search($params)
    {
        $query = PdmBerkasTahap1Grid::find();
        $this->load($params);

        
            //var_dump($params)."--";echo $this->id_perkara;exit;
            $query->andFilterWhere(['like','upper(no_berkas)',strtoupper($this->id_perkara)])
            ->orFilterWhere(['like','tgl_berkas',strtoupper($this->id_perkara)]);

        

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

    
}
