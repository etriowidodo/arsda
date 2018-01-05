<style>
#m_update_wawancara 
{
    margin-top: 70px !important;
} 

#m_wawancara 
{
    margin-top: 70px !important;
}
</style>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'BA-WAS 3';
$this->subtitle = 'BERITA ACARA PERMINTAAN KETERANGAN (TERLAPOR-SAKSI)';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
//$this->params['ringkasan_perkara'] = $session->get('was_register');
//$this->params['breadcrumbs'][] = ['label' => 'Was-10', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>




<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">
<div class="box box-primary" style="padding:10px;">
<div class="pidum-pdm-spdp-index">
	
	<!------------- Hidden Field -------------------->
	<input id="id_register" value="<?php echo $id_register; ?>" type="hidden" name="BaWas3[id_register]">
	<!------------- Hidden Field -------------------->
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
	<strong><h3>IDENTITAS PEMERIKSA</h3></strong>
	<hr style="border-color: #c7c7c7;margin: 10px 0;">

	<br />
	
	<?= GridView::widget([
            'id' => 'ba_was3_pemeriksa',
            'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['peg_nip_baru']];
            },
            'dataProvider' => $dataPemeriksa,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
			
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Nama',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['peg_nama'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'NIP',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['peg_nip_baru'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Jabatan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['jabatan'];
					},
                ],
				
				
				/*
				[
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_was_10'], 'class' => 'checkWas10'];
                    }
                ],
				*/
				
            ],
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
        ]); ?>
		
		
		

</div>
</div>



<br />
<!---------------------- WAWANCARA TERLAPOR -------------------------------->
<div class="box box-primary" style="padding:10px;">
<div class="pidum-pdm-spdp-index">

   
    
	<strong><h3>KETERANGAN TERLAPOR</h3></strong>
	<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div id="divHapus">
		<div class="pull-left"><button type="button" id="btn-tambah-terlapor" class="btn btn-primary" data-toggle="modal" data-sebagai="3" data-target="#m_wawancara" style="border:none;"><i class="fa fa-plus"></i> Tambah</button></div>
		<div class="pull-right">
		<button id="btnCetakTerlapor" data-sebagai="3" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>&nbsp;
		<button id="btnHapusTerlapor" data-sebagai="3" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button>
		</div>
    </div>
	
	<br /><br />
	
	<?= GridView::widget([
            'id' => 'ba_was_3_terlapor',
            'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_ba_was_3'], 'data-sebagai' => 3];
            },
            'dataProvider' => $dataTerlapor,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Nama',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['peg_nama'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'NIP',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['peg_nip'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Gol/Pangkat',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['golpangkat'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Jabatan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['jabatan'];
					},
                ],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Jml Pertanyaan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['jml_tanya'];
					},
                ],
				
				
				
				[
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_ba_was_3'], 'class' => 'checkWas10', 'id'=>'checkboxTerlapor'];
                    }
                ],
				
				
            ],
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
        ]); ?>
		
		
		

</div>
</div>

<!---------------------- WAWANCARA TERLAPOR -------------------------------->




<?php
Modal::begin([
    'id' => 'm_wawancara',
    'header' => 'Form Tanya Jawab',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?php echo $this->render('@app/modules/pengawasan/views/ba-was3/_m_wawancara', ['model' => $model, 'searchSatker' => $searchSatker, 'dataProviderSatker' => $dataProviderSatker, 'id_register' => $id_register]); ?>


<?php
Modal::end();
?>


<?php
Modal::begin([
    'id' => 'm_update_wawancara',
    'header' => 'Form Tanya Jawab',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?php echo $this->render('@app/modules/pengawasan/views/ba-was3/_m_update_wawancara', ['model' => $model, 'searchSatker' => $searchSatker, 'dataProviderSatker' => $dataProviderSatker, 'id_register' => $id_register]); ?>

<?php
Modal::end();
?>





<?php
Modal::begin([
    'id' => 'm_kejaksaan_ba-was3',
    'header' => 'Data Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);

echo $this->render('@app/modules/pengawasan/views/ba-was2/_modalKejaksaan', [
	'param'=> 'ba-was3',
    'model' => $model,
    'searchSatker' => $searchSatker,
    'dataProviderSatker' => $dataProviderSatker,
]);
Modal::end();
?>



<?php
Modal::begin([
    'id' => 'm_kejaksaan_updateba-was3',
    'header' => 'Data Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);

echo $this->render('@app/modules/pengawasan/views/ba-was2/_modalKejaksaan', [
	'param'=> 'updateba-was3',
    'model' => $model,
    'searchSatker' => $searchSatker,
    'dataProviderSatker' => $dataProviderSatker,
]);
Modal::end();
?>


<script type="text/javascript">
	$(function() {
		$.fn.modal.Constructor.DEFAULTS.backdrop = 'static';
		});
		
    window.onload = function () {
	
		/*
		$(document).on('hidden.bs.modal', function () {
		$('body').addClass('modal-open');
		});
		*/
		
		$(document).on('hidden.bs.modal', '.modal', function () {
		$('.modal:visible').length && $(document.body).addClass('modal-open');
		});
		
		
		var url1='<?php echo  Url::toRoute('ba-was3/getdata'); ?>';
		var url2='<?php echo  Url::toRoute('ba-was3/getdatadetail'); ?>';
		var url3='<?php echo  Url::toRoute('ba-was3/getidperan'); ?>';

		$('td').css('cursor', 'pointer');
		
		
		//-------------------Function Change Tanggal-------------------//
		$(document).on('change', 'input#tgl_tambah_wawancara', function () {
		   var d = new Date($('#tgl_tambah_wawancara').val());
  			var weekday = new Array(7);
			weekday[0]=  "Minggu";
			weekday[1] = "Senin";
			weekday[2] = "Selasa";
			weekday[3] = "Rabu";
			weekday[4] = "Kamis";
			weekday[5] = "Jumat";
			weekday[6] = "Sabtu";
			
			var n = weekday[d.getDay()];  
				$('#hari_tambah').val(n);
		});
		
		$(document).on('change', 'input#tgl_update_wawancara', function () {
		   var d = new Date($('#tgl_update_wawancara').val());
  			var weekday = new Array(7);
			weekday[0]=  "Minggu";
			weekday[1] = "Senin";
			weekday[2] = "Selasa";
			weekday[3] = "Rabu";
			weekday[4] = "Kamis";
			weekday[5] = "Jumat";
			weekday[6] = "Sabtu";
			
			var n = weekday[d.getDay()];  
				$('#hari_update').val(n);
		});
		//-------------------Function Change Tanggal-------------------//
		
		
		//-------------------Clear table body on Button Tambah-------------------//
		$('#btn-tambah-terlapor, #btn-tambah-saksiinternal, #btn-tambah-saksieksternal').click(function(){
		$('#tbody-wawancaraTerlapor').empty();
		$('#tgl_tambah_wawancara').val('');
		$('#tgl_tambah_wawancara-disp').val('');
		$('#hari_tambah').val('');
		});
		//-------------------Clear table body on Button Tambah-------------------//
		
		
		
		//----------------------- Tombol Batal, Hapus ------------------------//	
		$('#btn_batal_wawancara').click(function(){
		$("#m_wawancara").modal('hide');
		});
		
		
		$('#btn_update_batal_wawancara').click(function(){
		$("#m_update_wawancara").modal('hide');
		});
		
		
		//----------------------Hapus---------------------//
		$('#btn_hapus_wawancara').click(function(){
		var sebagai = $("#update_sebagai").val();
		var id_ba_was3 = $("#update_id_ba_was_3").val();
		
		bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
										
										$.ajax({
										type:'POST',
										url:'/pengawasan/ba-was3/delete',
										data:'data='+id_ba_was3,
										success:function(data){
										}
										});
										
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
					
		
		});
		//----------------------- Tombol Batal, Hapus ------------------------//
		
		
		
		
		
		//----------------------- Modal Tambah ------------------------//	
		$(document).on('click', 'a#btn_delete_wawancara_terlapor', function () {
            var counter_terlapor = parseInt($("#counter-terlapor").val()) - 1;
            $("#counter-terlapor").val(counter_terlapor);
			/*
            $(this).parent().parent().remove();
            return false;
			*/
			var counterDelete = $(this).attr('counter');
			bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){	
								$("#trtambahpertanyaan"+counterDelete).remove();								
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
					
        });

			
        $(document).on('click', 'a#btn_tambah_terlapor', function () {
            var counter_terlapor = parseInt($("#counter-terlapor").val()) + 1;
            $("#counter-terlapor").val(counter_terlapor);
            $("#tbody-wawancaraTerlapor").append(
                    '<tr id="trtambahpertanyaan'+counter_terlapor+'">' +
                    '<td>' + counter_terlapor + '</td>' +
                    '<td><textarea name="pertanyaan[]" rows="1" cols="40"></textarea></td>' +
					'<td><textarea name="jawaban[]" rows="1" cols="40"></textarea></td>' +
                    '<td><a class="btn btn-primary" id="btn_delete_wawancara_terlapor" counter="'+counter_terlapor+'">Hapus</a></td>' +
                    '</tr>'
                    );

        });
		//----------------------- Modal Tambah ------------------------//	
		
		
		
		
		//----------------------- Modal Update ------------------------//
		$(document).on('click', 'a#btn_delete_updatewawancara_terlapor', function () {
            var counter_terlapor = parseInt($("#counter-updateterlapor").val()) - 1;
            $("#counter-updateterlapor").val(counter_terlapor);
			/*
            $(this).parent().parent().remove();
            return false;
			*/
			var counterDelete = $(this).attr('counter');
			bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){	
								$("#trupdatepertanyaan"+counterDelete).remove();								
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        });

        $(document).on('click', 'a#btn_tambah_updateterlapor', function () {
            var counter_terlapor = parseInt($("#counter-updateterlapor").val()) + 1;
            $("#counter-updateterlapor").val(counter_terlapor);
            $("#tbody-updatewawancaraTerlapor").append(
                    '<tr id="trupdatepertanyaan'+counter_terlapor+'">' +
                    '<td>' + counter_terlapor + '</td>' +
                    '<td><textarea name="update_pertanyaan[]" rows="1" cols="40"></textarea></td>' +
					'<td><textarea name="update_jawaban[]" rows="1" cols="40"></textarea></td>' +
                    '<td><a class="btn btn-primary" id="btn_delete_updatewawancara_terlapor" counter="'+counter_terlapor+'">Hapus</a></td>' +
                    '</tr>'
                    );

        });
		//----------------------- Modal Update ------------------------//
		
		
		
		
		
		//----------------------- Hapus ------------------------//
		$('#btnHapusTerlapor, #btnHapusInternal, #btnHapusEksternal').click(function(){
		var sebagai = $(this).data('sebagai');
		if(sebagai==1){
		var count = $('input[id="checkboxSaksiInternal"]:checked').length
		}else
		if(sebagai==2){
		var count = $('input[id="checkboxSaksiEksternal"]:checked').length
		}else{
		var count = $('input[id="checkboxTerlapor"]:checked').length
		}
		if(count==0){
		bootbox.dialog({
                            message: "Pilih Data Yang Akan Dihapus",
                            title: "Peringatan",
                            buttons: {
                                success: {
                                    label: "Tutup",
                                    className: "btn-warning",
                                    callback: function () {
                                    }
                                }
                            }
                        });
		}
		else{
		
		 bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
										var value = [];
										if(sebagai==1){
										
										$('input[id="checkboxSaksiInternal"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}else
										if(sebagai==2){
										
										$('input[id="checkboxSaksiEksternal"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}else{
										
										$('input[id="checkboxTerlapor"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}
										
										
										
										$.ajax({
										type:'POST',
										url:'/pengawasan/ba-was3/delete',
										data:'data='+value,
										success:function(data){
										}
										});
										
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
		
		}
		});
		//----------------------- Hapus ------------------------//
		
		
		
		
		
		
		
		//----------------------- Cetak ------------------------//
		$('#btnCetakTerlapor, #btnCetakInternal, #btnCetakEksternal').click(function(){
		var sebagai = $(this).data('sebagai');
		if(sebagai==1){
		var count = $('input[id="checkboxSaksiInternal"]:checked').length
		}else
		if(sebagai==2){
		var count = $('input[id="checkboxSaksiEksternal"]:checked').length
		}else{
		var count = $('input[id="checkboxTerlapor"]:checked').length
		}
		
		var value = [];
										if(sebagai==1){
										
										$('input[id="checkboxSaksiInternal"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}else
										if(sebagai==2){
										
										$('input[id="checkboxSaksiEksternal"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}else{
										
										$('input[id="checkboxTerlapor"]:checked').each(function(i,e) {
											value.push(e.value);
										});
										
										}
										

		if(count==0){
		bootbox.dialog({
                            message: "Pilih data yang akan dicetak",
                            title: "Peringatan",
                            buttons: {
                                success: {
                                    label: "Tutup",
                                    className: "btn-warning",
                                    callback: function () {
                                    }
                                }
                            }
                        });
		}
		
		else if(count==1){
		var url = window.location.protocol + "//" + window.location.host + "/pengawasan/ba-was3/cetak?id="+value+"&sebagai="+sebagai;
        $(location).attr('href',url);
		}
		
		else{
		bootbox.dialog({
                            message: "Hanya boleh mencetak satu data",
                            title: "Peringatan",
                            buttons: {
                                success: {
                                    label: "Tutup",
                                    className: "btn-warning",
                                    callback: function () {
                                    }
                                }
                            }
                        });
		}
		});
		//----------------------- Cetak ------------------------//
		
		
		
		
		
		
		
		//----------------------- Populate Combobox id_peran ------------------------//
		$("#btn-tambah-terlapor, #btn-tambah-saksiinternal, #btn-tambah-saksieksternal").click(function(){
		var sebagai = $(this).data('sebagai');
		var id_register = $("#id_register").val();
		$("#id_peran").empty();
		if(sebagai==1){
		$("#id_peran_title").text('Saksi Internal');
		$("#sebagai").val(1);
		}
		else if(sebagai==2){
		$("#id_peran_title").text('Saksi External');
		$("#sebagai").val(2);
		}else{
		$("#id_peran_title").text('Terlapor');
		$("#sebagai").val(3);
		}
		
		$.ajax({
		type:"POST",
		url: url3,
		data: "sebagai="+sebagai+'&id_register='+id_register,
		//dataType: "json",
		success: function(data){
		$("#id_peran").append(data);
		}
		});
		
		});
				
		//----------------------- Populate Combobox id_peran ------------------------//
		
		
		
		
		
		//----------------------- Proses Update Terlapor ------------------------//
		$('#ba_was_3_terlapor td, #ba_was_3_internal td, #ba_was_3_eksternal td').dblclick(function(){
		//$(document).on('dblclick', 'div#ba_was_2_terlapor td', function () {	
         var id = $(this).closest('tr').data('id');
		 var sebagai = $(this).closest('tr').data('sebagai');
		 var id_register = $("#id_register").val();
		 $("#tbody-updatewawancaraTerlapor").empty();
		 $("#update_id_peran").empty();
		
			if(sebagai==1){
			$("#update_id_peran_title").text('Saksi Internal');
			}
			else if(sebagai==2){
			$("#update_id_peran_title").text('Saksi External');
			}else{
			$("#update_id_peran_title").text('Terlapor');
			}
				
		
		 $.ajax({
										type: "POST",
                                        url: url1,
                                        data: "id="+id,
                                        dataType: "json",
                                        success: function(data){
                                            
											$.ajax({
												type: "POST",
												url: url2,
												data: "id="+id+"&sebagai="+data.sebagai,
												dataType: "json",
												success: function(datadetail){
												var update_tgl = data.tgl.split('-')[2]+'-'+data.tgl.split('-')[1]+'-'+data.tgl.split('-')[0];
												$("#tgl_update_wawancara-disp").val(update_tgl);
												$("#tgl_update_wawancara").val(update_tgl);											
												$("#update_tempat").val(data.tempat);
												$("#update_hari option[value='"+data.hari+"'").attr("selected", "selected");
												$("#update_pemeriksa option[value='"+data.id_pemeriksa+"'").attr("selected", "selected");
												$("#update_upload_file").text(data.upload_file);
												$("#update_sebagai").val(data.sebagai);
												$("#update_id_ba_was_3").val(data.id_ba_was_3);
												
												
												$("#counter-updateterlapor").val(datadetail.length);	
												for(var i=0;i<datadetail.length;i++){
												    var counter = i+1;
													$("#tbody-updatewawancaraTerlapor").append(
														'<tr id="trupdatepertanyaan'+counter+'">' +
														'<td>' + counter + '</td>' +
														'<td><textarea name="update_pertanyaan[]" rows="1" cols="40">'+datadetail[i].pertanyaan+'</textarea></td>' +
														'<td><textarea name="update_jawaban[]" rows="1" cols="40">'+datadetail[i].jawaban+'</textarea></td>' +
														'<td><a class="btn btn-primary" id="btn_delete_updatewawancara_terlapor" counter="'+counter+'">Hapus</a></td>' +
														'</tr>'
														);   
												}
												
												$('#m_update_wawancara').modal('show');
												
												$.ajax({
												type:"POST",
												url: url3,
												data: "sebagai="+sebagai+'&id_register='+id_register,
												//dataType: "json",
												success: function(dataPeran){
												$("#update_id_peran").append(dataPeran);
												$("#update_id_peran option[value='"+data.id_peran+"'").attr("selected", "selected");
												}
												});
												
											}
											});	
                                        }
		 });
		 
         });
		 //----------------------- Proses Update Terlapor ------------------------//

	};
</script>