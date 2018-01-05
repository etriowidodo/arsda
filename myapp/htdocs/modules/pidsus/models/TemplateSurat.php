<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\components\InspekturComponent;

class TemplateSurat extends \yii\db\ActiveRecord{

    public static function tableName(){
        return 'pidsus.ms_template_surat';
    }

    public function searchCustom($get){
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from pidsus.ms_template_surat where 1=1";
		if($q1)
			$sql .= " and (upper(kode_template_surat) like '%".strtoupper($q1)."%' or upper(deskripsi_template_surat) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
        $sql .= " order by urut";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
        ]);
        return $dataProvider;
    }

    public function cekRole($post){
		$q1 	= htmlspecialchars($post['kode_template_surat'], ENT_QUOTES);
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$sql 	= "select count(*) from pidsus.ms_template_surat where upper(kode_template_surat) = '".strtoupper($q1)."'";
		$count 	= ($isNew)?$this->db->createCommand($sql)->queryScalar():0;
		return $count;
    }

    public function simpanData($post){
		$connection = $this->db;
		$kode		= htmlspecialchars($post['kode_template_surat'], ENT_QUOTES);
		$deskripsi 	= htmlspecialchars($post['deskripsi_template_surat'], ENT_QUOTES);
		$isNew 		= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);

		$filePhoto 	= htmlspecialchars($_FILES['file_template']['name'],ENT_QUOTES);
		$sizePhoto 	= htmlspecialchars($_FILES['file_template']['size'],ENT_QUOTES);
		$tempPhoto 	= htmlspecialchars($_FILES['file_template']['tmp_name'],ENT_QUOTES);
		$extPhoto 	= substr($filePhoto,strrpos($filePhoto,'.'));
		$max_size	= 2 * 1024 * 1024;
		$allow_type	= array(".jpg", ".jpeg", ".JPG", ".png", ".pdf", ".rar", ".zip", ".doc", ".docx", ".odt");
		$pathfile	= Yii::$app->params['pathTemplate'];
		$newPhoto 	= Yii::$app->inspektur->sanitize_filename($kode).$extPhoto;

		$transaction = $connection->beginTransaction();
		try{
			if($isNew){
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "insert into pidsus.ms_template_surat(kode_template_surat, deskripsi_template_surat, file_template_surat) 
							values('".$kode."', '".$deskripsi."', '".$newPhoto."')";
				} else{
					$upl1 = false;
					$sql1 = "insert into pidsus.ms_template_surat(kode_template_surat, deskripsi_template_surat)values('".$kode."', '".$deskripsi."')";
				}
			}else{
				if($filePhoto != ""){
					$upl1 = true;
					$sql1 = "update pidsus.ms_template_surat set deskripsi_template_surat = '".$deskripsi."', file_template_surat = '".$newPhoto."' 
							where kode_template_surat = '".$kode."'";
				} else{
					$upl1 = false;
					$sql1 = "update pidsus.ms_template_surat set deskripsi_template_surat = '".$deskripsi."' where kode_template_surat = '".$kode."'";
				}
			}

			if($upl1){
				$tmpPot = glob($pathfile.Yii::$app->inspektur->sanitize_filename($kode).".*");
				if(count($tmpPot) > 0){
					foreach($tmpPot as $datj)
						if(file_exists($datj)) unlink($datj);
				}
				$tujuan  = $pathfile.$newPhoto;
				$mantab  = move_uploaded_file($tempPhoto, $tujuan);
				if(file_exists($tempPhoto)) unlink($tempPhoto);
			}
			$connection->createCommand($sql1)->execute();
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$pathfile	= Yii::$app->params['pathTemplate'];

		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$file = $connection->createCommand("select file_template_surat from pidsus.ms_template_surat where kode_template_surat = '".$val."'")->queryScalar();
					if($file && file_exists($pathfile.$file)) unlink($pathfile.$file);

					$sql1 = "delete from pidsus.ms_template_surat where kode_template_surat = '".$val."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			if(YII_DEBUG){throw $e; exit;} else{return false;}
		}
    }
}
