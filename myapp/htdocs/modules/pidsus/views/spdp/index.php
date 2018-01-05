<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'RP-6';
	$this->subtitle = 'Register Pemberitahuan Dimulainya Penyidikan';
?>
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
						<button type="submit" class="btn" name="btnSearch" id="btnSearch"><i class="fa fa-search jarak-kanan"></i>Cari</button>
                        <a href="/pidsus/spdp/index" class="btn btn-info btn-flat reset-cari" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-1"></div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-pidsus" href="/pidsus/spdp/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
    <div class="pull-right">
    	<a class="btn btn-primary disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>

    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_spdp'])."|#|".rawurlencode($data['tgl_spdp']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Asal SPDP<br />Nomor dan Tanggal', 
					'value'=>function($data){
						return '<p style="margin-bottom:5px;">'.$data['inst_pelak_penyidikan'].'<br/>'.$data['no_spdp'].' '.date("d-m-Y", strtotime($data['tgl_spdp'])).'<br/>'.' Diterima SPDP'.' '.date("d-m-Y", strtotime($data['tgl_terima'])).'</p>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Melanggar UU dan Pasal', 
					'value'=>function($data){
						return $data['undang_pasal'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:12%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tempat dan Tanggal Kejadian',
					'value'=>function($data){
						$arrBln = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
						$tempat = ($data['tempat_kejadian'])?$data['tempat_kejadian'].'<br />':'';
						$arrTmp = explode("-", $data['tgl_kejadian_perkara']);
						if($arrTmp[4]) $tanggal = 'Tahun '.$arrTmp[4].'<br />';
						if($arrTmp[4] && $arrTmp[3]) $tanggal = 'Bulan '.$arrBln[intval($arrTmp[3])].' Tahun '.$arrTmp[4].'<br />';
						if($arrTmp[4] && $arrTmp[3] && $arrTmp[2]) $tanggal = 'Tanggal '.$arrTmp[2].' '.$arrBln[intval($arrTmp[3])].' '.$arrTmp[4].'<br />';
						if($arrTmp[0] && $arrTmp[1]) $waktu = 'Jam '.$arrTmp[0].':'.$arrTmp[1].' '.$arrTmp[5];
						return $tempat.$tanggal.$waktu;
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tersangka', 
					'value'=>function($data){
						$temp = explode('#', $data['tersangka']);
						$text = '';
						if(count($temp) > 0){
							foreach($temp as $idx=>$res){
								$isi = explode('|', $res);
								if($isi[0] && $isi[1]){
									$text .= '<div style="margin-bottom: 3px; width: 100%; display: table;">';
									$text .= '<div style="display: table-cell; width: 20px;">'.$isi[0].'.</div><div style="display: table-cell;">'.$isi[1].'</div>';
									$text .= '</div>';
								}
							}
						}
						return $text;
					}, 
				],
				'5'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'value'=>function($data){
						return $data['statusnya'];
					}, 
				],                
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_spdp'])."|#|".rawurlencode($data['tgl_spdp']);
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
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
			$("#idUbah, #idHapus").addClass("disabled");
		});
	
		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var tm 	= id.toString().split("|#|");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/spdp/update?no_spdp="+tm[0]+"&tgl_spdp="+tm[1];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/spdp/hapusdata'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false})
									notify_hapus("success", "Data berhasil dihapus");
								} else{
									$("body").removeClass("loading");
									notify_hapus("danger", "Data gagal dihapus");
								}
							}
						});
					}
				}
			});
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var tm 	= id.toString().split("|#|");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/spdp/update?no_spdp="+tm[0]+"&tgl_spdp="+tm[1];
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

		$(".reset-cari").on("click", function(){
			$("body").addClass("loading");
		});

	});
</script>