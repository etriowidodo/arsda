<?php  
	function tgl_indo($tgl, $format='long', $from='ndb', $sep =' '){
		if($tgl != "" && $tgl != "0000-00-00" && $tgl != "0000-00-00 00:00:00"){
			if($from == "ndb"){
				$tanggal = substr($tgl,0,2);
				if($format == "long"){
					$bulan = getBulan(substr($tgl,3,2));
				} else if($format == "short"){
					$bulan = getBulanShort(substr($tgl,3,2));
				} else if($format == "normal"){
					$bulan = substr($tgl,3,2);
				}
				$tahun 	 = substr($tgl,6,4);
			}else if($from == "db"){
				$tanggal = substr($tgl,8,2);
				if($format == "long"){
					$bulan = getBulan(substr($tgl,5,2));
				} else if($format == "short"){
					$bulan = getBulanShort(substr($tgl,5,2));
				} else if($format == "normal"){
					$bulan = substr($tgl,5,2);
				}
				$tahun 	 = substr($tgl,0,4);
			}
			$frmt	 = $tanggal.$sep.$bulan.$sep.$tahun;			
			return $frmt;		 
		}else if($tgl == "0000-00-00")
			return $tgl = "";
	}
	function getBulan($bln){
		switch (intval($bln)){
			case 1: return "Januari"; break;
			case 2: return "Februari"; break;
			case 3: return "Maret"; break;
			case 4: return "April"; break;
			case 5: return "Mei"; break;
			case 6: return "Juni"; break;
			case 7: return "Juli"; break;
			case 8: return "Agustus"; break;
			case 9: return "September"; break;
			case 10: return "Oktober"; break;
			case 11: return "November"; break;
			case 12: return "Desember"; break;
		}
	}
	function getBulanShort($bln){
		switch (intval($bln)){
			case 1: return "Jan"; break;
			case 2: return "Feb"; break;
			case 3: return "Mar"; break;
			case 4: return "Apr"; break;
			case 5: return "Mei"; break;
			case 6: return "Jun"; break;
			case 7: return "Jul"; break;
			case 8: return "Agu"; break;
			case 9: return "Sep"; break;
			case 10: return "Okt"; break;
			case 11: return "Nov"; break;
			case 12: return "Des"; break;
		}
	} 
	function getHari($tgl){
		$arrHari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
		return $arrHari[date("w", strtotime($tgl))];
	}
?>