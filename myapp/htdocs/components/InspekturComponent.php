<?php
namespace app\components;
use Yii;
use yii\db\Query;
use yii\web\Session;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class InspekturComponent extends Widget{

    public function init(){
        parent::init();
    }

    public function getInspektur($unit){
        $arrUnit = array(
			'1.6.8'		=> '100',
			'1.6.8.2'	=> '110',
			'1.6.8.2.1'	=> '111',
			'1.6.8.2.2'	=> '112',
			'1.6.8.3'	=> '120',
			'1.6.8.3.1'	=> '121',
			'1.6.8.3.2'	=> '122',
			'1.6.8.4'	=> '130',
			'1.6.8.4.1'	=> '131',
			'1.6.8.4.2'	=> '132',

			'1.6.9'		=> '200',
			'1.6.9.2'	=> '210',
			'1.6.9.2.1'	=> '211',
			'1.6.9.2.2'	=> '212',
			'1.6.9.3'	=> '220',
			'1.6.9.3.1'	=> '221',
			'1.6.9.3.2'	=> '222',
			'1.6.9.4'	=> '230',
			'1.6.9.4.1'	=> '231',
			'1.6.9.4.2'	=> '232',

			'1.6.10'		=> '300',
			'1.6.10.2'		=> '310',
			'1.6.10.2.1'	=> '311',
			'1.6.10.2.2'	=> '312',
			'1.6.10.3'		=> '320',
			'1.6.10.3.1'	=> '321',
			'1.6.10.3.2'	=> '322',
			'1.6.10.4'		=> '330',
			'1.6.10.4.1'	=> '331',
			'1.6.10.4.2'	=> '332',

			'1.6.11'		=> '400',
			'1.6.11.2'		=> '410',
			'1.6.11.2.1'	=> '411',
			'1.6.11.2.2'	=> '412',
			'1.6.11.3'		=> '420',
			'1.6.11.3.1'	=> '421',
			'1.6.11.3.2'	=> '422',
			'1.6.11.4'		=> '430',
			'1.6.11.4.1'	=> '431',
			'1.6.11.4.2'	=> '432',

			'1.6.12'		=> '500',
			'1.6.12.2'		=> '510',
			'1.6.12.2.1'	=> '511',
			'1.6.12.2.2'	=> '512',
			'1.6.12.3'		=> '520',
			'1.6.12.3.1'	=> '521',
			'1.6.12.3.2'	=> '522',
			'1.6.12.4'		=> '530',
			'1.6.12.4.1'	=> '531',
			'1.6.12.4.2'	=> '532',
		);
		if(array_key_exists($unit, $arrUnit)){
			$temp = explode(".", $unit);
			$kode = $arrUnit[$unit];
			$insp = (count($temp) == 3 && $temp[0] == 1)?$arrUnit[$unit][0]:0;
		} else{
			$kode = 0;
			$insp = 0;
		}
		return array("kode"=>$kode, "insp"=>$insp);
    }
	
	public function getSatkerDot($tingkat, $kejati, $kejari, $cabjari){
		if($tingkat == 0 || $tingkat == 1)
			return $kejati;
		else if($tingkat == 2)
			return $kejati.'.'.$kejari;
		else if($tingkat == 3)
			return $kejati.'.'.$kejari.'.'.$cabjari;
	}

	public function sanitize_filename($string){
		$strip = array("&amp;", "&", "/", "\\", "?", "%", "*", ":", "|", "&quot;", "\"", "&#039;", "'", "<", "&lt;", ">", "&gt;", ",", 
						"~", "`", "!", "@", "#", "$", "^", "(", ")", "=", "+", "[", "]", "{", "}", ";", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "�", "�");
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "_", $clean);
		return $clean;
	}

	public function getIconFile($extFile){
		$extens = strtolower($extFile);
		$arrExt = array(
			'.odt'=>'/image/icon-odt.png', 
			'.pdf'=>'/image/icon-pdf.png', 
			'.doc'=>'/image/icon-doc.png', 
			'.docx'=>'/image/icon-doc.png',
			'.jpg'=>'/image/icon-img.png', 
			'.png'=>'/image/icon-img.png',
			'.gif'=>'/image/icon-img.png', 
			'.jpeg'=>'/image/icon-img.png'
		); 
		return (array_key_exists($extens, $arrExt))?$arrExt[$extens]:'/image/icon-file.png';
	}

	public function tgl_db($tgl, $sep="/"){
		if($tgl != ""){
			$tanggal = substr($tgl,0,2);
			$bulan 	 = substr($tgl,3,2);
			$tahun 	 = substr($tgl,6,4);
			return $tahun.$sep.$bulan.$sep.$tanggal;		 
		}else
			return $tgl;
	}

	public function getNamaSatker(){
        $query 	= new Query;
        $query->select('initcap(inst_nama) as inst_nama')->from('kepegawaian.kp_inst_satker')->where(['inst_satkerkd' => $_SESSION['inst_satkerkd']]);
        $satker = $query->createCommand()->queryScalar();
		return $satker;
	}

	public function getTimeFormat(){
        $query 	= new Query;
        $query->select('time_format')->from('pidum.pdm_config');
        $waktu 	= $query->createCommand()->queryScalar();
		return $waktu;
	}

	public function getLawanPemohon($perkara, $surat){
        $query 	= new Query;
        $query->select('no_urut, nama_instansi')->from('datun.lawan_pemohon')->where(['no_register_perkara'=>$perkara, 'no_surat'=>$surat])->orderBy('no_urut asc');
        $satker = $query->createCommand()->queryAll();
		return $satker;
	}

	public function getLokasiSatker(){
        $query 	= new Query;
        $query->select('initcap(inst_lokinst) as lokasi, inst_alamat as alamat')
			->from('kepegawaian.kp_inst_satker')
			->where(['inst_satkerkd' => $_SESSION['inst_satkerkd']]);
        $satker = $query->createCommand()->queryOne();
		return (object)$satker;
	}

/*perminitaan kang putut was minta di pisah*/
	public function getUserwas($nik){
        $query 	= new Query;
        $query->select('*')
			->from('public.login')
			->where(['nip' => $nik]);
        $was_user = $query->createCommand()->queryOne();
		return $was_user;
	}

	public function getHeaderPraPenuntutan(){
        $query 	= new Query;
        if(!$_SESSION["no_berkas"]){
			$query->select('no_spdp, tgl_spdp, tgl_terima')->from('pidsus.pds_spdp')->where(['id_kejati' => $_SESSION['kode_kejati'], 'id_kejari' => $_SESSION['kode_kejari'], 
							'id_cabjari' => $_SESSION['kode_cabjari'], 'no_spdp' => $_SESSION['no_spdp'], 'tgl_spdp' => $_SESSION['tgl_spdp']]);
			$satker = $query->createCommand()->queryOne();
			$hasil = "Nomor SPDP : ".$satker['no_spdp']."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal SPDP : ".date("d-m-Y", strtotime($satker['tgl_spdp']))."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal diterima : ".date("d-m-Y", strtotime($satker['tgl_terima']))."&nbsp;&nbsp;&nbsp;&nbsp;";
		} else{
			$query->select('a.no_spdp, a.tgl_spdp, a.tgl_terima, b.no_berkas')->from('pidsus.pds_spdp a')
			->join('join', 'pidsus.pds_terima_berkas b', 'a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_spdp = b.no_spdp 
				and a.tgl_spdp = b.tgl_spdp')
			->where(['a.id_kejati' => $_SESSION['kode_kejati'], 'a.id_kejari' => $_SESSION['kode_kejari'], 'a.id_cabjari' => $_SESSION['kode_cabjari'], 
				'a.no_spdp' => $_SESSION['no_spdp'], 'a.tgl_spdp' => $_SESSION['tgl_spdp'], 'b.no_berkas' => $_SESSION['no_berkas']]);
			$satker = $query->createCommand()->queryOne();
			$hasil = "Nomor SPDP : ".$satker['no_spdp']."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal SPDP : ".date("d-m-Y", strtotime($satker['tgl_spdp']))."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal diterima : ".date("d-m-Y", strtotime($satker['tgl_terima']))."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "No. Berkas : ".$satker['no_berkas']."&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $hasil;
	}
	
	public function getHeaderPraPenuntutanInternal(){
        $query 	= new Query;
        if($_SESSION["pidsus_no_p8_umum"]){
			$query->select('no_p8_umum, tgl_p8_umum')->from('pidsus.pds_p8_umum')->where(['id_kejati' => $_SESSION['kode_kejati'], 'id_kejari' => $_SESSION['kode_kejari'], 
							'id_cabjari' => $_SESSION['kode_cabjari'], 'no_p8_umum' => $_SESSION['pidsus_no_p8_umum']]);
			$satker = $query->createCommand()->queryOne();
			$hasil = "Nomor P-8 Umum : ".$satker['no_p8_umum']."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal P-8 Umum : ".date("d-m-Y", strtotime($satker['tgl_p8_umum']))."&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $hasil;
	}
        
        public function getHeaderPraPenuntutanInternalKhusus(){
        $query 	= new Query;
        if($_SESSION["pidsus_no_p8_umum"] && $_SESSION["pidsus_no_pidsus18"] && $_SESSION["pidsus_no_p8_khusus"]){                        
			$query->select('c.no_p8_umum, a.no_pidsus18, a.no_p8_khusus, a.tgl_p8_khusus')->from('pidsus.pds_p8_khusus a')
			->join('join', 'pidsus.pds_pidsus18 b', 'a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_pidsus18 = b.no_pidsus18')
			->join('join', 'pidsus.pds_p8_umum c', 'b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari and b.no_p8_umum = c.no_p8_umum')
			->where(['a.id_kejati' => $_SESSION['kode_kejati'], 'a.id_kejari' => $_SESSION['kode_kejari'], 'a.id_cabjari' => $_SESSION['kode_cabjari'], 
				'a.no_pidsus18' => $_SESSION['pidsus_no_pidsus18'], 'a.no_p8_khusus' => $_SESSION['pidsus_no_p8_khusus']]);
			$satker = $query->createCommand()->queryOne();
			$hasil = "Nomor P-8 Umum : ".$satker['no_p8_umum']."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Nomor P-8 Khusus : ".$satker['no_p8_khusus']."&nbsp;&nbsp;&nbsp;&nbsp;";
			$hasil .= "Tanggal P-8 Khusus : ".date("d-m-Y", strtotime($satker['tgl_p8_khusus']))."&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $hasil;
	}

	public function kekataPasalUU($x, $string){
		$x = abs($x);
		if($string == 0){
			$angka = array("", "kesatu", "kedua", "ketiga", "keempat", "kelima", "keenam", "ketujuh", "kedelapan", "kesembilan", "kesepuluh", "kesebelas");
		} else{
			$angka = array("", "pertama", "kedua", "ketiga", "keempat", "kelima", "keenam", "ketujuh", "kedelapan", "kesembilan", "kesepuluh", "kesebelas");
		}
	
		$temp = "";
		if ($x <12) {
			$temp = " ". $angka[$x];
		} else if ($x <20) {
			$temp = $this->kekataPasalUU($x - 10). " belas";
		} else if ($x <100) {
			$temp = $this->kekataPasalUU($x/10)." puluh". $this->kekataPasalUU($x % 10);
		} else if ($x <200) {
			$temp = " seratus" . $this->kekataPasalUU($x - 100);
		} else if ($x <1000) {
			$temp = $this->kekataPasalUU($x/100) . " ratus" . $this->kekataPasalUU($x % 100);
		} else if ($x <2000) {
			$temp = " seribu" . $this->kekataPasalUU($x - 1000);
		} else if ($x <1000000) {
			$temp = $this->kekataPasalUU($x/1000) . " ribu" . $this->kekataPasalUU($x % 1000);
		} else if ($x <1000000000) {
			$temp = $this->kekataPasalUU($x/1000000) . " juta" . $this->kekataPasalUU($x % 1000000);
		} else if ($x <1000000000000) {
			$temp = $this->kekataPasalUU($x/1000000000) . " milyar" . $this->kekataPasalUU(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
			$temp = $this->kekataPasalUU($x/1000000000000) . " trilyun" . $this->kekataPasalUU(fmod($x,1000000000000));
		}
		return $temp;
	}
	
	public function terbilangPasalUU($x, $style = 4, $string = 0){
		if($x < 0){
			$hasil = "minus ". trim($this->kekataPasalUU($x, $string));
		} else {
			$hasil = trim($this->kekataPasalUU($x, $string));
		}
		switch ($style) {
			case 1:
				$hasil = strtoupper($hasil);
				break;
			case 2:
				$hasil = strtolower($hasil);
				break;
			case 3:
				$hasil = ucwords($hasil);
				break;
			default:
				$hasil = ucfirst($hasil);
				break;
		}
		return $hasil;
	}
	
	public function subsiderCountPasalUU($x){
		$lebih = '';
		for($i = 1; $i < $x; $i++){
			$lebih .= ' Lebih ';
		}
		return $lebih;
	}
	
	public function createAtauPasalUU($varTau, $count){
		return ($varTau < $count)?' Atau <br />':'';
	}
	
	public function explodeAtauPasalUU($atau){
		$proses = explode('Atau', $atau);
		$count  = count($proses);
		$hasil 	= '';
		$varTau = 0;
		$str_atau = '';
	
		foreach($proses as $keyP => $valP){
			$hasil .= ' '.$this->terbilangPasalUU(++$varTau, 3, 1).' '.$valP.$this->createAtauPasalUU($varTau, $count);
		}
		return $hasil;
	}
	
	public function getGeneratePasalUU($model){
		$data_dakwaan = array('','Juncto','Dan','Atau','Subsider');
		$hasil = '';
		foreach($model as $key => $val){
			$hasil .= $val['pasal'].' '.$val['undang'].' '.$data_dakwaan[$val['dakwaan']].' ';
		}
	
		$subsider 	= explode('Subsider', $hasil);
		$dan 		= explode('Dan', $hasil);
		$Catau      = explode('Atau', $hasil);
		$atau       = $hasil;
		
		$hasil_akhir = "";
	
		$countS = count($subsider);
		if(count($subsider) > 1){
			$hasil_akhir .= 'Primer  ';
			$i = 0;
			foreach($subsider AS $key=>$val){
				if($key == 0){
					$eDan    = explode('Dan', $val);
					$eTau1   = explode('Atau', $val);
					$countD  = count($eDan);
					if(count($eDan) > 1){
						$ii = 0;
						foreach($eDan As $keyDan => $valDan){
							$hasil_akhir .= $this->terbilangPasalUU((++$ii),3,0).' ';
							$eTau = explode('Atau', $valDan);
							if(count($eTau) > 1){
								$hasil_akhir .= $this->explodeAtauPasalUU($valDan).' ';
							} else{
								$hasil_akhir .= $valDan.' ';
							}
							if($ii < $countD){
								$hasil_akhir .= 'Dan  ';
							}
						}
					} else if(count($eTau1) > 1){
						if(count($eTau1) > 1){
							echo $this->explodeAtauPasalUU($val).' ';
						} else{
							echo $val.' ';
						}
					} else{
						echo $val.' ';
					}
				}
	
				if($key != 0){
					$hasil_akhir .= $val.' ';
				}
	
				if(++$i < $countS){
					$hasil_akhir .= $this->subsiderCountPasalUU($i);
					$hasil_akhir .= 'Subsider';
				}
	
			}
		} else if(count($dan)>1){
			$countD  = count($dan);
			$ii = 0;
			foreach($dan as $keyDan => $valDan){
				$hasil_akhir .= $this->terbilangPasalUU((++$ii), 3, 0).' ';
				$eTau = explode('Atau', $valDan);
				if(count($eTau) > 1){
					$hasil_akhir .= $this->explodeAtauPasalUU($valDan).' ';
				} else{
					$hasil_akhir .= $valDan.' ';
				}
				if($ii < $countD){
					$hasil_akhir .= 'Dan  ';
				}
			}
		} else if(count($Catau) > 1){
			$hasil_akhir = $this->explodeAtauPasalUU($atau).' ';
		} else{
			 $hasil_akhir = $hasil;
		}
		return $hasil_akhir;
	}
        
        public function getTtdPengadilan(){
            $query 	= new Query;
            $query->select('*')->from('pidum.pdm_config');
            $hasil = $query->createCommand()->queryOne();
            return (object)$hasil;
	}

}
