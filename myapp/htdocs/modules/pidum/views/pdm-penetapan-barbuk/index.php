<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenetapanBarbukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penetapan Sita Narkotika';
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-penetapan-barbuk-index">

   <div id="divTambah" class="col-md-11" style="width:82%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	<div  class="col-md-1" style="width:6%;">
        <!--<button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak</button>-->
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    
    <?php
        
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-penetapan-barbuk/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'   => function ($model, $key, $index, $grid) {
			return ['data-id' => $model['no_penetapan']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'penetapan',
                'header' => 'Permintaan dari <br> Nomor dan Tanggal Penetapan',
                // 'headerOptions' => ['class'=>'width:20px;'],
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
						return $model['penyidik']."<br/>".$model['no_penetapan']."<br/>".$model['tgl_surat'];
				}
            ],
			[
                'attribute'=>'sp_sita',
                'header' => 'Surat Perintah Penyitaan <br> Nomor dan Tanggal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
						return $model['sp_sita']."<br/>".$model['tgl_sp_sita'];
				}
            ],

            [
                'attribute'=>'nama_barbuk',
                'label' => 'Jenis Barang Bukti',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
                    $nama_barbuk    = explode('^',$model[nama_barbuk]);
                    $jumlah_barbuk  = explode('^',$model[jumlah_barbuk]);
                    $satuan_barbuk  = explode('^',$model[satuan_barbuk]);
                    $sno=1;
                    $x=0;
                    foreach ($nama_barbuk as $key => $value) {
                        $barbuk .= $sno.'. '.$nama_barbuk[$x].' '.$jumlah_barbuk[$x].' '.$satuan_barbuk[$x]."<br>";
                        $sno++;
                        $x++;
                    }
                    return $barbuk;
                }
            ],

            [
                'attribute'=>'jumlah_pembuktian',
                'label' => 'Penyelesaian',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
                    $jumlah_pembuktian   = explode('^',$model[jumlah_pembuktian]);
                    $satuan_pembuktian   = explode('^',$model[satuan_pembuktian]);

                    $jumlah_iptek   = explode('^',$model[jumlah_iptek]);
                    $satuan_iptek   = explode('^',$model[satuan_iptek]);

                    $jumlah_diklat   = explode('^',$model[jumlah_diklat]);
                    $satuan_diklat   = explode('^',$model[satuan_diklat]);

                    $jumlah_dimusnahkan   = explode('^',$model[jumlah_dimusnahkan]);
                    $satuan_dimusnahkan   = explode('^',$model[satuan_dimusnahkan]);

                   

                    $nama_barbuk    = explode('^',$model[nama_barbuk]);
                    $sno=1;
                    $x=0;
                    $detail='';
                    foreach ($nama_barbuk as $key => $value) {
                        $key = $key+1;
                        if($jumlah_pembuktian[$x]>0){
                            $detail .= $key.'. '.'Digunakan Untuk Pembuktian = '.$jumlah_pembuktian[$x].' '.$satuan_pembuktian[$x]."<br>";    
                        }

                        if($jumlah_iptek[$x]>0){
                            $detail .= $key.'. '.'Kepentingan Ilmu Pengetahuan = '.$jumlah_iptek[$x].' '.$satuan_iptek[$x]."<br>";    
                        }

                        if($jumlah_diklat[$x]>0){
                            $detail .= $key.'. '.'Kepentingan Diklat = '.$jumlah_diklat[$x].' '.$satuan_diklat[$x]."<br>";    
                        }

                        if($jumlah_dimusnahkan[$x]>0){
                            $detail .= $key.'. '.'Dimusnahkan = '.$jumlah_dimusnahkan[$x].' '.$satuan_dimusnahkan[$x]."<br>";    
                        }
                        $detail .= "<br>";
                        $key++;
                        $x++;
                    }
                    return $detail;
                }
            ],

			[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_penetapan'], 'class' => 'checkHapusIndex'];
                    }
            ],
			
			
		
       ],
       	'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>




<?php

 
    $js = <<< JS
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
		
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-penetapan-barbuk/update?id=" + id;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
	
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
		
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-penetapan-barbuk/update?id=" + id;
        $(location).attr('href',url);

		}
    });
	
	$('.btnPrintCheckboxIndex').click(function(){
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
			
            var id = $('.checkHapusIndex:checked').val();
			if(id=='0'){
				bootbox.dialog({
                message: "Belum Input Data P-22",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
				});
			}else{
				var cetak   = 'cetak?id_p22='+id; 
				window.location.href = cetak;
			}
		}
    }); 
	
JS;

    $this->registerJs($js);
?>