<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use mdm\admin\models\searchs\Menu as MenuSearch;
	/*$q1 = htmlspecialchars($post['q1'], ENT_QUOTES);
	$q2 = htmlspecialchars($post['q2'], ENT_QUOTES);
	$q3 = htmlspecialchars($post['q3'], ENT_QUOTES);
	$q4 = htmlspecialchars($post['q4'], ENT_QUOTES);*/
	$q5 = htmlspecialchars($post['q5'], ENT_QUOTES);
	$q6 = htmlspecialchars($post['q6'], ENT_QUOTES);
	$tp = htmlspecialchars($post['tp'], ENT_QUOTES);
	$tk = htmlspecialchars($post['tk'], ENT_QUOTES);
?>
<?php if($tp == '06'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
                	<option value="JAMDATUN">JAMDATUN</option>
                	<option value="KAJATI">KAJATI</option>
                	<option value="KAJARI">KAJARI</option>
                	<option value="KACABJARI">KACABJARI</option>
                	<option value="JPN">TIM JPN</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<div id="frm_modal_penerima_ja">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Nama</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="hidden" id="nip_penerima" name="nip_penerima[]" value="<?php echo $q1; ?>" />
                        <input type="text" id="nama_penerima" name="nama_penerima[]" class="form-control" value="<?php echo $q2;?>" readonly />
                        <div class="input-group-btn"><button type="button" name="btn-cari" id="btn-cari-peg" class="btn btn-success btn-sm">...</button></div>
                    </div>
                    <div class="help-block with-errors" id="error_custom5"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Jabatan</label>
                <div class="col-md-8">
                    <input type="text" id="jabatan_penerima" name="jabatan_penerima[]" class="form-control" value="<?php echo ucwords(strtolower($q3));?>" />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
    </div>        
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-4">Alamat Instansi</label>
                <div class="col-md-8">
                    <textarea id="alamat_penerima" name="alamat_penerima[]" class="form-control" style="height:150px;"><?php echo $q4;?></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="frm_modal_penerima_jpn" class="hide">
    <div class="row">
        <div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah JPN</a></div>	
        <div class="col-sm-2"><a class="btn btn-danger btn-sm disabled text-right" id="btn_hapusjpn">Hapus</a></div>	
    </div>
    <p style="margin-bottom:10px;"></p>		

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-jpn-modal">
            <thead>
                <tr>
                    <th class="text-center" width="8%">No</th>
                    <th class="text-center" width="38%">Nama</th>
                    <th class="text-center" width="30%">Pangkat & Golongan</th>
                    <th class="text-center" width="8%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                </tr>
            </thead>
            <tbody>
				<?php 
					$sql1 = "select * from datun.sp1_timjpn where no_register_perkara = '".$q5."' and no_surat = '".$q6."'";
					$res1 = MenuSearch::findBySql($sql1)->asArray()->all();
					if(count($res1) == 0)
						echo '<tr><td colspan="4">JPN tidak ditemukan</td></tr>';
					else{
						foreach($res1 as $idx1=>$data1){
							$nom = ($idx1 + 1);
							$nip = $data1['nip'];
							$nmp = $data1['nama'];
							$gol = $data1['pangkat_jpn']." (".$data1['gol_jpn'].")";
							$wow = $nip."#".$nmp."#".$gol."#".$data1['gol_jpn']."#".$data1['pangkat_jpn']."#".$data1['jabatan_jpn'];

							echo '<tr data-id="'.$nip.'">
								<td class="text-center">
									<span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span>
									<input type="hidden" name="jpnid[]" value="'.$wow.'" />
								</td>
								<td>'.$nip.'<br>'.$nmp.'</td>
								<td>'.$gol.'</td>
								<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'.$nom.'" class="hRowJpn" value="'.$nip.'" /></td>
							</tr>';
						}
					}
                ?>
            </tbody>
        </table>
    </div>
	<div class="help-block with-errors" id="error_custom5A"></div>
</div>
<?php } else{ ?>
<?php if($tk == '0'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
                    <option value="JA">JAKSA AGUNG</option>
                	<option value="JAMDATUN">JAMDATUN</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($tk == '1'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
                    <option value="JA">JAKSA AGUNG</option>
                	<option value="JAMDATUN">JAMDATUN</option>
                	<option value="KAJATI">KAJATI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($tk == '2'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
                    <option value="JA">JAKSA AGUNG</option>
                	<option value="JAMDATUN">JAMDATUN</option>
                	<option value="KAJATI">KAJATI</option>
                	<option value="KAJARI">KAJARI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($tk == '3'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
                    <option value="JA">JAKSA AGUNG</option>
                	<option value="JAMDATUN">JAMDATUN</option>
                	<option value="KAJATI">KAJATI</option>
                	<option value="KAJARI">KAJARI</option>
                	<option value="KACABJARI">KACABJARI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nama</label>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="hidden" id="nip_penerima" name="nip_penerima[]" value="<?php echo $q1; ?>" />
                	<input type="text" id="nama_penerima" name="nama_penerima[]" class="form-control" value="<?php echo $q2;?>" readonly />
                    <div class="input-group-btn"><button type="button" name="btn-cari" id="btn-cari-peg" class="btn btn-success btn-sm">...</button></div>
                </div>
				<div class="help-block with-errors" id="error_custom5B"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Jabatan</label>
            <div class="col-md-8">
                <input type="text" id="jabatan_penerima" name="jabatan_penerima[]" class="form-control" value="<?php echo ucwords(strtolower($q3));?>" />
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>        
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Alamat Instansi</label>
            <div class="col-md-8">
                <textarea id="alamat_penerima" name="alamat_penerima[]" class="form-control" style="height:150px;"><?php echo $q4;?></textarea>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2({placeholder: "Pilih salah satu", allowClear: true});
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
	});
</script>
