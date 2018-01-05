<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\helpers\Url;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	$this->title 	= 'Disposisi Pimpinan';
	$isNewRecord 	= ($seq['no_surat_parm'] == ''?1:0);
	$linkBatal		= '/datun/permohonan/update?id='.rawurlencode($_SESSION['no_register_perkara']).'&ns='.rawurlencode($_SESSION['no_surat']);
	$linkCetak		= '/datun/hasiltelaah/cetak';
	$tgl_pengadilan = ($seq['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($seq['tanggal_panggilan_pengadilan'])):"";
	$tgl_permohonan = ($seq['tanggal_permohonan'])?date("d-m-Y", strtotime($seq['tanggal_permohonan'])):"";
	$tgl_diterima 	= ($seq['tanggal_diterima'])?date("d-m-Y", strtotime($seq['tanggal_diterima'])):"";
	$tgl_sp1 		= ($seq['tanggal_sp1'])?date("d-m-Y", strtotime($seq['tanggal_sp1'])):"";
	$tgl_s5 		= ($seq['tanggal_s5'])?date("d-m-Y", strtotime($seq['tanggal_s5'])):"";
	$tgl_telaah 	= ($seq['tanggal_telaah'])?date("d-m-Y", strtotime($seq['tanggal_telaah'])):"";
	$petunjuk 		= ($seq['petunjuk'])?'Dapat diterbitkan SKK':'Permohonan tidak dapat ditindaklanjuti';
	$kepadaYth 		= ($isNewRecord)?$seq['wil_instansi'].PHP_EOL.$seq['alamat_ins']:$seq['untuk'];
	$tempat 		= ($isNewRecord)?$seq['nm_propinsi']:$seq['tempat'];
	$ttdJabatan 	= $seq['penandatangan_status']." ".$seq['penandatangan_ttdjabat'];
	$classHide		= "hide";
	if ($seq['is_approved']==0){
		$classHide	= "";
	} else if ($seq['is_approved']==1){
		$classHide	= "hide";
	}
?>

<?php 
// if($seq['no_sp1'] && $seq['no_register_perkara'] && $seq['no_surat']){	 ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/hasiltelaah/simpanhasiltelaah" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Dasar</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jenis Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="jenis_ins" name="jenis_ins" class="form-control" value="<?php echo $seq['jenis_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="nama_ins" name="nama_ins" class="form-control" value="<?php echo $seq['nama_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Register</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $seq['no_register_perkara']; ?>" id="no_reg_perkara" name="no_reg_perkara" readonly />
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Wilayah</label>        
        			<div class="col-md-8">
                        <input type="text" id="wil_ins" name="wil_ins" class="form-control" value="<?php echo $seq['wil_instansi'];?>" readonly />
                    </div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Surat Permohonan</label>        
        			<div class="col-md-8">
                        <?php if($seq['kode_jenis_instansi'] == '01' || $seq['kode_jenis_instansi'] == '06'){ ?>
                        <input type="hidden" id="no_permohonan" name="no_permohonan" value="<?php echo $seq['no_surat']; ?>" />
                        <input type="text" id="npemohonTxt" name="npemohonTxt" class="form-control" value="" readonly />
                        <?php } else{ ?>
                        <input type="hidden" id="no_permohonan" name="no_permohonan" value="<?php echo $seq['no_surat']; ?>" />
                        <input type="text" id="npemohonTxt" name="npemohonTxt" class="form-control" value="<?php echo $seq['no_surat']; ?>" readonly />
                        <?php } ?>
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Permohonan</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?php echo $tgl_permohonan; ?>" readonly />
						</div>						
					</div>
        		</div>
        	</div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Diterima Wilayah Kerja</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
            		</div>
            	</div>
            </div>
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Diterima</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control" id="tgl_diterima" name="tgl_diterima" value="<?php echo $tgl_diterima;?>" readonly />
                        </div>						
                    </div>
        		</div>
        	</div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Surat Perintah(SP-1)</label>
        			<div class="col-md-8">
            			<input type="text" id="no_sp1" name="no_sp1" class="form-control" value="<?php echo $seq['no_sp1'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal (SP-1)</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control" id="tgl_sp1" name="tgl_sp1" value="<?php echo $tgl_sp1;?>" readonly />
                        </div>						
                    </div>
            	</div>
            </div>
        </div>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Hasil Telaah</label>
            <div class="col-md-8">
                <input type="hidden" name="petunjuk" id="petunjuk" value="<?php echo ($seq['petunjuk'])?1:0;?>" />
                <input type="text" name="hasils5" id="hasils5" class="form-control" value="<?php echo $petunjuk;?>" readonly />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Keputusan</label>
            <div class="col-md-8">
            	<a class="hide" id="keputusannya"></a>
                <select name="cb_keputusan" id="cb_keputusan" class="select2 ambil-keputusan" style="width:100%" required data-error="Keputusan belum dipilih">
					<option></option>
                    <option value="1" <?php echo ($seq['keputusan'] === true)?'selected':'';?>>Setuju Saran JPN</option>
                    <option value="0" <?php echo ($seq['keputusan'] === false)?'selected':'';?>>Tidak Setuju Saran JPN</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div id="box-tolak" class="box box-primary <?php echo $classHide; ?>" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Tolak Surat Permohonan</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nomor</label>
        			<div class="col-md-8">
            			<input type="text" name="no_surat_telaah" id="no_surat_telaah" value="<?php echo $seq['no_surat_telaah']; ?>" class="form-control" maxlength="40" />
                        <div class="help-block with-errors" id="error_custom1"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Dikeluarkan</label>
        			<div class="col-md-8">
            			<input type="text" id="lok_keluar" name="lok_keluar" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />
            		</div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Sifat</label>
        			<div class="col-md-8">
						<select name="cb_sifat" id="cb_sifat" class="select2" style="width:100%" >
							<option></option>
							<?php 
                                $resOpt = MenuSearch::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
                                foreach($resOpt as $dOpt){
									$selected = ($seq['sifat'] == $dOpt['id'])?'selected':'';
                                    echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                }
                            ?>
						</select>
						<div class="help-block with-errors"></div>
                    </div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control datepicker" id="tanggal_telaah" name="tanggal_telaah" value="<?php echo $tgl_telaah;?>" placeholder="DD-MM-YYYY" >
                        </div>						
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom2"></div></div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Lampiran</label>
        			<div class="col-md-2">
            			<input type="text" name="lampiran_keputusan" id="lampiran_keputusan" class="form-control number-only-strip" maxlength="2" value="<?php echo $seq['lampiran_keputusan']; ?>" />
            		</div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>        
                            <div class="col-md-8">
                                <input type="text" name="perihal" id="perihal" value="<?php echo $seq['perihal']; ?>" class="form-control" />
                            	<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Kepada Yth.</label>
                    <div class="col-md-8">
                        <textarea style="height:90px;" name="untuk" id="untuk" class="form-control" ><?php echo $kepadaYth; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="tempat" id="tempat" value="<?php echo $tempat;?>" class="form-control" />
                            	<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-alasan1" data-toggle="tab">Alasan 1</a></li>
                            <li><a href="#tab-alasan2" data-toggle="tab">Alasan 2</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-alasan1">
								<textarea id="alasan1" name="alasan1" class="ckeditor"><?php echo $seq['alasan1']; ?></textarea>
                            </div>
                            <div class="tab-pane fade" id="tab-alasan2">
								<textarea id="alasan2" name="alasan2" class="ckeditor"><?php echo $seq['alasan2']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
	</div>
</div>

<div class="row">
	<div id="box-tolak-temb" class="col-md-6 <?php echo $classHide; ?>">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm delTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm addTembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body" style="padding:15px;">
			<?php
                echo GridView::widget([
					'options' => ['class'=>'table-responsive grid-view'],
                    'summary' => '',
                    'tableOptions' => ['id' => 'table_tembusan', 'class' => 'table table-bordered table-hover'],
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function($data, $index){
                        return ['data-id' => ($index+1)];
                    },
                    'columns' => [
                        'Aksi'=>[
                            'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
                            'format'=>'raw',
                            'header'=>'&nbsp;',
                            'contentOptions'=>['class'=>'text-center'],
                            'value'=>function($data, $index){
                                $idnya = $data['kode_template_surat'].'#'.$data['no_urut'];
                                return '<input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'.($index+1).'" value="'.($index+1).'">';
                            },
                        ],
                        '0'=>[
                            'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
                            'format'=>'raw',
                            'header'=>'No',
                            'value'=>function($data, $index){
                                return '<input type="text" name="no_urut[]" class="form-control input-sm" value="'.($index+1).'" />';
                            }, 
                        ],
                        '1'=>[
                            'headerOptions'=>['style'=>'width:80%', 'class'=>'text-center'],
                            'format'=>'raw',
                            'header'=>'Tembusan',
                            'value'=>function($data, $index){
                                return '<input type="text" name="tembusan[]" class="form-control input-sm" value="'.$data['tembusan'].'" />';
                            }, 
                        ],

                    ],
                ]);
			?>
			</div>
		</div>
	</div>
    <div class="col-md-6">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Penandatangan :</legend>
            <div class="row">        
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $seq['penandatangan_nip']; ?>" />
                            <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $seq['penandatangan_status']; ?>" />
                            <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $seq['penandatangan_jabatan'];?>" />														
                            <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $seq['penandatangan_gol'];?>" />														
                            <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $seq['penandatangan_pangkat'];?>" />														
                            <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $seq['penandatangan_ttdjabat'];?>" />														
                            <div class="input-group">
                                <input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $seq['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
                                <div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                            </div>
                            <div class="help-block with-errors" id="error_custom3"></div>
                        </div>				
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
                        </div>				
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div id="box-tolak-file" class="row <?php echo $classHide; ?>">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_terimatolak" id="file_terimatolak" class="form-inputfile" />                    
                <label for="file_terimatolak" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['hasiltelaah'].$seq['file_terimatolak'];
                        $labelFile 	= 'File Tolak';
                        if($seq['file_terimatolak'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Tolak';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($seq['file_terimatolak']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($seq['file_terimatolak'], strrpos($seq['file_terimatolak'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$seq['file_terimatolak'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom4"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_telaah" id="file_telaah" class="form-inputfile" />                    
                <label for="file_telaah" class="label-inputfile">
					<?php 
                        $pathFile 	= Yii::$app->params['hasiltelaah'].$seq['file_telaah'];
                        $labelFile 	= 'File Telaahan (S5)';
                        if($seq['file_telaah'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Telaahan (S5)';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($seq['file_telaah']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($seq['file_telaah'], strrpos($seq['file_telaah'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$seq['file_telaah'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom5"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_disposisi" id="file_disposisi" class="form-inputfile" />                    
                <label for="file_disposisi" class="label-inputfile">
					<?php 
                        $pathFile 	= Yii::$app->params['hasiltelaah'].$seq['file_disposisi'];
                        $labelFile 	= 'Upload File Disposisi';
                        if($seq['file_disposisi'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Disposisi';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($seq['file_disposisi']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($seq['file_disposisi'], strrpos($seq['file_disposisi'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$seq['file_disposisi'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>                    
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom6"></div>
                </label>
            </div>
        </div>
    </div>
</div>


<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="tgl_s5" id="tgl_s5" value="<?php echo $tgl_s5;?>" />
    <input type="hidden" name="tgl_pengadilan" id="tgl_pengadilan" value="<?php echo $tgl_pengadilan;?>" />
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
	<input type="hidden" name="is_approved" id="is_approved" value="<?php echo $seq['is_approved']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php if(!$isNewRecord && $seq['is_approved']==0){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>

<div class="modal fade" id="penandatangan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">PENANDATANGAN</h4>
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
	var hashUrl = window.location.hash.substr(1);
	if(hashUrl){
		$("select#"+hashUrl).val("").trigger('change');
		setErrorFocus($("select#"+hashUrl), $("#role-form"), false);
	}

	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			var alasan1 = $('#alasan1').val(), alasan2 = $('#alasan2').val(), terima=$("#is_approved").val();
			if( (alasan1 == '' || alasan2 == '') && (terima==0) ){
				bootbox.confirm({ 
					message: "Text editor masih ada yang kosong. Apakah anda tetap ingin menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							bootbox.hideAll();
							validasi_upload();
							return false;
						}
					}
				});	
			} else{
				validasi_upload();
				return false;
			}
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var fileke1 = $("#file_terimatolak")[0].files[0], fname1 = '', fsize1 = 0, extnya1 = '';
		var fileke2 = $("#file_telaah")[0].files[0], fname2 = '', fsize2 = 0, extnya2 = '';
		var fileke3 = $("#file_disposisi")[0].files[0], fname3 = '', fsize3 = 0, extnya3 = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tglTtd 	= new Date(tgl_auto($("#tanggal_telaah").val()));
		var tglS5 	= new Date(tgl_auto($("#tgl_s5").val()));
		var tglPn 	= new Date(tgl_auto($("#tgl_pengadilan").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5, #error_custom6").html('');
		if(typeof(fileke1) != 'undefined'){
			fsize1 	= fileke1.size, 
			fname1 	= fileke1.name, 
			extnya1	= fname1.substr(fname1.lastIndexOf(".")).toLowerCase();
		}
		if(typeof(fileke2) != 'undefined'){
			fsize2 	= fileke2.size, 
			fname2 	= fileke2.name, 
			extnya2	= fname2.substr(fname2.lastIndexOf(".")).toLowerCase();
		}
		if(typeof(fileke3) != 'undefined'){
			fsize3 	= fileke3.size, 
			fname3 	= fileke3.name, 
			extnya3	= fname3.substr(fname3.lastIndexOf(".")).toLowerCase();
		}

		if(tglTtd < tglS5){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan harus lebih besar atau sama dengan tanggal S-5</i>');
			setErrorFocus($("#tanggal_telaah"), $("#role-form"), false);
			return false;
		} else if(tglTtd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda tangan adalah hari ini</i>');
			setErrorFocus($("#tanggal_telaah"), $("#role-form"), false);
			return false;
		} else if($("#penandatangan_nip").val() == "" || $("#penandatangan_nama").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">Nama pejabat penandatangan beum dipilih</i>');
			setErrorFocus($("#penandatangan_nama"), $("#role-form"), false);
			return false;
		} else if(fname1 && $.inArray(extnya1, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt, .doc, .docx, .pdf</i>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if(fname1 && fsize1 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if(fname2 && $.inArray(extnya2, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt, .doc, .docx, .pdf</i>');
			setErrorFocus($("#error_custom5"), $("#role-form"), false);
			return false;
		} else if(fname2 && fsize2 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom5"), $("#role-form"), false);
			return false;
		} else if(fname3 && $.inArray(extnya3, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt, .doc, .docx, .pdf</i>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if(fname3 && fsize3 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '/datun/hasiltelaah/cektelaah',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						$("#"+data.element).html(data.error);
						setErrorFocus($("#"+data.element), $("#role-form"), false);
					} else{
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			});
			return false;
		}
	}
	
	$(".ambil-keputusan").on("change", function(){
		//alert('aaa')
		var petunjuk 	= $("#petunjuk").val() ;
		var keputusan	= $("#cb_keputusan").val();
		//alert(petunjuk +'-'+keputusan)
		if( petunjuk =='1' && keputusan=="0" )  { //tolak
			$("#box-tolak").removeClass("hide");
			$("#box-tolak-temb").removeClass("hide");
			$("#box-tolak-file").removeClass("hide");
			//terima	= 0;
			$("#is_approved").val('0');
			$("#tanggal_telaah").val('');
		}
		if( petunjuk =='1' && keputusan=="1" )  {
			$("#box-tolak").addClass("hide");
			$("#box-tolak-temb").addClass("hide");
			$("#box-tolak-file").addClass("hide");
			//terima	= 1;
			$("#is_approved").val('1');
		}
		if( petunjuk =='0' && keputusan=="1" )  { //tolak
			$("#box-tolak").removeClass("hide");
			$("#box-tolak-temb").removeClass("hide");
			$("#box-tolak-file").removeClass("hide");
			//terima	= 0;
			$("#is_approved").val('0');
			$("#tanggal_telaah").val('');
		}
		if( petunjuk =='0' && keputusan=="0" )  {
			$("#box-tolak").addClass("hide");
			$("#box-tolak-temb").addClass("hide");
			$("#box-tolak-file").addClass("hide");
			//terima	= 1;
			$("#is_approved").val('1');
		}
	})
	
	/* START TEMBUSAN */
	$(".addTembusan").on("click", function(){
		var rwTbl	=  $('#table_tembusan > tbody').find('tr:last');
		var rwNom	= parseInt(rwTbl.data('id'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = $('#table_tembusan').find('tbody');
			rwTbl.append('<tr data-id="'+newId+'">'+
				'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
				'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>'+
				'<td><input type="text" name="tembusan[]" class="form-control input-sm" /></td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+newId+'">'+
				'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
				'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>'+
				'<td><input type="text" name="tembusan[]" class="form-control input-sm" /></td>'+
			'</tr>');
		}
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
		$('#table_tembusan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});
	});
								
	$(".delTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END TEMBUSAN */

	/* START AMBIL TTD */
	$("#btn_tambahttd, #penandatangan_nama").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/datun/get-ttd/index");
		$("#penandatangan_modal").modal({backdrop:"static"});
	});
	
	$("#penandatangan_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-ttd-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	}).on('click', "#idPilihTtdModal", function(){
		var modal = $("#penandatangan_modal").find("#table-ttd-modal");
		var index = modal.find(".pilih-ttd-modal:checked").val();
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	});
	function insertToTtd(param){
		$("#penandatangan_status").val(param[0]);
		$("#penandatangan_nip").val(param[1]);
		$("#penandatangan_nama").val(param[2]);
		$("#penandatangan_jabatan").val(param[3]);
		$("#penandatangan_gol").val(param[4]);
		$("#penandatangan_pangkat").val(param[5]);
		$("#penandatangan_ttdjabat").val(param[6]);
		$("#ttdJabatan").val(param[0]+' '+param[6]);
	}
	/* END AMBIL TTD */
});
</script>
<?php /* } else {
echo "Belum dibuat S5";

} */?>
