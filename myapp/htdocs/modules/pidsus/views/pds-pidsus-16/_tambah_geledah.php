<?php
use app\modules\pidsus\models\PdsPidsus16;

?>
<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="row">        
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Penggeledahan Terhadap</label>        
                                    <div class="col-md-7">
                                        <select name="geledah_thp" id="geledah_thp" class="select2" style="width:100%">
                                            <option></option>
                                            <option value="1">Subyek</option>
                                            <option value="2">Obyek</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row subyek" hidden="">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Nama</label>        
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $model['nama'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Jabatan</label>        
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $model['jabatan'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row obyek" hidden="">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Tempat Penggeledahan</label>        
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="tmpt_geledah" name="tmpt_geledah" value="<?php echo $model['tmpt_geledah'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Alamat Penggeledahan</label>        
                                    <div class="col-md-7">
                                        <textarea class="form-control" id="almt_geledah" name="almt_geledah" style="height: 70px"></textarea>
                                        <div class="help-block with-errors"></div>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pemilik</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Nama</label>        
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo $model['nama_pemilik'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Pekerjaan</label>        
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="pekerjan" name="pekerjan" value="<?php echo $model['pekerjan'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-5">Alamat</label>        
                                    <div class="col-md-7">
                                        <textarea class="form-control" id="almt_pemilik" name="almt_pemilik" style="height: 100px"></textarea>
                                        <div class="help-block with-errors"></div>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a></div>	
                            <div class="col-sm-2"><div class="text-right"><a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn">Hapus</a></div></div>	
                        </div>		
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-jpn-modal">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center" width="30%">NIP / Nama</th>
                                        <th class="text-center" width="60%">Jabatan / Pangkat &amp; Golongan</th>
                                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="4">Data tidak ditemukan</td></tr>
                                <?php 
//                                    $sqlnya = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
//                                                from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
//                                    $hasil = PdsPidsus16::findBySql($sqlnya)->asArray()->all();
//                                    if(count($hasil) == 0)
//                                        echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
//                                    else{
//                                        $nom = 0;
//                                        foreach($hasil as $data){
//                                            $nom++;	
//                                                                                $idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];						
                                 ?>	
<!--                                      <tr data-id="<?php echo $data['nip'];?>">
                                        <td class="text-center">
                                            <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                            <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                        </td>
                                        <td class="text-left"><?php echo $data['nama'];?></td>
                                        <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                        </td>
                                     </tr>-->
                                 <?php //} } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>			
                </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Waktu Pelaksanaan</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm" style="margin:0px 0px 15px;">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="border:none; padding-left:0px; font-size:12px; width:55px; text-align:left;">Jam</div>
                                        <select name="waktu_kejadian[0]" id="waktu_kejadian0" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
                                                    for($i=0; $i<=23; $i++){
                                                            $sel0 = ($waktu[0] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
                                                            echo '<option '.$sel0.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
                                                    }

                                            ?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[1]" id="waktu_kejadian1" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
                                                    for($i=0; $i<=59; $i++){
                                                            $sel1 = ($waktu[1] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
                                                            echo '<option '.$sel1.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
                                                    }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm" style="margin:0px 0px 15px;">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="border:none; padding-left:0px; font-size:12px; width:55px; text-align:left;">Tanggal</div>
                                        <select name="waktu_kejadian[2]" id="waktu_kejadian2" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
                                                    for($i=1; $i<=31; $i++){
                                                            $sel2 = ($waktu[2] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
                                                            echo '<option '.$sel2.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
                                                    }

                                            ?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[3]" id="waktu_kejadian3" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
                                                    for($i=1; $i<=12; $i++){
                                                            $sel3 = ($waktu[3] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
                                                            echo '<option '.$sel3.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
                                                    }

                                            ?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[4]" id="waktu_kejadian4" class="form-control" style="height:30px; border:1px solid #f29db2; width:70px;">
                                            <option></option>
                                            <?php 
                                                    for($i=date("Y")-2; $i<=date("Y"); $i++){
                                                            $sel4 = ($waktu[4] == $i)?'selected':'';
                                                            echo '<option '.$sel4.'>'.$i.'</option>';
                                                    }

                                            ?>
                                        </select>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Keperluan</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">       
                                    <div class="col-md-12">
                                        <textarea class="form-control" id="keperluan" name="keperluan" style="height: 100px"></textarea>
                                        <div class="help-block with-errors"></div>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Keterangan</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">       
                                    <div class="col-md-12">
                                        <textarea class="form-control" id="keterangan" name="keterangan" style="height: 100px"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer" style="text-align:center;">
            <button class="btn btn-warning jarak-kanan pilih-jpn" id="simpan_usul" type="button">Simpan</button>
            <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
        </div>
    </form>
</div>
<style>
	#wrapper-modal-tsk.loading {overflow: hidden;}
	#wrapper-modal-tsk.loading .modal-loading-new {display: block;}

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
</style>
<div class="modal-loading-new"></div> 
<script type="text/javascript">
	$(document).ready(function(){
            var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
            $(".datepicker").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            });
            $(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
            $('.allCheckJpn').iCheck({checkboxClass:'icheckbox_square-pink'});
            
            $('#geledah_thp').on('change',function(){
                var nilai=$(this).val();
                if(nilai==1){
                    $('.obyek').slideUp();
                    $('.subyek').slideDown();
                }else if(nilai==2){
                    $('.subyek').slideUp();
                    $('.obyek').slideDown();
                }
            });
	});
</script>