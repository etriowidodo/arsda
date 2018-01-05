<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was27-klari.docx');
        
        $headerImage = new WordFragment($docx, 'defaultHeader');
        $x  ='<div style="text-align:center;"><h1 style="text-indent: 10px;">KEJAKSAAN AGUNG REPUBLIK INDONESIA</h1><h1 style="text-indent: 10px;">JAKARTA</h1><div>';
        // $x .='<div style="text-align:center;"><div>';
        $paragraphOptions = array(
'bold' => true,
'font' => 'Arial'
);
        $headerImage->embedHTML($x);
        $docx->addHeader(array('first' => $headerImage),$paragraphOptions);

        if($model->sifat_surat='1'){
          $sifat='BIASA';
          $akr_sifat='B';
        }else  if($model->sifat_surat='2'){
          $sifat='SEGERA';
           $akr_sifat='S';
        }else  if($model->sifat_surat='3'){
          $sifat='RAHASIA';
           $akr_sifat='R';
        }
        // $html  ='<div style="text-align:center"><h1>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h1><div>';
        // $html .='<div style="text-align:center"><h1>Jakarta</h1><div>';
        $html ='<div style="text-align:center"><hr style="border-width: 4px 1px 0";><div>';
        $html .='<div style="text-align:center"><h3><u>NOTA DINAS</u></h3><div>';
        $html .='<div style="text-align:left"><table>
                    <tr><td>Kepada Yth.</td><td>:</td><td>'.$model->kepada.'</td></tr>
                    <tr><td>D a r i</td><td>:</td><td>'.$model->nama_penandatangan.'</td></tr>
                    <tr><td>Tanggal</td><td>:</td><td>'.date('d F Y', strtotime($model->tgl)).'</td></tr>
                    <tr><td>Nomor</td><td>:</td><td>' .$akr_sifat.'-    '.$model->no_was_27_klari.'</td></tr>
                    <tr><td>Sifat</td><td>:</td><td>'.$sifat.'</td></tr>
                    <tr><td>Lampiran</td><td>:</td><td>'.$model->jml_lampiran.'</td></tr>
                    <tr><td>Perihal</td><td>:</td><td>'.$model->perihal.'</td></tr>';
                  
        $html .='</table><div>';
        $html .='<div style="text-align:center"><hr style="border-width: 2px 1px 0";<div>';
        $html .='<div style="text-align:left"><p>Sehubungan dengan Laporan Hasil Klarifikasi Kasus  tanggal '.date('d F Y', strtotime($modelSpWas1->tanggal_sp_was1)).' sesuai Surat Perintah '.$modelSpWas1->nama_penandatangan.' Nomor : '.$modelSpWas1->nomor_sp_was1.' tanggal '.date('d F Y', strtotime($modelSpWas1->tanggal_sp_was1)).', dengan hormat dilaporkan hal-hal sebagai berikut  :</p><div>';
        $html .='<div style="text-align:left"><h3>I. TERLAPOR :</h3><table>';
                     foreach ($modelPenghentian as $key_penghentian) {
           $html .='<tr><td>Nama</td><td>:</td><td> '.$key_penghentian['nama_pegawai_terlapor'].' </td></tr>
                    <tr><td>Pangkat/Gol</td><td>:</td><td>'.$key_penghentian['pangkat_pegawai_terlapor'].' </td></tr>
                    <tr><td>NIP/NRP</td><td>:</td><td> '.substr($key_penghentian['nip'],0,7).' '.substr($key_penghentian['nip'],8,6).' '.substr($key_penghentian['nip'],14,1).' '.substr($key_penghentian['nip'],15,3).' </td></tr>
                    <tr><td>Jabatan</td><td>:</td><td>'.$key_penghentian['jabatan_pegawai_terlapor'].' </td></tr>
                    <tr><td colspan="3"><br></tr>';

                  }

        $html .='</table><div>';
        $html .='<div style="text-align:left"><h3>II. PELAPOR </h3><div style="margin-left: 10px;"> Laporan pengaduan dari '.$modelPelapor[0]['nama_pelapor'].'</div><div>';
        $html .='<div style="text-align:left;"><h3>III. PERMASALAHAN </h3><div style="margin-left: 10px;"> '.$model->permasalahan.'</div><div>';
        $html .='<div style="text-align:left;"><h3>IV. DATA </h3><div style="margin-left: 10px;"> '.$model->data_data.'</div><div>';
        $html .='<div style="text-align:left;"><h3>V. ANALISA </h3><div style="margin-left: 10px;"> '.$model->analisa.'</div><div>';
        $html .='<div style="text-align:left;"><h3>VI. KESIMPULAN </h3><div style="margin-left: 10px;">'.$model->kesimpulan.'</div><div>';
        $html .='<div style="text-align:left;"><h3>VII. RENCANA PENGHENTIAN PEMERIKSAAN </h3><div>';
        foreach ($modelSaran as $keysaran) {
        $html .='<div style="text-align:left;">'.$keysaran->saran.'<div>';

        }
        
        $jabatan=explode('>', $modelPegawai->jabatan_panjang);
        $html .='<div style="text-align:center;"><table width="100%">
                <tr><td width="50%"></td>
                <td style="text-align:center" width="50%"><b>'.$jabatan[1].'<br><br><br>'
                .$modelPegawai->nama.'<br>'
                .$modelPegawai->gol_pangkat2.'<br>'
                .substr($modelPegawai->peg_nip_baru,0,7).' '.substr($modelPegawai->peg_nip_baru,8,6).' '.substr($modelPegawai->peg_nip_baru,14,1).' '.substr($modelPegawai->peg_nip_baru,15,3).'</b></td>
				
                </tr></table><div>';
        // $html .='<div style="text-align:right"><h7>'.$modelPegawai->nama.' </h7><div><br>';
        // $html .='<div style="text-align:right"><h7>'.$modelPegawai->gol_pangkat2.' </h7><div><br>';
        // $html .='<div style="text-align:right"><h7>'.$modelPegawai->peg_nip_baru.' </h7><div><br>';

        $html .='<div style="text-align:left"><h3>VI. PERSETUJUAN/JAKSA AGUNG MUDA PENGAWASAN  </h3><div>';
        $html .='<div style="text-align:left"><h3>Setuju/Tidak Setuju/Pendapat Lain  </h3><div>';
        $html .='<div style="text-align:left">................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................<div>';

      // print_r($modelSpWas1);
      // print_r(count($SaksiEksternal));
      // print_r(explode('>', $modelPegawai->jabatan_panjang));
      // echo $html;
      // exit();
// exit();
        $docx->embedHTML($html, array('downloadImages'=>true));
        // $docx->replaceVariableByHTML('kejaksaan', 'block','<div style="text-align:center;">'.'kkkk' .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was27-klari');
		
        $file = 'template/pengawasan/was27-klari.docx';

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

?>