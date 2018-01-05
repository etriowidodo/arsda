<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsInstPelakPenyidikanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instansi Pelaksana Penyidik';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper-1">
<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
<div class="ms-inst-pelak-penyidikan-index">
<div class="inline">
        <a class='btn btn-warning'  href="/pidum/ms-inst-pelak-penyidikan/create" title="Tambah Penerimaan SPDP">
        Tambah Instansi Pelaksana Penyidik
        </a>
    </div>
            <div class="pull-right">
                <a class='btn btn-success btnUbahCheckboxIndex' id="idUbah" title="Edit">Ubah</a>&nbsp
                <a class='btn btn-danger hapusTembusan btnHapusCheckboxIndex'  id="idHapus" title="Hapus">Hapus</a>
                <br>
            </div>
            <br><br>
            <div id="btnHapus"></div>
            <div id="btnUpdate"></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['kode_ip'],'id'=>$model['kode_ipp'],'data-kode-ipp'=>$model['kode_ipp']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_ip',
            'kode_ipp',
            'nama',
            'akronim',

            [
                'class' => 'kartik\grid\CheckboxColumn',
                'checkboxOptions' => ['class' => 'checkbox-row'],
                'headerOptions' => ['class' => 'kartik-sheet-style','id'=>'td_checkbox'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                   return ['value' => $model->kode_ipp,'data-id' => $model->kode_ip, 'class' =>  'checkHapusIndex enabledCheck'];
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
        var ip = $(this).closest('tr').data('id');
        var id = $(this).closest('tr').data('kode-ipp');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/ms-inst-pelak-penyidikan/update?kode_ip="+ip+"&kode_ipp="+id;
        $(location).attr('href',url);
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
        var ipp = $('.checkHapusIndex:checked').val();
        var ip  = $('.checkHapusIndex:checked').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/ms-inst-pelak-penyidikan/update?kode_ip="+ip+"&kode_ipp="+ipp;
        $(location).attr('href',url);
        }
    });


$('#idHapus').on('click',function(){
   $(this).removeClass('btnHapusCheckboxIndex');
   $('button').on('click',function(){
    var click = $(this).index();
    if(click==0)
    {
        var array   =[];
        var array2  =[];
        $('.checkHapusIndex:checked').each(function(i){
           array.push($(this).val());
           array2.push($(this).attr('data-id'));
        });
       var send = {'kode_ipp':array,'kode_ip':array2}
       $.ajax({
            type        : 'POST',
            url         :'/pidum/ms-inst-pelak-penyidikan/delete',
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
   });
});

JS;
$this->registerJs($js);
?>
