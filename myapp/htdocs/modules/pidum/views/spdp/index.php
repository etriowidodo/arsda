<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\MsTersangkaPt;
use app\modules\pidum\models\PdmBerkas;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RP-6';
$this->subtitle = 'Register Pemberitahuan Dimulainya Penyidikan';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php /* if(Yii::$app->session->getFlash('message') != null): */ ?><!--
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> <?/*= Yii::$app->session->getFlash('message'); */?></h4>
</div>
--><?php /* endif */ ?>

<section class="content" style="padding: 0px;">
<style>
.disabledCheck{
        display:none;
}



</style>
    <div class="content-wrapper-1">
        <div class="pidum-pdm-spdp-index">


            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            $form = \kartik\widgets\ActiveForm::begin([
                        'id' => 'hapus-index',
                        'action' => '/pidum/spdp/delete'
            ]);
            ?>
            <div id="divHapus">
                
            </div>
			<div class="inline"><a class='btn btn-warning'  href="/pidum/spdp/create" title="Tambah Penerimaan SPDP">Tambah Penerimaan SPDP</a></div>
			<div class="pull-right"><a class='btn btn-success btnUbahCheckboxIndex' id="idUbah" title="Edit">Ubah</a>&nbsp
			<a class='btn btn-danger hapusTembusan btnHapusCheckboxIndex'  id="idHapus" title="Hapus">Hapus</a><br></div><br><br>
            <div id="btnHapus"></div><div id="btnUpdate"></div>
            <?php \kartik\widgets\ActiveForm::end() ?>
            <div class="row">
                <div class="col-md-12">
                    <?=
                    GridView::widget([
                        'id' => 'spdp',
                        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_perkara']];
                        },
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'no_surat',
                                        'label' => 'Asal SPDP, Nomor dan Tanggal',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) { //CMS_PIDUM_59 #bowo #16 juni 2016
											if($model->file_upload !=''){
												return  Html::a(Html::img('/image/pdf.png',['width'=>'30']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;".$model->assurat. "<br>" .$model->no_surat . "&nbsp  " . date('d-m-Y', strtotime($model->tgl_surat)) . "<br>Diterima SPDP :  &nbsp" . date('d-m-Y', strtotime($model->tgl_terima));
											}else{
												return  $model->assurat. "<br>" .$model->no_surat . "&nbsp  " . date('d-m-Y', strtotime($model->tgl_surat)) . "<br>Diterima SPDP :  &nbsp" . date('d-m-Y', strtotime($model->tgl_terima));
											}
                                        },
										//'group'=>true, 
                                    ],

                                    [
                                        'attribute' => 'nomor_tgl_berkas',
                                        'label' => 'Tempat dan Tanggal Kejadian',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) {
                                        	$split = explode('-',$model['tgl_kejadian_perkara']);
                                        	$jam   = " [".$split[0].":".$split[1]."] ";
                                        	$tgl   = $split[2]."-".$split[3]."-".$split[4];
											
                                            return $model['tempat_kejadian'].', <br>'.$jam.$tgl;
                                        },
                                    ],

                                    [
                                        'attribute' => 'undang_pasal',
                                        'label' => 'Melanggar UU dan Pasal',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) {
                                            return $model->undang_pasal;
                                        },
                                    ],

									// [
         //                                'attribute' => 'jpu',
         //                                'label' => 'P-16 Nomor dan Tanggal Jaksa Peneliti',
         //                                'format' => 'raw',
         //                                'value' => function ($model, $key, $index, $widget) {
         //                                    $resultJpus = "";
									// 		$sql = " SELECT a.nama FROM pidum.pdm_jaksa_p16 a INNER JOIN pidum.pdm_p16 b ON a.id_p16 = b.id_p16 WHERE a.id_perkara='".$model->id_perkara."' AND b.no_surat = '".$model->no_p16."' ";
									// 		$modelJpu = Yii::$app->db->createCommand($sql)->queryAll();
									// 		$i = 1;		
									// 		foreach ($modelJpu as $key => $value) {
									// 				$resultJpus .= $i .". ".$value['nama']."<BR>";
									// 				$no_p16 = $value['no_p16'];
									// 				$i++;
									// 		}
									// 		return $model->no_p16."&nbsp;&nbsp;".$model->tgl_p16."<BR>".$resultJpus;
         //                                },
         //                            ],
									
									

                                    
                                    [
                                        'attribute' => 'tersangka',
                                        'label' => 'Tersangka',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) {
											$resultStatus = "";
											
											$status = explode("#",$model->status);
											if(count($status) >=1 ){
												for($i=1;$i<=count($status);$i++){
													if($status[$i-1] == 'CekBerkas'){
														$sql = " SELECT a.id_berkas FROM pidum.pdm_berkas_tahap1 a INNER JOIN (select id_berkas,max(tgl_terima) from pidum.pdm_pengantar_tahap1 group by id_berkas) b on a.id_berkas = b.id_berkas INNER JOIN pidum.ms_tersangka_berkas c ON b.id_berkas = c.id_berkas WHERE a.id_perkara = '".$model->id_perkara."' group by a.id_berkas ";
														$berkas = Yii::$app->db->createCommand($sql)->queryAll();
														
																		
														foreach ($berkas as $key => $value) {
															$sql = " SELECT c.nama FROM pidum.pdm_berkas_tahap1 a INNER JOIN (select id_berkas,max(tgl_terima) max_tgl_terima from pidum.pdm_pengantar_tahap1 group by id_berkas) b on a.id_berkas = b.id_berkas INNER JOIN pidum.pdm_pengantar_tahap1 d ON b.id_berkas = d.id_berkas AND b.max_tgl_terima = d.tgl_terima INNER JOIN pidum.ms_tersangka_berkas c ON b.id_berkas = c.id_berkas AND d.no_pengantar = c.no_pengantar WHERE a.id_perkara = '".$model->id_perkara."' AND a.id_berkas='".$value['id_berkas']."'  ";
															$modelTersangka = Yii::$app->db->createCommand($sql)->queryAll();
														
															$no = 1;
															foreach ($modelTersangka as $key => $value) {
																$resultStatus .= $no.". ".$value['nama']."  <br>";
																$no++;
															}
															$resultStatus .= "<br>";
														}
													}else{
														
														$cek_t4 = Yii::$app->db->createCommand(" select count(a.*) from pidum.pdm_t4 a inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan where b.id_perkara='".$model->id_perkara."' ")->queryScalar();
														$cek_t5 = Yii::$app->db->createCommand(" select count(a.*) from pidum.pdm_t5 a inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan where b.id_perkara='".$model->id_perkara."' ")->queryScalar();
														if($cek_t4 >0 || $cek_t5 >0){ // jika ada tersangka melakukan permintaan perpanjangan
															/*$modelTersangka = MsTersangkaPt::find()
																				->select ("a.nama || case when c.id_t4 != '' then '(T-4)' when d.id_t5 != '' then '(T-5)' else '' end as nama ")
																				->from ("pidum.ms_tersangka_pt a")
																				->join ('inner join','pidum.pdm_perpanjangan_tahanan b','a.id_perpanjangan = b.id_perpanjangan')
																				->join ('left join','pidum.pdm_t4 c','b.id_perpanjangan = c.id_perpanjangan')
																				->join('left join','pidum.pdm_t5 d','b.id_perpanjangan = d.id_perpanjangan')
																				->where ("b.id_perkara='".$model->id_perkara."'")
																				->orderBy(['a.no_urut' => SORT_ASC])
																				->all();*/
															$modelTersangka = Yii::$app->db->createCommand(" select a.nama || case when c.id_t4 != '' then '(T-4)' when d.id_t5 != '' then '(T-5)' else '' end as nama,no_urut 
															FROM pidum.ms_tersangka_pt a 
															inner join pidum.pdm_perpanjangan_tahanan b ON a.id_perpanjangan = b.id_perpanjangan
															left join pidum.pdm_t4 c ON b.id_perpanjangan = c.id_perpanjangan
															left join pidum.pdm_t5 d ON b.id_perpanjangan = d.id_perpanjangan
															WHERE b.id_perkara='".$model->id_perkara."'")->queryAll();
															$no = 1;
															foreach ($modelTersangka as $key => $value) {
																$resultStatus .= $no.". ".$value['nama']."  <br>";
																$no++;
															}
															$resultStatus .= "<br>";
														}else{
														
														$modelTersangka = MsTersangka::find()
																			->select('a.no_urut,a.nama')
																			->from ('pidum.ms_tersangka a')
																			->join ('left join','pidum.ms_tersangka_pt b', 'upper(a.nama) = upper(b.nama)')
																			->where ("a.id_perkara='".$model->id_perkara."' and (trim(upper(a.nama)) != trim(upper(b.nama)) OR b.nama is null  )")
																			->groupBy("a.no_urut,a.nama")
																			->orderBy(['a.no_urut' => SORT_ASC])
																			->all();
														$no = 1;
														foreach ($modelTersangka as $key => $value) {
															$resultStatus .= $value->no_urut.". ".$value->nama."  <br>";
															$no++;
														}
														$resultStatus .= "<br>";
														
														}
														
														
														
													}//end cekberkas
												} // end for
											}
                                            
                                            return $resultStatus;
                                        },
                                    ],

                                    [
                                        'attribute' => 'tempat_kejadian',
                                        'label' => 'Tempat dan Tanggal Kejadian',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) {
											
                                            return $model->tempat_kejadian;
                                        },
                                    ],

									
                                    [
                                        'attribute' => 'status',
                                        'label' => 'Status',
                                        'format' => 'raw',
                                        'value' => function ($model, $key, $index, $widget) {

                                        	
											return $model->status;
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
										'checkboxOptions' => ['class' => 'checkbox-row'],
                                        'headerOptions' => ['class' => 'kartik-sheet-style','id'=>'td_checkbox'],
                                        'checkboxOptions' => function ($model, $key, $index, $column) {
											//return ['value' => str_replace("'","''",$model->id_perkara), 'class' =>  $model->status == "SPDP"  ? 'checkHapusIndex enabledCheck' : 'disabledCheck'];
											return ['value' => str_replace("'","''",$model->id_perkara), 'class' =>  'checkHapusIndex enabledCheck', 'nilai' =>$model->status];
										}
                                    ],
                                ],
                                'export' => false,
                                'pjax' => false,
                                'responsive' => true,
                                'hover' => true,
                            ]);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
           
        </section>
        <?php
        $js = <<< JS
		$(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/spdp/update2?id="+id;
        $(location).attr('href',url);
    	});
		$('td').css('word-wrap','break-word');
		// $('td').css('max-width','100px');
		function scroll_header(width_header)
		{
			var col = '<colgroup><col></col><col></col><col></col><col></col><col></col><col></col><col></col></colgroup>'
			$('table').after('<table  id="header-fixed" class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">'+col+'</table>');
				// var size_header		 = ['3.4%','19.6%','10%','10%','19.13%','20%','15%','5%'];
				// var size 			 = ['3.2%','19.8%','10%','10%','19.13%','20%','15%','5%'];

				// $.each(size,function(key,value){
				// $('colgroup:eq(0) col:eq('+key+')').css('width',value);					
				// });
				// $.each(size_header,function(key,value){	
				// $('colgroup:eq(1) col:eq('+key+')').css('width',value);	
				// });
				var header_margin	= $('.content').offset().top;		
				$('#header-fixed').css('position','fixed');
				$('#header-fixed').css('top',header_margin+50);
				$('#header-fixed').css('display','none');
				
				
				var tableOffset 	= $('table:eq(0)').offset().top;
				var header 			= $('table:eq(0) > thead').clone();
				var fixedHeader 	= $('#header-fixed').append(header);
				$('.summary').after(fixedHeader);
				//$('#spdp-container').css('overflow-x','hidden');
				$('#header-fixed').css('width',width_header);
				$(window).bind('scroll', function() {
				    var offset = $(this).scrollTop();
				   
				    if (offset >= tableOffset && fixedHeader.is(':hidden')) {
				        $('body').addClass('fixed sidebar-collapse');
				        fixedHeader.show();
				        
				    }
				    else if (offset < tableOffset) {
				        fixedHeader.hide();
				    }
				});
		}
		// scroll_header('96.3%');

		$(window).scroll(function() {
			// console.log($( window ).scrollTop());
			if($( window ).scrollTop()>234)
			{
				var width = $('#spdp-container table thead').width();
				// var col = '<colgroup><col></col><col></col><col></col><col></col><col></col><col></col><col></col></colgroup>'
				// $('table').after('<table  id="header-fixed" class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">'+col+'</table>');
				var header_margin	= $('.content').offset().top;		
				$('thead').css('position','fixed');
				$('thead').css('top',header_margin+50);
				$('thead').css('width',width);
				// $('thead th:eq(0)').width()
				$('tbody tr td').css('max-width','');
				$('tbody tr td:eq(0)').width($('thead th:eq(0)').width());
				$('tbody tr td:eq(1)').width($('thead th:eq(1)').width());
				$('tbody tr td:eq(2)').width($('thead th:eq(2)').width());
				$('tbody tr td:eq(3)').width($('thead th:eq(3)').width());
				$('tbody tr td:eq(4)').width($('thead th:eq(4)').width());
				$('tbody tr td:eq(5)').width($('thead th:eq(5)').width());
				$('tbody tr td:eq(6)').width($('thead th:eq(6)').width());
				$('tbody tr td:eq(7)').width($('thead th:eq(7)').width());

				$('thead th:eq(0)').width($('tbody tr td:eq(0)').width());
				$('thead th:eq(1)').width($('tbody tr td:eq(1)').width());
				$('thead th:eq(2)').width($('tbody tr td:eq(2)').width());
				$('thead th:eq(3)').width($('tbody tr td:eq(3)').width());
				$('thead th:eq(4)').width($('tbody tr td:eq(4)').width());
				$('thead th:eq(5)').width($('tbody tr td:eq(5)').width());
				$('thead th:eq(6)').width($('tbody tr td:eq(6)').width());
				$('thead th:eq(7)').width($('tbody tr td:eq(7)').width());
				
			}
			else
			{
				var width = $('#spdp-container table').width();
				// var col = '<colgroup><col></col><col></col><col></col><col></col><col></col><col></col><col></col></colgroup>'
				// $('table').after('<table  id="header-fixed" class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">'+col+'</table>');
				var header_margin	= $('.content').offset().top;		
				$('thead').css('position','');
				$('thead').css('top',header_margin+50);
				$('thead').css('width',width);
				// $('thead th:eq(0)').width()
				// $('tbody tr td').css('max-width','');
				// $('tbody tr td:eq(0)').width($('thead th:eq(0)').width());
				// $('tbody tr td:eq(1)').width($('thead th:eq(1)').width());
				// $('tbody tr td:eq(2)').width($('thead th:eq(2)').width());
				// $('tbody tr td:eq(3)').width($('thead th:eq(3)').width());
				// $('tbody tr td:eq(4)').width($('thead th:eq(4)').width());
				// $('tbody tr td:eq(5)').width($('thead th:eq(5)').width());
				// $('tbody tr td:eq(6)').width($('thead th:eq(6)').width());
				// $('tbody tr td:eq(7)').width($('thead th:eq(7)').width());

				// $('thead th:eq(0)').width($('tbody tr td:eq(0)').width());
				// $('thead th:eq(1)').width($('tbody tr td:eq(1)').width());
				// $('thead th:eq(2)').width($('tbody tr td:eq(2)').width());
				// $('thead th:eq(3)').width($('tbody tr td:eq(3)').width());
				// $('thead th:eq(4)').width($('tbody tr td:eq(4)').width());
				// $('thead th:eq(5)').width($('tbody tr td:eq(5)').width());
				// $('thead th:eq(6)').width($('tbody tr td:eq(6)').width());
				// $('thead th:eq(7)').width($('tbody tr td:eq(7)').width());
			}
			   
			   // scroll_header(width);
			}); 
		$('.sidebar-toggle').click(function(){
			 $('html, body').animate({
			 	 scrollTop: 0
			 },500);
		})

		$( document ).ready(function() {
			$("#td_checkbox").html('');
			$("#td_checkbox").html('<input type="checkbox" name="selection_all2" id="selection_all2" >');
			//$("#spdp-container table thead tr th").html('');
			/*$(".skip-export .kv-align-center .kv-align-middle .kv-row-select").prev().html();
			$("input[name='selection_all']").removeClass('select-on-check-all');
			$("#spdp-container table thead tr th").removeClass('kartik-sheet-style');
			$("#spdp-container table thead tr th").removeClass('kv-all-select');
			$("#spdp-container table thead tr th").removeClass('kv-align-center');
			$("#spdp-container table thead tr th").removeClass('kv-align-middle');
			$("#spdp-container table thead tr th").removeClass('skip-export');*/
			
			$("#selection_all2").click(function(){

			   if (this.checked){
				   // $("#spdp-container table tbody tr ").addClass('danger');
					//alert('x');
					$('.enabledCheck').prop('checked', true);
					$(".btnHapusCheckboxIndex").attr("disabled", false);
					$("input[name='hapusIndex[]']").detach();
					$('#divHapus').html('');
					$('#divHapus').append(
						"<input type='hidden' id='hapus' name='hapusIndex[]' value='all'>"
					);
				}else{
					$("#spdp-container table tbody tr ").removeClass('danger');
					//alert('y');
					$('#divHapus').html('');
					$('.enabledCheck').prop('checked', false);
					$(".btnHapusCheckboxIndex").attr("disabled", true);
					$("input[name='hapusIndex']").remove();
					
				}
				
			});
			
			
			
		});
	$('#idUbah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
		 bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		} else {
		var id =$('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pidum/spdp/update2?id="+id;
        $(location).attr('href',url);
		//alert(count);
		}
    });
	
	

$(document).keypress(function(e) {
    if(e.which == 13) {
    	$('.btn-warning[type=submit]').click();
    }
});

// $('.checkHapusIndex').each(function(i,x)
// {
// 	var tr   = $(this).val()
// 	var tr = $(this).parent().parent();
// 	if(i>0)
// 	{
// 		tr.attr('data-id')
// 	}
	
	
	
// });


JS;

        $this->registerJs($js);
        ?>