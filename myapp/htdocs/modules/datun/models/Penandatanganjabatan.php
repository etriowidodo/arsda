<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * Menu represents the model behind the search form about [[\mdm\admin\models\Menu]].
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Penandatanganjabatan extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'datun.m_penandatangan_pejabat';
    }

    /**
     * @inheritdoc
     */
	 //bowo 30 mei 2016 #menambahkan field peg_nip_baru
    public function rules()
    {
        return [
            [['kode_tk', 'kode', 'nip', 'status'], 'required'],
            [['kode_tk','kode'], 'string', 'max' => 2],
            [['nip'], 'string', 'max' => 18],
            [['status'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'kode',
            'nip' => 'nip',
            'status' => 'status'
        ];
    }

    public function searchCustom($params)
    {
		$id  = htmlspecialchars($params['id'], ENT_QUOTES);
		$q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
		$sql = "select a.*, b.nama, b.jabatan, case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
				from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				where a.kode = '".$id."' and a.kode_tk = '".Yii::$app->user->identity->kode_tk."'";
		if($q1)
			$sql .= " and (a.nip like '".$q1."%' or upper(b.nama) like '%".strtoupper($q1)."%' or upper(b.jabatan) like '%".strtoupper($q1)."%' 
					or upper(a.status) = '".strtoupper($q1)."')";	

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);

        return $dataProvider;
    }

    public function cekJabatan($post){
		$q1 	= htmlspecialchars($post['kode'], ENT_QUOTES);
		$q2 	= htmlspecialchars($post['kode_tk'], ENT_QUOTES);
		$q3 	= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$sql 	= "select count(*) from datun.m_penandatangan_pejabat where kode = '".$q1."' and kode_tk = '".$q2."' and nip = '".$q3."'";
		$count 	= ($isNew)?$this->db->createCommand($sql)->queryScalar():0;
		return $count;
    }

    public function simpanData($post){
		$connection = $this->db;
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$kode 		= htmlspecialchars($post['kode'], ENT_QUOTES);
		$kode_tk 	= htmlspecialchars($post['kode_tk'], ENT_QUOTES);
		$nip 		= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$status 	= htmlspecialchars($post['status'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNew){
				$sql1 = "insert into datun.m_penandatangan_pejabat values('".$kode_tk."', '".$kode."', '".$nip."', '".$status."')";
				$connection->createCommand($sql1)->execute();
			} else{
				$sql1 = "update datun.m_penandatangan_pejabat set status = '".$status."' where kode_tk = '".$kode_tk."' and kode = '".$kode."' and nip = '".$nip."'";				
				$connection->createCommand($sql1)->execute();
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$kdTk = Yii::$app->user->identity->kode_tk;
					$idny = explode(".", $val); 
					$sql1 = "delete from datun.m_penandatangan_pejabat where kode = '".$idny[0]."' and nip = '".$idny[1]."' and kode_tk = '".$kdTk."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
}
