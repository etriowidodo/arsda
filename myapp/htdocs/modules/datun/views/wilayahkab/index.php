<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsInstPenyidikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wilayah (Kabupaten)';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper-1">
<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
<div class="ms-wilayah-index">
    <div class="inline">
        <a class='btn btn-warning' href="<?php echo Yii::$app->request->baseUrl.'/datun/wilayahkab/create?id='.$idprop;?>" title="Tambah Wilayah Kabupaten">
        Tambah Wilayah Kabupaten
        </a>
    </div>
            <div class="pull-right">
                <a class='btn btn-success btnUbahCheckboxIndex' id="idUbah" title="Edit">Ubah</a>&nbsp
                <a class='btn btn-danger btnHapusCheckboxIndex' id="idHapus" title="Hapus">Hapus</a>
                <br>
            </div>
            <br><br>
            <div id="btnHapus"></div>
            <div id="btnUpdate"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_kabupaten_kota'],'id'=>$model['id_kabupaten_kota']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'id_prop',
            'id_kabupaten_kota',
            'deskripsi_kabupaten_kota',

            [
                'class' => 'kartik\grid\CheckboxColumn',
                'checkboxOptions' => ['class' => 'checkbox-row'],
                'headerOptions'   => ['class' => 'kartik-sheet-style',
				'id'			  => 'td_checkbox'],
                'checkboxOptions' => 
				   function ($model, $key, $index, $column){
                   return [
				   'value' => $model['id_kabupaten_kota'], 
				   'desk'  =>$model['deskripsi_kabupaten_kota'],
				   'class' =>  'checkHapusIndex enabledCheck'];
                }
            ],
        ],
        'export'        => false,
        'pjax'          => false,
        'responsive'    => true,
        'hover'         => true,
    ]); ?>

</div>
</div>

</div>
<?php 
$js = <<< JS
   $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/datun/wilayahkab/update?id="+id;
        $(location).attr('href',url);
    }); 
	
	
	$('#idTambah').click (function (e){
        //var id = $(this).closest('tr').data('data-id');
		//alert(id);
        var url = window.location.protocol + "//" + window.location.host + "/datun/wilayahkab/create?id="+id;
        $(location).attr('href',url);
    });
	
    $('#idUbah').click (function (e) {
        var desk = $('.checkHapusIndex:checked').attr('desk');
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
        var url = window.location.protocol + "//" + window.location.host + "/datun/wilayahkab/update?id="+id;
        $(location).attr('href',url);
        }
    });


$('#idHapus').on('click',function(){
   $(this).removeClass('btnHapusCheckboxIndex');
   $('button').on('click',function(){
    var click = $(this).index();
    if(click==0)
    {
        var array=[];
        $('.checkHapusIndex:checked').each(function(i){
           array.push($(this).val());
        });
       var send = {'id_kabupaten_kota':array}
       $.ajax({
            type        : 'POST',
            url         :'/datun/wilayahkab/delete',
            data        : send,                 
            success     : function(data)
                          {
                             var result = JSON.parse(data);
                             if(result.countSuccess>0)
                             {
                                var remTr = JSON.parse(result.resultDelete);
                                $.each(remTr,function(i,x){
                                    $('tr#'+x).remove();
                                });
                                $('tbody tr').each(function(i){
                                    $(this).find('td:eq(0)').text(i+1);  
                                }); 
                             }
                             if(result.countError>0)
                             {
                                
                             }
                          }
                });
    }
   })
});

JS;
$this->registerJs($js);
?>