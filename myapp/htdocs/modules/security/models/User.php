<?php

namespace app\modules\security\models;
use Yii;
use yii\data\SqlDataProvider;

class User extends \yii\db\ActiveRecord{
    public $parent_name;

    public static function tableName(){
        return 'mdm_user';
    }

    public function rules(){
        return [
            [['id_asalsurat'], 'required'],
            [['id_asalsurat'], 'string', 'max' => 32],
            [['nama'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['id_asalsurat'], 'unique']
        ];
    }

    public function attributeLabels(){
        return [
            'id_asalsurat' => 'Id Asalsurat',
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }

    public function searchCustom($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from public.mdm_user where 1=1";
		if($q1)
			$sql .= " and (upper(username) like '%".strtoupper($q1)."%' or upper(nama_pegawai) like '%".strtoupper($q1)."%' or peg_nip = '".$q1."')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 20],
        ]);

        return $dataProvider;
    }

    public function searchRole($get){
		$q1  = htmlspecialchars($get['q1Modal'], ENT_QUOTES);
		$sql = "select * from public.mdm_role where module = '".$q1."'";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);

        return $dataProvider;
    }

    public function searchRoleMenu($get){
		$param = explode("#", htmlspecialchars($get['id'], ENT_QUOTES));
		$kueri = "
			WITH RECURSIVE menu_tree(id, name, parent, depth, path, route, urut, data, module, tipe_menu, tree_menu) AS (
				select tn.id, tn.name, tn.parent, 1::INT as depth, lpad(tn.order::TEXT,2,'0')||'.'||tn.id::TEXT as path, 
				tn.route, tn.order, tn.data, tn.module, tn.tipe_menu, tn.id::TEXT as tree_menu 
				from public.menu tn 
				where tn.module = '".$param[1]."' and tn.parent is null
				UNION ALL
				select c.id, c.name, c.parent, p.depth + 1 AS depth, (p.path || '->' || lpad(c.order::TEXT,2,'0')||'.'||c.id::TEXT), 
				c.route, c.order, c.data, c.module, c.tipe_menu, (p.tree_menu||'.'||c.id::TEXT) 
				FROM menu_tree p join public.menu c on c.parent = p.id
			)                                                                
			select a.*, case when c.jum is null then 'file' else 'folder' end as tipe from menu_tree a 
			join public.mdm_role_menu b on a.id = b.id_menu and b.id_role = '".$param[0]."' 
			left join (select count(*) as jum , parent from public.menu where module = '".$param[1]."' group by parent) c on a.id = c.parent 
			order by path";
		$hasil = $this->db->createCommand($kueri)->queryAll();
        return array("namaRole"=>$param[2], "namaModul"=>$param[1], "hasil"=>$hasil);
    }

    public function searchPegawai($get){
		$q1  = htmlspecialchars($get['q1Modal'], ENT_QUOTES);
		$sql = "select peg_nip_baru, nama, gol_pangkat, jabatan, unitkerja_kd, unitkerja_idk, inst_satkerkd from kepegawaian.kp_pegawai where 1=1";
		if($q1)
			$sql .= " and (peg_nip_baru like '".$q1."%' or upper(nama) like '%".strtoupper($q1)."%' or upper(jabatan) like '%".strtoupper($q1)."%')";
		$kueri = $this->db->createCommand("select count(*) from (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by inst_satkerkd, ref_jabatan_kd, unitkerja_kd";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 5],
        ]);
        return $dataProvider;
    }

    public function simpanData($post){
		$connection 	= $this->db;
		$isNewRecord 	= htmlspecialchars($post['act'], ENT_QUOTES);
		$id_user 		= htmlspecialchars($post['idr'], ENT_QUOTES);
		$username 		= htmlspecialchars($post['username'], ENT_QUOTES);
		$passhash 		= htmlspecialchars($post['passhash'], ENT_QUOTES);
		$peg_nip 		= htmlspecialchars($post['peg_nip'], ENT_QUOTES);
		$namanya 		= htmlspecialchars($post['namanya'], ENT_QUOTES);
		$is_admin 		= ($post['is_admin'])?htmlspecialchars($post['is_admin'], ENT_QUOTES):0;
		$kode_tk 		= htmlspecialchars($post['kode_tk'], ENT_QUOTES);
		$kode_kejati 	= htmlspecialchars($post['kode_kejati'], ENT_QUOTES);
		$kode_kejari 	= htmlspecialchars($post['kode_kejari'], ENT_QUOTES);
		$kode_cabjari 	= htmlspecialchars($post['kode_cabjari'], ENT_QUOTES);
		$unitkerja_kd 	= htmlspecialchars($post['unitkerja_kd'], ENT_QUOTES);
		$unitkerja_idk 	= htmlspecialchars($post['unitkerja_idk'], ENT_QUOTES);
		
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$hashpassword = Yii::$app->getSecurity()->generatePasswordHash($passhash);
				$sql1 = "insert into mdm_user(username, peg_nip, nama_pegawai, kode_tk, kode_kejati, kode_kejari, kode_cabjari, password_hash, is_admin, created_at, 
						unitkerja_kd, unitkerja_idk) values('".$username."', '".$peg_nip."', '".$namanya."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', 
						'".$kode_cabjari."', '".$hashpassword."', '".$is_admin."', NOW(), '".$unitkerja_kd."', '".$unitkerja_idk."')";
				$connection->createCommand($sql1)->execute();
				$id_user = $connection->getLastInsertID('mdm_user_id_user_seq');
	
				if(count($post['roleid']) > 0){
					foreach($post['roleid'] as $idx=>$val){
						$sql2 = "insert into mdm_user_role values('".$id_user."', '".$val."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."')";
						$connection->createCommand($sql2)->execute();
					}
				}
			} else{
				$sql1 = "update mdm_user set username = '".$username."', peg_nip = '".$peg_nip."', nama_pegawai = '".$namanya."', kode_tk = '".$kode_tk."', 
						kode_kejati = '".$kode_kejati."', kode_kejari = '".$kode_kejari."', kode_cabjari = '".$kode_cabjari."', is_admin = '".$is_admin."', 
						unitkerja_kd = '".$unitkerja_kd."', unitkerja_idk = '".$unitkerja_idk."' where id = '".$id_user."'";
				$connection->createCommand($sql1)->execute();

				$sql2 = "delete from mdm_user_role where id_user = '".$id_user."'";
				$connection->createCommand($sql2)->execute();

				if(count($post['roleid']) > 0){
					foreach($post['roleid'] as $idx=>$val){
						$sql3 = "insert into mdm_user_role values('".$id_user."', '".$val."', '".$kode_tk."', '".$kode_kejati."', '".$kode_kejari."', '".$kode_cabjari."')";
						$connection->createCommand($sql3)->execute();
					}
				}
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
					$sql1 = "delete from mdm_user where id = '".$val."'";
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

    public function cekUsername($post){
		$connection  = $this->db;
		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
		$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
		$q3 = htmlspecialchars($post['q3'], ENT_QUOTES);
		$q4 = htmlspecialchars($post['q4'], ENT_QUOTES);
		$q5 = htmlspecialchars($post['q5'], ENT_QUOTES);
		$sql = "select count(*) from public.mdm_user where username = '".$q1."' and kode_tk = '".$q2."' and kode_kejati = '".$q3."' and kode_kejari = '".$q4."' 
				and kode_cabjari = '".$q5."'";
		$count = ($isNewRecord)?$connection->createCommand($sql)->queryScalar():0;
		return $count;
	}

}
