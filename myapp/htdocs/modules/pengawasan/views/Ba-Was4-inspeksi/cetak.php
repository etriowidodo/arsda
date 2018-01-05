<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/ba_was_4_inspeksi.docx');
        /*Tempat BAwas4*/
        $tempat=$model['tempat_ba_was_4'];
        /*tanggal BAwas4*/
        $tanggal=$tgl_bawas4;
        /*Nama BAwas4*/
        $nama=$model['nama_saksi_eksternal'];
        /*Pendidikan Saksi Eksternal*/
        $pendidikan=$model['pendidikan_eks'];
        /*Pekerjaan Saksi Eksternal*/
        $pekerjaan=$model['pekerjaan_saksi_eksternal'];
        /*Agama Saksi Eksternal*/
        $agama=$model['agama_eks'];
        /*Alamat Saksi Eksternal*/
        $alamat=$model['alamat_saksi_eksternal'];
        /*Kewarganegaraan Saksi Eksternal*/
        $kewarganegaraan=$model['negara_eks'];
        /*Ttl Saksi Eksternal*/
        $ttl=$tgl_lahir.','.$model['tempat_lahir_saksi_eksternal'];
        
        
       
         /*Peratanyaan*/
        $pertanyaan="";
        $no_pertanyaan=1;
        $pertanyaan .="<table width='100%' style='font-family:arial;'>";
        foreach ($modelPertanyaan as $rowPertanyaan) {
            $pertanyaan .="<tr>
                            <td width='5%'>".$no_pertanyaan."</td>
                            <td width='95%'>".$rowPertanyaan['pernyataan_ba_was_4']."</td>
                          </tr>";
            $no_pertanyaan++;
        }
        $pertanyaan .="</table>";
        

        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('nama'=>strtoupper($nama)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal'=>$tgl_bawas4), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>strtoupper($tempat)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('pertanyaan', 'block', $pertanyaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('pendidikan'=>$pendidikan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pekerjaan'=>$pekerjaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('agama'=>$agama), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('alamat'=>$alamat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kewarganegaraan'=>$kewarganegaraan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttl'=>$ttl), array('parseLineBreaks'=>true));

        $docx->createDocx('template/pengawasan/ba_was_4_inspeksi');
		
        $file = 'template/pengawasan/ba_was_4_inspeksi.docx';

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