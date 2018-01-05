<?php

namespace app\modules\pdsold\controllers;

use Yii;
use yii\web\Session;
use yii\data\SqlDataProvider;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmBarbuk;
use app\modules\pdsold\models\PdmUuPasalTahap2;
class PdmP7Controller extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$session        = new Session();
    	$id_perkara     = $session->get('id_perkara');
    	$no_register    = $session->get('no_register_perkara');
//        echo 'nonya : '.$no_register;exit();
        
        $connection     = \Yii::$app->db;
        $qrycount       = "select count(*) from (
                        select pidum.pdm_tahap_dua.no_register_perkara, pidum.pdm_ba4_tersangka.nama, pidum.pdm_tahap_dua.kasus_posisi,
                        string_agg( concat('Undang-undang : ',pidum.pdm_uu_pasal_tahap2.undang,', Pasal : ',pidum.pdm_uu_pasal_tahap2.pasal),', ') as Pasal
                        ,pidum.pdm_ba5.barbuk
                        from pidum.pdm_tahap_dua
                        left join pidum.pdm_ba4_tersangka on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba4_tersangka.no_register_perkara
                        left join pidum.pdm_uu_pasal_tahap2 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_uu_pasal_tahap2.no_register_perkara
                        left join pidum.pdm_ba5 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba5.no_register_perkara
                        where pidum.pdm_tahap_dua.no_register_perkara = '".$no_register."'
                        group by pidum.pdm_tahap_dua.no_register_perkara, pidum.pdm_ba4_tersangka.nama, pidum.pdm_tahap_dua.kasus_posisi, pidum.pdm_ba5.barbuk 
                        ) a";
        $totalCount1    = $connection->createCommand($qrycount);
    	$totalCount     = $totalCount1->queryScalar();

        
    	$dataProvider = new SqlDataProvider([
    			'sql' => "select pidum.pdm_tahap_dua.no_register_perkara, 
                                string_agg( concat('Nama : ',pidum.pdm_ba4_tersangka.nama),', ') as nama,
                                pidum.pdm_tahap_dua.kasus_posisi,
                                string_agg( concat('Undang-undang : ',pidum.pdm_uu_pasal_tahap2.undang,', Pasal : ',pidum.pdm_uu_pasal_tahap2.pasal),', ') as Pasal,
                                concat ('Uraian fakta ',pidum.pdm_spdp.ket_kasus,' waktu kejadian jam ',left(tgl_kejadian_perkara,2),'.',left(right(tgl_kejadian_perkara,13),2),' tanggal ',right(tgl_kejadian_perkara,10),' tempat di ',tempat_kejadian) as uraian,
                                pidum.pdm_ba5.barbuk
                                from pidum.pdm_tahap_dua
                                left join pidum.pdm_ba4_tersangka on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba4_tersangka.no_register_perkara
                                left join pidum.pdm_uu_pasal_tahap2 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_uu_pasal_tahap2.no_register_perkara
                                left join pidum.pdm_ba5 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba5.no_register_perkara
                                left join pidum.pdm_berkas_tahap1 on pidum.pdm_tahap_dua.id_berkas = pidum.pdm_berkas_tahap1.id_berkas
                                left join pidum.pdm_spdp on pidum.pdm_berkas_tahap1.id_perkara = pidum.pdm_spdp.id_perkara
                                where pidum.pdm_tahap_dua.no_register_perkara = :no_register_perkara
                                group by pidum.pdm_tahap_dua.no_register_perkara, pidum.pdm_tahap_dua.kasus_posisi, pidum.pdm_ba5.barbuk, uraian
                                ",
    			'params' => [':no_register_perkara' => $no_register],
    			'totalCount' => $totalCount,
    			//'sort' =>false, to remove the table header sorting
    			'sort' => [
    					'attributes' => [
    							'title' => [
    									'asc' => ['title' => SORT_ASC],
    									'desc' => ['title' => SORT_DESC],
    									'default' => SORT_DESC,
    									'label' => 'Post Title',
    							],
    							'author' => [
    									'asc' => ['author' => SORT_ASC],
    									'desc' => ['author' => SORT_DESC],
    									'default' => SORT_DESC,
    									'label' => 'Name',
    							],
    							'created_on'
    					],
    			],
    			'pagination' => [
    					'pageSize' => 10,
    			],
    	]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    
    public function actionCetak($id){
        $connection     = \Yii::$app->db;
        $qrygrid        = "select pidum.pdm_tahap_dua.no_register_perkara, 
                        --string_agg( concat('Nama : ',pidum.pdm_ba4_tersangka.nama),', ') as nama,
                        pidum.pdm_tahap_dua.kasus_posisi,
                        string_agg( concat('Undang-undang : ',pidum.pdm_uu_pasal_tahap2.undang,', Pasal : ',pidum.pdm_uu_pasal_tahap2.pasal),', ') as Pasal,
                        concat ('Uraian fakta ',pidum.pdm_spdp.ket_kasus,' waktu kejadian jam ',left(tgl_kejadian_perkara,2),'.',left(right(tgl_kejadian_perkara,13),2),' tanggal ',right(tgl_kejadian_perkara,10),' tempat di ',tempat_kejadian) as uraian,
                        pidum.pdm_ba5.barbuk
                        from pidum.pdm_tahap_dua
                        left join pidum.pdm_ba4_tersangka on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba4_tersangka.no_register_perkara
                        left join pidum.pdm_uu_pasal_tahap2 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_uu_pasal_tahap2.no_register_perkara
                        left join pidum.pdm_ba5 on pidum.pdm_tahap_dua.no_register_perkara = pidum.pdm_ba5.no_register_perkara
                        left join pidum.pdm_berkas_tahap1 on pidum.pdm_tahap_dua.id_berkas = pidum.pdm_berkas_tahap1.id_berkas
                        left join pidum.pdm_spdp on pidum.pdm_berkas_tahap1.id_perkara = pidum.pdm_spdp.id_perkara
                        where pidum.pdm_tahap_dua.no_register_perkara = '".$id."'
                        group by pidum.pdm_tahap_dua.no_register_perkara, pidum.pdm_tahap_dua.kasus_posisi, pidum.pdm_ba5.barbuk, uraian";
        $hasilp7        = $connection->createCommand($qrygrid);
        $cetakp7        = $hasilp7->queryAll();
        
        $qrythp2        = "select * from pidum.pdm_tahap_dua where no_register_perkara = '".$id."'";
        $tahap2          = PdmTahapDua::findBySql($qrythp2)->asArray()->all();
        
//        $tahap2    = PdmTahapDua::findOne(['no_register_perkara'=>$id]);
        $namatsk        = PdmBa4::findAll(['no_register_perkara'=>$id]);
        $uu             = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$id]);
        $namabb         = PdmBarbuk::findAll(['no_register_perkara'=>$id]);
//        print_r($namabb);exit();
//        echo 'namanya : '.$namabb[0]['nama'];exit();
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $id]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        return $this->render('cetak', ['namatsk'=>$namatsk,'spdp'=>$spdp,'uu'=>$uu,'namabb'=>$namabb, 'tahap2'=>$tahap2,'cetakp7'=>$cetakp7]);
        
    }
    
    
    public function actionCetak1($id)
    {
      $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p7.odt");

      $spdp = PdmSpdp::findOne(['id_perkara' => $id]);

      $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);

      $query = Yii::$app->db->createCommand(
              "SELECT
    							spdp.id_perkara,
    							tersangka.nama,
    							spdp.ket_kasus,
    							spdp.undang_pasal,
    							uraian.tempat_kejadian :: TEXT uraian_kejadian,
    							'' :: TEXT alat_bukti,
    							'' :: TEXT barbuk,
    							'' :: TEXT Keterangan
    							FROM
    							pidum.pdm_spdp spdp
    							LEFT JOIN pidum.ms_tersangka tersangka ON (
    							spdp.id_perkara = tersangka.id_perkara
    							)
    							LEFT JOIN (
    							SELECT
    							A .id_perkara,
    							A .tempat_kejadian,
    							A .tgl_kejadian
    							FROM
    							pidum.pdm_berkas A
    							RIGHT JOIN (
    							SELECT
    							id_perkara,
    							MAX (tgl_terima) max_tgl
    							FROM
    							pidum.pdm_berkas
    							GROUP BY
    							id_perkara
    							) tgl_max ON (
    							tgl_max.id_perkara = A .id_perkara
    							AND tgl_max.max_tgl = A .tgl_terima
    							)
    							) uraian ON (
    							uraian.id_perkara = spdp.id_perkara
    							)
    							WHERE
    							spdp.id_perkara = '".$id."'"
      )->queryAll();

      $listLaporan = $odf->setSegment('p7');
      foreach ($query as $key => $value) {
        $listLaporan->no($key+1);
        $listLaporan->nama_tersangka($value['nama']);
        $listLaporan->kasus_posisi($value['ket_kasus']);
        $listLaporan->pasal($value['undang_pasal']);
        $listLaporan->uraian_kejadian($value['uraian_kejadian']);
        $listLaporan->alat_bukti($value['alat_bukti']);
        $listLaporan->barang_bukti($value['barbuk']);
        $listLaporan->keterangan($value['keterangan']);
        $listLaporan->merge();
      }
      $odf->mergeSegment($listLaporan);

      $odf->exportAsAttachedFile();
    }

    public function actionCreate()
    {
        return $this->redirect('index');
    }

    public function actionUpdate()
    {
        return $this->redirect('index');
    }
}
