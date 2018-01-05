<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\P16;

	$this->title = 'RP-7';
        $this->subtitle = 'Register Penerimaan Berkas Tahap I';
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."'";
	$linkBatal		= '/pidsus/pds-terima-berkas/index';
	$tgl_berkas 	= ($model['tgl_berkas'])?date('d-m-Y',strtotime($model['tgl_berkas'])):'';
	$tgl_spdp 	= ($model['tgl_spdp'])?date('d-m-Y',strtotime($model['tgl_spdp'])):'';
	$tgl_terima 	= ($model['tgl_terima'])?date('d-m-Y',strtotime($model['tgl_terima'])):'';
	$arrTglPerkara  = explode("-", $model['tgl_kejadian_perkara']);
?>


<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-terima-berkas/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">SPDP</h3></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor SPDP</label>
                    <div class="col-md-8">
                        <?php if($model['no_spdp']){ ?>
                        <input type="text" name="no_spdp" id="no_spdp" maxlength="50" class="form-control" value="<?php echo $model['no_spdp']; ?>" required data-error="Nomor SPDP belum diisi" readonly />
                        <?php } else{ ?>
                        <div class="input-group">
                            <input type="text" name="no_spdp" id="no_spdp" maxlength="50" class="form-control" value="<?php echo $model['no_spdp']; ?>" required data-error="Nomor SPDP belum diisi" readonly />
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success btn-sm" id="btn_tambahspdp" title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="help-block with-errors" id="error_custom_no_spdp"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal SPDP</label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_spdp" id="tgl_spdp" class="form-control" value="<?php echo $tgl_spdp; ?>" readonly />
                        <div class="help-block with-errors" id="error_custom_tgl_spdp"></div>
                    </div>
            	</div>
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Terima</label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_terima" id="tgl_terima" class="form-control" value="<?php echo $tgl_terima; ?>" readonly />
                        <div class="help-block with-errors" id="error_custom_tgl_terima"></div>
                    </div>
            	</div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Penyidik</label>        
                    <div class="col-md-8">
                        <input type="text" name="inst_penyidik" id="inst_penyidik" class="form-control" value="<?php echo $model['nama_inst_penyidik'];?>" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Pelaksana Penyidikan</label>        
                    <div class="col-md-8">
                        <input type="text" name="inst_pelaksana" id="inst_pelaksana" class="form-control" value="<?php echo $model['nama_inst_pelaksana'];?>" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Berkas</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_berkas" id="no_berkas" class="form-control" value="<?php echo $model['no_berkas'];?>" maxlength="64" required data-error="Nomor Berkas belum diisi" <?php echo ($model['statusnya']!='Berkas' && !$isNewRecord?'readonly':'');?> />    
                                <div class="help-block with-errors" id="error_custom_no_berkas"></div>
                            </div>
                        </div>
                    </div>        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Berkas</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_berkas" id="tgl_berkas" class="form-control datepicker" value="<?php echo $tgl_berkas;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal berkas belum diiisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_berkas"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No P16</label>        
                            <div class="col-md-8">
                                <select id="no_p16" name="no_p16" class="select2" style="width:100%;" required data-error="No P-16 belum dipilih">
                                    <option></option>
                                    <?php 
                                    if(!$isNewRecord){
                                        $kue1 = "select a.no_p16, to_char(a.tgl_dikeluarkan, 'DD-MM-YYYY') as tgl_p16 from pidsus.pds_p16 a 
												where ".$whereDefault." and no_spdp='".$model['no_spdp']."' and tgl_spdp='".$model['tgl_spdp']."' order by a.no_p16";
										$jns1 = P16::findBySql($kue1)->asArray()->all();
                                        foreach($jns1 as $ji){
											$selected = ($ji['no_p16'] == $model['no_p16'])?'selected':'';
											echo '<option value="'.$ji['no_p16'].'|#|'.$ji['tgl_p16'].'" '.$selected.'>'.$ji['no_p16'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal P-16</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_p16" id="tgl_p16" class="form-control" value="<?php echo $model['tgl_p16'];?>" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
	<div class="col-md-12">
        <div class="box box-primary form-buat-pengantar">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahpng"><i class="fa fa-plus jarak-kanan"></i>Pengantar</a></div>	
                    <div class="col-sm-2"><div class="text-right"><a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn">Hapus</a></div></div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table_pengantar">
                        <thead>
                            <tr>
                                <th class="text-center" width="20%">No Pengantar</th>
                                <th class="text-center" width="15%">Tanggal Pengantar</th>
                                <th class="text-center" width="10%">Tanggal Terima</th>
                                <th class="text-center" width="25%">Nama Tersangka</th>
                                <th class="text-center" width="25%">Undang-Undang</th>
                                <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
							$sqlnya = "
							with tbl_pnt_uun as(
								select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, 
								string_agg(undang||'--'||pasal||'--'||dakwaan, '#' order by no_urut) as undang_undang  
								from pidsus.pds_terima_berkas_pengantar_uu 
								group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar
							), tbl_pnt_tsk as(
								select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar, 
								string_agg(no_urut||'--'||nama, '#' order by no_urut) as tersangka 
								from pidsus.pds_terima_berkas_tersangka 
								group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, no_pengantar
							)
							select a.no_pengantar, a.tgl_pengantar, a.tgl_terima, b.undang_undang, c.tersangka, d.tgl_kejadian_perkara, d.tempat_kejadian 
							from pidsus.pds_terima_berkas_pengantar a 
							join pidsus.pds_spdp d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
								and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp
							left join tbl_pnt_uun b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
								and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas and a.no_pengantar = b.no_pengantar 
							left join tbl_pnt_tsk c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
								and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp and a.no_berkas = c.no_berkas and a.no_pengantar = c.no_pengantar	
							where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.tgl_pengantar asc"; 
                             $hasil = P16::findBySql($sqlnya)->asArray()->all();
                            if(count($hasil) == 0)
                                echo '<tr><td colspan="6">Tidak ada pengantar</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;	
									$arrTsk = explode("#", $data['tersangka']);
									$arrUun = explode("#", $data['undang_undang']);
									$kolom0 = '
									<input type="hidden" value="'.$model['nama_inst_penyidik'].'" class="pntBrks" name="inst_penyidik_pengantar['.$nom.']" />
									<input type="hidden" value="'.$model['nama_inst_pelaksana'].'" class="pntBrks" name="inst_pelaksana_pengantar['.$nom.']" />
									<input type="hidden" value="'.$model['no_berkas'].'" class="pntBrks" name="no_berkas_pengantar['.$nom.']" />
									<input type="hidden" value="'.$tgl_berkas.'" class="pntBrks" name="tgl_berkas_pengantar['.$nom.']" />
									<input type="hidden" value="'.$data['no_pengantar'].'" class="pntBrks" name="no_pengantar['.$nom.']" />
									<input type="hidden" value="'.date("d-m-Y", strtotime($data['tgl_pengantar'])).'" class="pntBrks" name="tgl_pengantar['.$nom.']" />
									<input type="hidden" value="'.date("d-m-Y", strtotime($data['tgl_terima'])).'" class="pntBrks" name="tgl_terima['.$nom.']" />
									<input type="hidden" value="'.$arrTglPerkara[0].'" class="pntBrks waktu_kejadian0" name="waktu_kejadian['.$nom.'][0]" />
									<input type="hidden" value="'.$arrTglPerkara[1].'" class="pntBrks waktu_kejadian1" name="waktu_kejadian['.$nom.'][1]" />
									<input type="hidden" value="'.$arrTglPerkara[2].'" class="pntBrks waktu_kejadian2" name="waktu_kejadian['.$nom.'][2]" />
									<input type="hidden" value="'.$arrTglPerkara[3].'" class="pntBrks waktu_kejadian3" name="waktu_kejadian['.$nom.'][3]" />
									<input type="hidden" value="'.$arrTglPerkara[4].'" class="pntBrks waktu_kejadian4" name="waktu_kejadian['.$nom.'][4]" />
									<input type="hidden" value="'.$model['tempat_kejadian'].'" class="pntBrks tmp_kejadian" name="tmp_kejadian['.$nom.']" />';
									
									$sqlTsk = "
										select a.*, b.nama as kebangsaan 
										from pidsus.pds_terima_berkas_tersangka a 
										left join public.ms_warganegara b on a.warganegara = b.id 
										where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' and a.no_pengantar = '".$data['no_pengantar']."' 
										order by a.no_urut asc";
									$resTsk = P16::findBySql($sqlTsk)->asArray()->all();
									if(count($resTsk) > 0){
										foreach($resTsk as $idx2=>$val2){
											$tgl_lahir = date("d-m-Y", strtotime($val2['tgl_lahir']));
											$kolom0 .= '
											<input type="hidden" value="'.$val2['no_urut'].'" class="pntBrks" name="no_urut['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['nama'].'" class="pntBrks" name="nama['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['tmpt_lahir'].'" class="pntBrks" name="tmpt_lahir['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$tgl_lahir.'" class="pntBrks" name="tgl_lahir['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['umur'].'" class="pntBrks" name="umur['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['warganegara'].'" class="pntBrks" name="warganegara['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['kebangsaan'].'" class="pntBrks" name="kebangsaan['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['suku'].'" class="pntBrks" name="suku['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['id_identitas'].'" class="pntBrks" name="id_identitas['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['no_identitas'].'" class="pntBrks" name="no_identitas['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['id_jkl'].'" class="pntBrks" name="id_jkl['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['id_agama'].'" class="pntBrks" name="id_agama['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['alamat'].'" class="pntBrks" name="alamat['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['no_hp'].'" class="pntBrks" name="no_hp['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['id_pendidikan'].'" class="pntBrks" name="id_pendidikan['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['pekerjaan'].'" class="pntBrks" name="pekerjaan['.$nom.']['.($idx2+1).']" />';
										}
									}
									
									$sqlUun = "
										select a.undang, b.id, a.pasal, c.id_pasal, a.dakwaan 
										from pidsus.pds_terima_berkas_pengantar_uu a 
										join pidsus.ms_u_undang b on a.undang = b.uu 
										join pidsus.ms_pasal c on b.id = c.id and a.pasal = c.pasal
										where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' and a.no_pengantar = '".$data['no_pengantar']."' 
										order by a.no_urut asc";
									$resUun = P16::findBySql($sqlUun)->asArray()->all();
									if(count($resUun) > 0){
										foreach($resUun as $idx2=>$val2){
											$kolom0 .= '
											<input type="hidden" value="'.$val2['id'].'" class="pntBrks" name="undang_id['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['undang'].'" class="pntBrks" name="undang_uu['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['id_pasal'].'" class="pntBrks" name="id_pasal['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['pasal'].'" class="pntBrks" name="pasal['.$nom.']['.($idx2+1).']" />
											<input type="hidden" value="'.$val2['dakwaan'].'" class="pntBrks" name="dakwaan['.$nom.']['.($idx2+1).']" />';
										}
									}

									if(count($arrTsk) > 0){
										$kolom4 = '';
										foreach($arrTsk as $idx=>$val){
											$tempo1 = explode("--", $val);
											$kolom4 .= '<p style="margin-bottom:2px;">'.$tempo1[0].'. '.$tempo1[1].'</p>';
										}
									}
							
									if(count($arrUun) > 0){
										$kolom5 = '';
										foreach($arrUun as $idx=>$val){
											$arrTem = array("", "Juncto", "Dan", "Atau", "Subsider");
											$tempo1 = explode("--", $val);
											$kolom5 .= $tempo1[1].' '.$tempo1[0].' '.$arrTem[$tempo1[2]].' ';
										}
									}

									echo '
									<tr data-id="'.$nom.'">
										<td>'.$kolom0.'<a class="ubahPengantar" style="cursor:pointer">'.$data['no_pengantar'].'</td>
										<td class="text-center">'.date("d-m-Y", strtotime($data['tgl_pengantar'])).'</td>
										<td class="text-center">'.date("d-m-Y", strtotime($data['tgl_terima'])).'</td>
										<td>'.$kolom4.'</td>
										<td>'.$kolom5.'</td>
										<td class="text-center">
											<input type="checkbox" name="chk_del_pnt['.$nom.']" id="chk_del_pnt'.$nom.'" class="hRowJpn" value="'.$nom.'">
										</td>
									</tr>';
								}
							}
                         ?>	
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
	</div>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="tgl_kejadian_perkara_spdp" id="tgl_kejadian_perkara_spdp" value="<?php echo $model['tgl_kejadian_perkara'];?>" />
	<input type="hidden" name="tmp_kejadian_spdp" id="tmp_kejadian_spdp" value="<?php echo $model['tempat_kejadian'];?>" />
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pengantar Berkas Tahap I</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="spdp_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">SPDP</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	h3.box-title{
		font-weight: bold;
	}
	.form-horizontal .form-group-sm .control-label{
		font-size: 12px;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
		font-size: 12px;
	}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: arial;
		font-size: 11px;
	}
	fieldset.scheduler-border{
		border: 1px solid #ddd;
		margin:0;
		padding:10px;
	}
	legend.scheduler-border{
		border-bottom: none;
		width: inherit;
		margin:0;
		padding:0px 5px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#no_p16').on('change',function(){
		var id = $(this).val();
		var tm = id.toString().split('|#|');
		$("#tgl_p16").val(tm[1]);
	});
        
	$(".form-buat-pengantar").on("click", "#btn_tambahpng", function(){
		var no_berkas 		= $("#no_berkas").val();
		var tgl_berkas 		= $("#tgl_berkas").val();
		var no_spdp         = $("#no_spdp").val();
		var tgl_spdp        = $("#tgl_spdp").val();
		var inst_penyidik 	= $("#inst_penyidik").val();
		var inst_pelaksana 	= $("#inst_pelaksana").val();
		var kejadian_spdp 	= $("#tgl_kejadian_perkara_spdp").val();
		var tmp_kejadian 	= $("#tmp_kejadian_spdp").val();
		if(no_spdp == ""){
			bootbox.alert({message: "Silahkan Pilih SPDP terlebih dahulu", size: 'small'});
		} else if(no_berkas == "" || tgl_berkas == ""){
			bootbox.alert({message: "Silahkan isi No Berkas dan Tanggal Berkas terlebih dahulu", size: 'small'});
		} else{
			var cek_tgl_terima 	= new Date(tgl_auto($("#tgl_terima").val()));
			var cek_tgl_berkas 	= new Date(tgl_auto($("#tgl_berkas").val()));
			$(".with-errors").html("");
			if(cek_tgl_berkas < cek_tgl_terima){
				$("#error_custom_tgl_berkas").html('<i style="color:#dd4b39; font-size:12px;">Tanggal berkas tidak boleh lebih kecil daripada tanggal terima SPDP</i>');
				setErrorFocus($("#tgl_berkas"), $("#role-form"), false);
			} else{
				$(".with-errors").html("");
				$("#jpn_modal").find(".modal-body").html("");
				$("#jpn_modal").find(".modal-body").load("/pidsus/pds-terima-berkas/getpengantar",function(e){
					var tabel = $("#table_pengantar > tbody").find("tr:last");
					var cekin = tabel.find(".waktu_kejadian0").length;
					var temp  = kejadian_spdp.split("-");
					$("#jpn_modal").find("#no_berkas_pengantar").val(no_berkas);
					$("#jpn_modal").find("#tgl_berkas_pengantar").val(tgl_berkas);
					$("#jpn_modal").find("#inst_penyidik_pengantar").val(inst_penyidik);
					$("#jpn_modal").find("#inst_pelaksana_pengantar").val(inst_pelaksana);
					$("#jpn_modal").find("#modal1_waktu_kejadian0").val((cekin == 0?temp[0]:tabel.find(".waktu_kejadian0").val()));
					$("#jpn_modal").find("#modal1_waktu_kejadian1").val((cekin == 0?temp[1]:tabel.find(".waktu_kejadian1").val()));
					$("#jpn_modal").find("#modal1_waktu_kejadian2").val((cekin == 0?temp[2]:tabel.find(".waktu_kejadian2").val()));
					$("#jpn_modal").find("#modal1_waktu_kejadian3").val((cekin == 0?temp[3]:tabel.find(".waktu_kejadian3").val()));
					$("#jpn_modal").find("#modal1_waktu_kejadian4").val((cekin == 0?temp[4]:tabel.find(".waktu_kejadian4").val()));
					$("#jpn_modal").find("#modal1_tmp_kejadian").val((cekin == 0?tmp_kejadian:tabel.find(".tmp_kejadian").val()));
					$("#nurec_pengantar").val('1');
					$("#simpan_form_pengantar").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
				});
				$("#jpn_modal").modal({backdrop:"static"});
			}
		}
	}).on("click", ".ubahPengantar", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".pntBrks").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-terima-berkas/getpengantar", objk, function(data){
			$("#jpn_modal").find(".modal-body").html("");
			$("#jpn_modal").find(".modal-body").html(data);
			$("#jpn_modal").find("#no_berkas_pengantar").val($("#no_berkas").val());
			$("#jpn_modal").find("#tgl_berkas_pengantar").val($("#tgl_berkas").val());
			$("#jpn_modal").find("#tr_id_pengantar").val(trid);
			$("#jpn_modal").find("#nurec_pengantar").val('0');
			$("#jpn_modal").find("#simpan_form_pengantar").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
			$("#jpn_modal").modal({backdrop:"static", keyboard:false});
		});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pengantar").find("#table_pengantar");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pengantar").find("#table_pengantar > tbody");
				nRow.append('<tr><td colspan="6">Tidak ada pengantar</td></tr>');
				$("#btn_hapusjpn").addClass("disabled");
			}
		});
	}).on("ifChecked", "#table_pengantar input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#table_pengantar input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#table_pengantar .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n >= 1)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	}).on("ifUnchecked", "#table_pengantar .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});

	$("#jpn_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		$("#frm-pengantar").validator({disable:false});
		$("#frm-pengantar").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#frm-pengantar").find(".with-errors").html("");
				var frmArrUU = $("#table_uu").find(".txtUndangPasal").serializeArray();
				var validate = true;
				var cek_tgl_berkas_pengantar= new Date(tgl_auto($("#tgl_berkas_pengantar").val()));
				var cek_modal1_tgl_pengantar= new Date(tgl_auto($("#modal1_tgl_pengantar").val()));
				var cek_modal1_tgl_terima 	= new Date(tgl_auto($("#modal1_tgl_terima").val()));
				var cek_hariIni 			= new Date('<?php echo date('Y-m-d');?>');
				/*$.each(frmArrUU, function(i,v){
					if(v.value == ""){
						validate = false;
						var idnya = v.name.replace(/[\[\]]/g, "");
						var stnya = (v.name.search("undang") > 0)?'Undang-undang':'Pasal';
						$("#error_custom_"+idnya).html('<i style="color:#dd4b39; font-size:12px;">'+stnya+' belum dipilih</i>');
						$("#jpn_modal").animate({scrollTop: $("#error_custom_"+idnya).offset().top-30 + "px"});
						return false;
					}
				});*/
				if(validate && $("#table_tersangka > tbody").find("tr").length == 0){
					$("#error_custom_tersangka").html('<i style="color:#dd4b39; font-size:12px;">Tersangka belum dipilih</i>');
					$("#jpn_modal").animate({scrollTop: $("#error_custom_tersangka").offset().top-30 + "px"});
					return false;
				} else if(validate && cek_modal1_tgl_pengantar < cek_tgl_berkas_pengantar){
					$("#error_custom_modal1_tgl_pengantar").html('<i style="color:#dd4b39; font-size:12px;">Tanggal pengantar tidak boleh lebih kecil daripada tanggal berkas</i>');
					$("#jpn_modal").animate({scrollTop: $("#error_custom_modal1_tgl_pengantar").offset().top-30 + "px"});
					return false;
				} else if(validate && cek_modal1_tgl_terima < cek_modal1_tgl_pengantar){
					var pesanErr = "Tanggal diterima pengantar tidak boleh lebih kecil daripada tanggal pengantar";
					$("#error_custom_modal1_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">'+pesanErr+'</i>');
					$("#jpn_modal").animate({scrollTop: $("#error_custom_modal1_tgl_terima").offset().top-30 + "px"});
					return false;
				} else if(validate && cek_modal1_tgl_terima > cek_hariIni){
					$("#error_custom_modal1_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal diterima pengantar adalah hari ini</i>');
					$("#jpn_modal").animate({scrollTop: $("#error_custom_modal1_tgl_terima").offset().top-30 + "px"});
					return false;
				} else if(validate){
					$("#evt_pengantar_sukses").trigger("validasi.oke.pengantar");
					return false;
				}
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		if($(e.target).attr("id") == "jpn_modal")
			$(this).find('form#frm-pengantar').off('submit').validator('destroy');
	}).on("validasi.oke.pengantar", "#evt_pengantar_sukses", function(){
		var frmnya = $("#jpn_modal").find("#frm-pengantar").serializeArray();
		var arrnya = {};
		$.each(frmnya, function(k, v){ arrnya[v.name] = v.value; });
		$("#table_pengantar").find(".waktu_kejadian0").val(arrnya['modal1_waktu_kejadian[0]']);
		$("#table_pengantar").find(".waktu_kejadian1").val(arrnya['modal1_waktu_kejadian[1]']);
		$("#table_pengantar").find(".waktu_kejadian2").val(arrnya['modal1_waktu_kejadian[2]']);
		$("#table_pengantar").find(".waktu_kejadian3").val(arrnya['modal1_waktu_kejadian[3]']);
		$("#table_pengantar").find(".waktu_kejadian4").val(arrnya['modal1_waktu_kejadian[4]']);
		$("#table_pengantar").find(".tmp_kejadian").val(arrnya['modal1_tmp_kejadian']);
		if(arrnya['nurec_pengantar'] == 1){
			var tabel 	= $("#table_pengantar");
			var rwTbl	= tabel.find('tbody > tr:last');
			var rwNom	= parseInt(rwTbl.data('id'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-terima-berkas/setpengantar", frmnya, function(data){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(data.hasil);
				} else{
					rwTbl.after(data.hasil);
				}
				$("#chk_del_pnt"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#jpn_modal").modal('hide');
			}, "json");
		} else{
			var tabel = $("#table_pengantar").find("tr[data-id='"+arrnya['tr_id_pengantar']+"']");
			var newId = arrnya['tr_id_pengantar'];
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-terima-berkas/setpengantar", frmnya, function(data){
				tabel.html(data.hasil);
				$("#chk_del_pnt"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#jpn_modal").modal('hide');
			}, "json");
		}
	});
        
        /* START AMBIL SPDP */
	$("#btn_tambahspdp").on('click', function(e){
		$("#spdp_modal").find(".modal-body").load("/pidsus/pds-terima-berkas/getspdp");
		$("#spdp_modal").modal({backdrop:"static"});
	});
	
	$("#spdp_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-spdp-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToSpdp(param);
		$("#spdp_modal").modal("hide");
	}).on('click', "#idPilihSpdpModal", function(){
		var modal = $("#spdp_modal").find("#table-spdp-modal");
		var index = modal.find(".pilih-spdp-modal:checked").val();
		var param = index.toString().split('#');
		insertToSpdp(param);
		$("#spdp_modal").modal("hide");
	});
	function insertToSpdp(param){
		$("#no_spdp").val(param[0]);
		$("#tgl_spdp").val(param[1]);
		$("#tgl_terima").val(param[2]);
		$("#inst_penyidik").val(param[3]);
		$("#inst_pelaksana").val(param[4]);
		$("#tgl_kejadian_perkara_spdp").val(param[5]);
		$("#tmp_kejadian_spdp").val(param[6]);
                
		$("#no_p16").val("").trigger('change').select2('close');
		$("#no_p16 option").remove();
		$.ajax({
			type	: "POST",
			url	: "/pidsus/pds-terima-berkas/getnop16",
			dataType: 'json',
			data	: { q1 : param[0]+"|#|"+param[1] },
			cache	: false,
			success : function(data){ 
				if(data.items != ""){
					$("#no_p16").select2({ 
							data 		: data.items, 
							placeholder     : "Pilih salah satu", 
							allowClear 	: true, 
					});
					return false;
				}
			}
		})
	}
	/* END AMBIL SPDP */

});	
</script>