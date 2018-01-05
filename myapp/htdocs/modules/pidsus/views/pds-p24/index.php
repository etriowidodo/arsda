<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'P-24';
	$this->subtitle = 'Berita Acara Pendapat';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();

?>
<div class="role-index">
    <div class="pull-right">
    	<a class="btn btn-primary disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Pilih</a>
    </div>
    <br/>
    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_berkas']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor Berkas', 
					'value'=>function($data){
						return $data['no_berkas'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal Berkas', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_berkas']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:60%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tersangka', 
					'value'=>function($data){
						return $data['nama_tersangka'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_berkas']);
						return '<input type="radio" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    </div>

</div>

<div class="role-subindex form-surat-pengantar hide" style="margin-top:40px;">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-6"><h3 class="box-title">Surat Pengantar<p style="margin:0px;"></p></h3></div>	
                <div class="col-sm-6">
                	<div class="text-right">
                    	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="btn_ctkdraft">Cetak Draft P-24</a>
                    	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="btn_ctkp24">Cetak</a>
                        <a class="btn btn-pidsus btn-sm disabled" id="btn_isipendapat">Isi Pendapat</a>
					</div>
				</div>	
            </div>		
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="table_pengantar">
                    <thead>
                        <tr>
                            <th class="text-center" width="22%">No dan Tanggal Pengantar</th>
                            <th class="text-center" width="15%">Tanggal Diterima</th>
                            <th class="text-center" width="15%">Tanggal Selesai</th>
                            <th class="text-center" width="20%">Tersangka</th>
                            <th class="text-center" width="20%">Keterangan</th>
                            <th class="text-center" width="5%">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>			
</div>

<div class="modal-loading-new"></div>
<div class="hide" id="filter-link"></div>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($_SESSION["no_berkas"]){ ?>
		showPengantar(encodeURIComponent('<?php echo $_SESSION["no_berkas"];?>'));
		<?php } ?>
			
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
			var tm 	= id.toString().split("#");
			showPengantar(tm[0]);
		});
                
        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var tm 	= id.toString().split("#");
			showPengantar(tm[0]);
    	});
		function showPengantar(param){
			$("body").addClass("loading");
			$.post("/pidsus/pds-p24/getpengantar", {id1:param}, function(data){
				$(".form-surat-pengantar").find("h3.box-title > p").html('<small>No Berkas : '+decodeURIComponent(param)+'</small>');
				$(".form-surat-pengantar").removeClass("hide");
				$("#table_pengantar > tbody").html(data);
				$("section.content").animate({scrollTop: $(".form-surat-pengantar").offset().top + parseInt($(".form-surat-pengantar").height()) + "px"});
				$("body").removeClass("loading");
			});
		}

		$(".role-index").on("ifChecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			(n == 1)?$("#idUbah").removeClass("disabled"):$("#idUbah").addClass("disabled");
		});

		$(".form-surat-pengantar").on("ifChecked", ".pilihPengantar", function(){
			var n = $(".pilihPengantar:checked").length;
			(n == 1)?$("#btn_ctkp24, #btn_ctkdraft, #btn_isipendapat").removeClass("disabled"):$("#btn_ctkp24, #btn_ctkdraft, #btn_isipendapat").addClass("disabled");
		}).on("click", "#btn_isipendapat", function(){
			$("body").addClass("loading");
			var id 	= $(".pilihPengantar:checked").val();
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p24/create?id1="+tm[0]+"&id2="+tm[1];
			$(location).attr("href", url);
		}).on("dblclick", "td:not(.aksinya)", function(){
			$("body").addClass("loading");
			var id = $(this).closest("tr").data("id");
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p24/create?id1="+tm[0]+"&id2="+tm[1];
			$(location).attr("href", url);
		}).on("click", "#btn_ctkp24", function(){
			var id 	= $(".pilihPengantar:checked").val();
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p24/cetak?id1="+tm[0]+"&id2="+tm[1]+"&id3=0";
			$(location).attr("href", url);
		}).on("click", "#btn_ctkdraft", function(){
			var id 	= $(".pilihPengantar:checked").val();
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p24/cetak?id1="+tm[0]+"&id2="+tm[1]+"&id3=1";
			$(location).attr("href", url);
		});

	});
</script>