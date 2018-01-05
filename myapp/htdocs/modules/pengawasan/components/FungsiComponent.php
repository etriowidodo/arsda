<?php
namespace app\modules\pengawasan\components;
use Yii;
use yii\db\Query;
use yii\db\Command;
use yii\web\Session;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use app\components\InspekturComponent;

class FungsiComponent extends Widget{
 // $_SESSION['kode_tk']
     public function FunctQuery($table,$key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select*from was.$table where id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and no_register='".$key."'";
        $resulLapdu = $connection->createCommand($sql)->queryOne();
 
      return $resulLapdu;
    }

    public function FunctQueryNoSession($table,$field,$key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select*from was.$table where $field='".$key."'";
        $result = $connection->createCommand($sql)->queryAll();
 
      return $result;
    }

    public function FunctGetIdSpwas1($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select max(id_sp_was1) as id_sp_was1 from was.sp_was_1 where ".$key."";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result;
    }

    public function FunctGetIdSpwas2($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select max(id_sp_was2) as id_sp_was2 from was.sp_was_2 where ".$key."";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result;
    }

    public function FunctGetIdSpwas1All($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select * from was.sp_was_1 where ".$key."";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result;
    }

    public function FunctGetIdSpwas2All($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select * from was.sp_was_2 where ".$key."";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result;
    }

    public function FunctGetIdWas9All($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select * from was.was9_inspeksi where ".$key."";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result;
    }

    public function FunctPanggilan($id_pegawai_terlapor,$nip,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was10 where id_pegawai_terlapor='".$id_pegawai_terlapor."' and nip_pegawai_terlapor='".$nip."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    } 

    public function FunctPanggilanIns($id_pegawai_terlapor,$nip,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was10_inspeksi where id_pegawai_terlapor='".$id_pegawai_terlapor."' 
              and nip_pegawai_terlapor='".$nip."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        // print_r($sql);
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
      return $hasil;
    }

    public function FunctPanggilanInsTu($id_pegawai_terlapor,$nip,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was10_inspeksi where id_pegawai_terlapor='".$id_pegawai_terlapor."' 
              and nip_pegawai_terlapor='".$nip."' and id_tingkat='".$_SESSION['kode_tk']."' 
              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
              and id_cabjari='".$_SESSION['kode_cabjari']."' and no_register='".$no_register."' 
              ";
        // print_r($sql);
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
      return $hasil;
    } 

    public function FunctPanggilanTu($id_pegawai_terlapor,$nip,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was10 where id_pegawai_terlapor='".$id_pegawai_terlapor."' 
              and nip_pegawai_terlapor='".$nip."' and id_tingkat='".$_SESSION['kode_tk']."' 
              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
              and id_cabjari='".$_SESSION['kode_cabjari']."' and no_register='".$no_register."' 
              ";
        // print_r($sql);
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
      return $hasil;
    }

    public function FunctPanggilan_saksiInt($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9 where id_saksi='".$id_saksi."' and jenis_saksi='".$jns_saksi."' and
          id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
          and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
           and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

     public function FunctPanggilan_saksiEks($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9 where id_saksi='".$id_saksi."' and jenis_saksi='".$jns_saksi."' and
          id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
          and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
           and no_register='".$no_register."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

     public function FunctPanggilan_saksiInt_ins($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9_inspeksi where id_saksi_internal='".$id_saksi."' and jenis_saksi='".$jns_saksi."' 
              and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
              and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
              and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
              and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
              and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

     public function FunctPanggilan_saksiEks_ins($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9_inspeksi where 
              id_saksi_eksternal='".$id_saksi."' and jenis_saksi='".$jns_saksi."' 
              and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
              and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
              and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
              and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
              and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

     public function FunctPanggilan_saksiTuInt_ins($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9 where id_saksi='".$id_saksi."' and jenis_saksi='".$jns_saksi."' 
              and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
              and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
              and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
              and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
              and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

     public function FunctPanggilan_saksiTuEks_ins($jns_saksi,$id_saksi,$no_register)
    {   
        $connection = \Yii::$app->db;    
        $sql="select count(*) as jml from was.was9 where 
              id_saksi='".$id_saksi."' and jenis_saksi='".$jns_saksi."' 
              and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
              and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
              and no_register='".$no_register."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
              and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
              and id_level4='".$_SESSION['was_id_level4']."'";
        $result     = $connection->createCommand($sql)->queryOne();
        $hasil      = ($result['jml']=='0'?'':"Panggilan Ke-".$result['jml']);
 
      return $hasil;
    }

    public function Getinsp($key)
    {   
        $connection = \Yii::$app->db;    
        $sql="select B.\"UNITKERJA_NAMA\",(select A.id_inspektur from was.wilayah_inspektur A where A.id_wilayah::integer = 0 and A.id_kejati::integer = B.id_level1::integer  ) as id_inspektur from kepegawaian.v_kp_unit_kerja B where B.id_wilayah ='1' and length(B.\"UNITKERJA_KD\")=3  and B.id_level1='".$key."'";
        $result = $connection->createCommand($sql)->queryOne();
 
      return $result['id_inspektur'];
    }

    public function Static_where()
    {   
        $result=" and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
 
      return $result;
    }

    public function Static_where1()
    {   
        $result=" and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'";
 
      return $result;
    }

     public function Static_where_alias($alias)
    {   
        $result=" and $alias.id_wilayah='".$_SESSION['was_id_wilayah']."' and $alias.id_level1='".$_SESSION['was_id_level1']."' and $alias.id_level2='".$_SESSION['was_id_level2']."' and $alias.id_level3='".$_SESSION['was_id_level3']."' and $alias.id_level4='".$_SESSION['was_id_level4']."'";
 
      return $result;
    }

    public function gabung_where()
    {   
        $result=$_SESSION['was_id_wilayah'].$_SESSION['was_id_level1'].$_SESSION['was_id_level2'].$_SESSION['was_id_level3'].$_SESSION['was_id_level4'];
 
      return $result;
    }

    public function Get_terlapor()
    {   
      $unitkerja=$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3'].'.'.$_SESSION['was_id_level4'];
      $get_unitkerja=new InspekturComponent();
      $pemriksa=$get_unitkerja->getInspektur($unitkerja);
      $result="select a.urut_terlapor,b.* from was.was_disposisi_irmud a 
              inner join was.v_wilayah_pelanggaran b on a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari and a.urut_terlapor=b.no_urut
              where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_pemeriksa='".$pemriksa['kode'][2]."'";

    return $result;
  }  

  public function Get_terlapor2()
    {   
	 //ini session dari no registernya bukan dari user nya 
      $unitkerja=$_SESSION['id_wil'].'.'.$_SESSION['id_level_1'].'.'.$_SESSION['id_level_2'].'.'.$_SESSION['id_level_3'].'.'.$_SESSION['id_level_4'];
      $get_unitkerja=new InspekturComponent();
      $pemriksa=$get_unitkerja->getInspektur($unitkerja);
	  $var=$pemriksa['kode'];
	  
      $result="select a.urut_terlapor,b.* from was.was_disposisi_irmud a 
              inner join was.v_wilayah_pelanggaran b on a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari and a.urut_terlapor=b.no_urut and a.id_pemeriksa='".$var[2]."'
              where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
              and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
              and a.id_cabjari='".$_SESSION['kode_cabjari']."' ";

    return $result;
  }
    
   
}
