<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'Harian Sidang';
	$this->subtitle = '<span style="font-weight:400; font-size:13px;">No Register Perkara : '.$_SESSION['no_register_perkara'].' | No Permohonan : '.$_SESSION['no_surat'];
	$this->subtitle .= ($_SESSION['no_register_skk'])?' | No SKK : '.$_SESSION['no_register_skk'].'</span>':'</span>';

	
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
			
?>
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10">
                    <div class="input-group">
                    	<input type="text" name="q1" id="q1" class="form-control" />
                        <div class="input-group-btn">
                        	<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>     
    <?php ActiveForm::end(); ?>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/hariansidang/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
    <div class="pull-right">
    	<a class="btn btn-info disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p>&nbsp;</p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['no_register_perkara'].'#'.$data['no_register_skk'].'#'.$data['tanggal_skk'].'#'.$data['no_surat'].'#'.$data['no_sidang'].'#'.$data['tanggal_s11'].'#'.$data['no_register_skks'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor/ Tanggal SKK', 
					'value'=>function($data){
						return (!in_array($data['kode_jenis_instansi'],array("01"))?$data['no_register_skk'].'<br>':'').date("d-m-Y", strtotime($data['tanggal_skk']));
					}, 
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Waktu/Tempat', 
					'value'=>function($data){
						$waktu_tgl = ($data['tanggal_s11'])?date("d-m-Y", strtotime($data['tanggal_s11'])):"";
						$waktu_jam = ($data['waktu_sidang'] && $data['waktu_sidang'] != '00:00:00')?" Pukul ".substr($data['waktu_sidang'],0,-3):"";
						return $data['hari'].", ".tanggal_indonesia($waktu_tgl).$waktu_jam."<br>".Yii::$app->inspektur->getNamaSatker();
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Pengacara Negara', 
					'value'=>function($data){
						$tmp_jpn 	= explode("#", $data['jpnnya']);
						$jaksanya 	= "";
						if(count($tmp_jpn) > 1){
							foreach($tmp_jpn as $idx=>$val){
								$jaksanya .= ($idx+1).". ".$val."<br />";
							}
						} else{
							$jaksanya .= $tmp_jpn;
						}
						return $jaksanya;
						/*$result = "";	
						$q= Yii::$app->db->createCommand("select count(nama_pegawai) from 
						datun.skks_anak WHERE no_surat = '".$data['no_surat']."' and no_register_perkara = '".$data['no_register_perkara']."' and no_register_skk='".$data['no_register_skk']."' 
						and tanggal_skk='".$data['tanggal_skk']."'")->queryAll();
						
						if($q>0){
						$sql2 = "select * from datun.skk_anak 
								WHERE no_surat = '".$data['no_surat']."' and no_register_perkara = '".$data['no_register_perkara']."' and no_register_skk='".$data['no_register_skk']."' 
								and tanggal_skk='".$data['tanggal_skk']."'";
								$anak = Yii::$app->db->createCommand($sql2)->queryAll();
							
						}else{
						$sql = "select * from datun.skks_anak 
								WHERE no_surat = '".$data['no_surat']."' and no_register_perkara = '".$data['no_register_perkara']."' and no_register_skk='".$data['no_register_skk']."' 
								and tanggal_skk='".$data['tanggal_skk']."'";
								$anak = Yii::$app->db->createCommand($sql)->queryAll();
						}
						if(count($anak) > 1){
							$no = 1;
							foreach ($anak as $key => $value) {
									$result .= $no.". ".$value['nama_pegawai']."  <br>";
								$no++;
							}
							$result .= "<br>";
							return $result; 
						}else{
							foreach ($anak as $key => $value) {
									$result = $value['nama_pegawai'];
							}
							return $result; 
						}*/
					},					
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Agenda Sidang', 
					'value'=>function($data){
						return $data['agenda_sidang'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = $data['no_register_perkara'].'#'.$data['no_register_skk'].'#'.$data['tanggal_skk'].'#'.$data['no_surat'].'#'.$data['no_sidang'].'#'.$data['tanggal_s11'].'#'.$data['no_register_skks'];
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    </div>

</div>
<div class="modal-loading-new"></div>
<div class="hide" id="filter-link"></div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("body").addClass('fixed sidebar-collapse');
		$(".sidebar-toggle").click(function(){
			 $("html, body").animate({scrollTop: 0}, 500);
		});
		
		$('#myPjax').on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$("body").addClass("loading");
		}).on('pjax:complete', function(){
			$("body").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$(".selection_one").trigger("ifChecked");
		});
	
		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/datun/hariansidang/update?noperkara="+tm[0]+"&nosrt="+tm[3]+"&tgls11="+tm[5];
			$(location).attr("href", url);
		});

		$("#idHapus").on("click", function(){
			var id 	= [];
			var n 	= $(".selection_one:checked").length;
			for(var i = 0; i < n; i++){
				var test = $(".selection_one:checked").eq(i);
				id.push(test.val());
			}
			bootbox.confirm({
				message: "Apakah anda ingin menghapus data ini?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function (result) {
					if(result){ 	
						$("body").addClass("loading");
						$.ajax({
							type	: "POST",
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/hariansidang/hapusdata'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false})
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data berhasil dihapus"}, {type:"success"});
								} else{
									$("body").removeClass("loading");
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data gagal dihapus"}, {type:"danger"});
								}
							}
						});
					}
				}
			});
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/datun/hariansidang/update?noperkara="+tm[0]+"&nosrt="+tm[3]+"&tgls11="+tm[5];
			$(location).attr("href", url);
    	});
		$(".role-index").on("ifChecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("uncheck");
		});
		$(".role-index").on("ifChecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		});
		function endisButton(n){
			if(n == 1){
				$("#idUbah").removeClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah").addClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else{
				$("#idUbah").addClass("disabled");
				$("#idHapus").addClass("disabled");
			}
		}

	});
</script>