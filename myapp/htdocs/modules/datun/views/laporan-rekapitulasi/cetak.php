<?php
require_once('./wordtest/classes/CreateDocx.inc');

	    $docx = new CreateDocxFromTemplate('../modules/datun/template/Lr-Datun.2.docx');
        
		$post 			= Yii::$app->getRequest()->post();
		$title			= Yii::$app->inspektur->getNamaSatker();
		$lokasi			= Yii::$app->inspektur->getLokasiSatker()->lokasi;
		$cnamattd 		= $post['penandatangan_nama'];  
		$ctk			= $_SESSION['kode_tk'];
		$tanggal 		= date('d-m-Y');
		$nomor			= 1;		
		$tujuh			= $lima['bln_lalu']+$enam['jml_masuk'];
		$sebelas		= ($lima['bln_lalu']+$enam['jml_masuk'])-($delapan['luar_pengadilan']+$sembilan['penetapan_pengadilan']);
		
		
		if($ctk=='0'){
			$cjabat='DIREKTUR';
		}else if($ctk=='1'){
			$cjabat='KAJATI';
		}else if($ctk=='2'){
			$cjabat='KAJARI';
		}else if($ctk=='1'){
			$cjabat='KACABJARI';
		}	
		
		
		$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($title)),array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('tahun'=>strtoupper($tahun)),array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('nomor'=>strtoupper($nomor)),array('parseLineBreaks'=>true));

		$docx->replaceVariableByText(array('bulan'=>strtoupper(getBulan($bulan))),array('parseLineBreaks'=>true));

		$docx->replaceVariableByHTML('sisa_bulan_lalu', 'inline','<div style="text-align:center;"><b>'.$lima['bln_lalu'].'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('jml_masuk', 'inline','<div style="text-align:center;"><b>'.$enam['jml_masuk'].'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('jml_perkara', 'inline','<div style="text-align:center;"><b>'.$tujuh.'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('diluar_pengadilan', 'inline','<div style="text-align:center;"><b>'.$delapan['luar_pengadilan'].'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('penetapan_pengadilan', 'inline','<div style="text-align:center;"><b>'.$sembilan['penetapan_pengadilan'].'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('jml_hasil', 'inline','<div style="text-align:center;"><b>'.$delapan['luar_pengadilan']+$sembilan['penetapan_pengadilan'].'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('sisa_perkara', 'inline','<div style="text-align:center;"><b>'.$sebelas.'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		
        $docx->replaceVariableByHTML('Nama_Penandatangan', 'inline','<div style="margin-left:18px; line-height:30px; font-family:Calibri (Body); font-size:13px;">'.'</b>'.$cnamattd.'</b>' .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

		$docx->replaceVariableByHTML('Penandatangan', 'inline','<div style="margin-left:18px; line-height:30px; font-family:Calibri (Body); font-size:13px;"> '.'<b>'.$cjabat.'</b>'.'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));		

		$docx->replaceVariableByText(array('lokasi'=>$lokasi),array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('tanggal'=>tanggal_indonesia($tanggal)),array('parseLineBreaks'=>true));

		$docx->replaceVariableByHTML('penggugat', 'block','<div style="text-align:justify;margin-top:0px;">'.$penggugat.'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->createDocx('template/datun/Lr.Datun.2');
		
        $file = 'template/datun/Lr.Datun.2.docx';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

/**faiz tanggal Indonesia***/

    function  tanggal_indonesia($tgl)
    {
        $tanggal  = explode('-',$tgl); 
        $bulan  = getBulan($tanggal[1]);
        $tahun  = $tanggal[2];
        $lctgl = $tanggal[0];
        
        return  $lctgl.' '.$bulan.' '.$tahun;
        
    }
	
	function  getBulan($bln){
	switch  ($bln){
		case  1:
			return  "Januari";
			break;
		case  2:
			return  "Februari";
			break;
		case  3:
			return  "Maret";
			break;
		case  4:
			return  "April";
			break;
		case  5:
			return  "Mei";
			break;
		case  6:
			return  "Juni";
			break;
		case  7:
			return  "Juli";
			break;
		case  8:
			return  "Agustus";
			break;
		case  9:
			return  "September";
			break;
		case  10:
			return  "Oktober";
			break;
		case  11:
			return  "November";
			break;
		case  12:
			return  "Desember";
			break;
		}
	}
	
/***************************/		
		
?>