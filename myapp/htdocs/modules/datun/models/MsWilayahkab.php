<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\MsWilayahkab;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "datun.m_kabupaten".
 *
 * @property string $id_kabupaten_kota
 * @property string $deskripsi_kabupaten_kota
 */
 
class MsWilayahkab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'datun.m_kabupaten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prop'], 'required'],
            ['id_kabupaten_kota', 'required'],
            [['deskripsi_kabupaten_kota'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'id_prop' => 'Kode Provinsi',
            'id_kabupaten_kota' => 'Kode Kabupaten',
            'deskripsi_kabupaten_kota' => 'Deskripsi',
        ];
    }

    /**
     * @inheritdoc
     * @return MsInstPenyidikQuery the active query used by this AR class.
     */
	 
	     public function ambilkab($id)
    {
        $query = new Query();
        $query->select('a.*')
            ->from('datun.m_kabupaten a')
            ->where("a.id_prop='".$id."'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            return $dataProvider;
        }

/*         $query->andFilterWhere([
            'jam_mulai' => $this->jam_mulai,
            'tgl_kunjungan' => $this->tgl_kunjungan,
        ]);
 */
        $query->andFilterWhere(['like', 'id_kabupaten_kota', $this->id_kabupaten_kota])
              ->andFilterWhere(['like', 'deskripsi_kabupaten_kota', $this->deskripsi_kabupaten_kota]);

        return $dataProvider;
    }
	 
	 function msimpanwil($post){
		$connection = Yii::$app->db;
		$kd1  	= htmlspecialchars($post['kd1'], ENT_QUOTES);
        $kd2  	= htmlspecialchars($post['kd2'], ENT_QUOTES);
        $desk  	= htmlspecialchars($post['desk'], ENT_QUOTES);
		
		$sql="insert into datun.m_kabupaten values('$kd2','$kd1','$desk')";
		
		$command = $connection->createCommand($sql);
		$m_kab = $command->execute();

	 }	 
	 function mubahwil($post){
		$connection = Yii::$app->db;
		$kd1  	= htmlspecialchars($post['kd1'], ENT_QUOTES);
        $kd2  	= htmlspecialchars($post['kd2'], ENT_QUOTES);
        $desk  	= htmlspecialchars($post['desk'], ENT_QUOTES);
		
		$sql="update datun.m_kabupaten set deskripsi_kabupaten_kota='$desk' where id_kabupaten_kota='$kd2'";
		
		$command = $connection->createCommand($sql);
		$m_kab = $command->execute();

	 }
/* 	 function ambilwilkab($id){
		$connection = Yii::$app->db;		
		$sql="select * from datun.m_kabupaten where id_kabupaten_kota='".$id."'";
		
		$command = $connection->createCommand($sql);
		$hasil = $command->execute();

        return $hasil;
	 } */
		     public function ambilwilkab($id)
    {
		$connection = Yii::$app->db;
        $query = new Query();
        $query->select('a.*')
            ->from('datun.m_kabupaten a')
            ->where("a.id_kabupaten_kota='".$id."'");
		$command = $connection->createCommand($query);
		$hasil = $command->execute();
/* 
        $hasil = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            return $hasil;
        }
 */
        return $hasil;
    } 
 
}
