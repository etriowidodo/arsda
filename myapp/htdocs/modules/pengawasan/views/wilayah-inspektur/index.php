<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wilayah Inspektur';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wilayah-inspektur-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/wilayah-inspektur/create"><i class="glyphicon glyphicon-plus"> Wilayah Inspektur</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/wilayah-inspektur/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); 

    $dataProvider->pagination->pageSize=10;
    ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?php Pjax::begin(['id' => 'wilayah-inspektur-grid' , 'timeout' => false , 'formSelector' => '#SearchForm', 'enablePushState' => false]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
       /* 'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_dipa']];
                        },*/
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn','headerOptions'=>['style'=>'width: 4%;']
            ],
            // 'id_dipa',
            [
                'label'=>'Nama Inspektur',
                'attribute' => 'nama_inspektur'
            ],

            [
                'label'=>'Nama Wilayah',
                'attribute'=>'nama_wilayah',
            ],
          
             [
                'label'=>'Nama Kejati',
                'attribute'=>'nama_kejati',
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
               // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
            // you may configure additional properties here
               'checkboxOptions' => function ($data) {
                return ['value' => $data['id_inspektur'].'#'.$data['id_wilayah'].'#'.$data['id_kejati'],'class'=>'selection_one'];
                },
             ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">


window.onload=function(){
   
$("#ubah_inspektur").addClass("disabled");
    $("#hapus_inspektur").addClass("disabled");
    /*permintaan pa putut*/
   
        $(document).on('change','.select-on-check-all',function(){
        // $('.select-on-check-all').change(function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
    $(document).on('change','.selection_one',function(){
       // $('.selection_one').change(function () {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_inspektur, #hapus_inspektur').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_inspektur').removeClass('disabled');
               $('#ubah_inspektur').addClass('disabled');
            } else{
               $('#ubah_inspektur, #hapus_inspektur').addClass('disabled');
            }
    }
    $(document).on('click','#ubah_inspektur',function(){
        
        var x=$(".selection_one:checked").length;
        var link=$(".selection_one:checked").val();
		var tm = link.toString().split("#");
		var id_inspektur =tm[0].split(" ").join("");
        var id_wilayah  =tm[1].split(" ").join("");
        var id_kejati   =tm[2].split(" ").join("");
        //alert(id_inspektur+'-'+id_wilayah+'-'+id_kejati);    
        location.href='/pengawasan/wilayah-inspektur/update?id_inspektur='+id_inspektur+'&id_wilayah='+id_wilayah+'&id_kejati='+id_kejati;   
    });

    $(document).on('click','#hapus_inspektur',function(){
  //  $('#hapus_inspektur').click(function(){
        var x=$(".selection_one:checked").length;
         // var link=$(".chk1:checked").val();
       /*  alert(x);*/
        if(x<=0){
   //          var warna='black';
         
            // notifyHapus(warna);
         return false
         }else{
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.selection_one:checked').map(function()
                                {
                                    return $(this).val();
                                  /*  alert('aaaaa');*/
                                    //return $(this).val();
                                }).get();
                           //  alert(checkValues);
                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/wilayah-inspektur/delete',
                                    data:'id='+checkValues+'&jml='+x,
                                    success:function(data){
                                        alert(data);
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
$(document).on('dblclick','tr',function(){
//$('tr').dblclick(function(){
  var id = $(this).find('.selection_one').val();
  var id_inspektur=$(this).find(".selection_one").attr('id_inspektur');
  var id_wilayah  =$(this).find(".selection_one").attr('id_wilayah');
  var id_kejati   =$(this).find(".selection_one").attr('id_kejati');
  location.href='/pengawasan/wilayah-inspektur/update?id_inspektur='+id_inspektur+'&id_wilayah='+id_wilayah+'&id_kejati='+id_kejati;   
  //do something with id
});
}
$(document).ready(function(){


    $('#ubah_inspektur').click(function(){
        
        var x=$(".selection_one:checked").length;
        var link=$(".selection_one:checked").val();
        var id_inspektur=$(".selection_one:checked").attr('id_inspektur');
        var id_wilayah  =$(".selection_one:checked").attr('id_wilayah');
        var id_kejati   =$(".selection_one:checked").attr('id_kejati');
            
        location.href='/pengawasan/wilayah-inspektur/update?id_inspektur='+id_inspektur+'&id_wilayah='+id_wilayah+'&id_kejati='+id_kejati;   
    });

        
    
});

function notify(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Merubah data harus memilih satu data,Harap pilih satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
function notifyHapus(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Menghapus data harus memilih salah data,Harap pilih salah satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
/*$('.table-bordered tr').hover(function() {
      $(this).addClass('hover');
    }, function() {
      $(this).removeClass('hover');
    });

$('.table-bordered tr').on('click', function() {
    $(this).toggleClass('click-row');
    var z=$(this).attr('class');
      if(z=='hover'){
       $(this).find('.checkbox-row').prop('checked',false);
        $("#ubah_inspektur").addClass("disabled");
        $("#hapus_inspektur").addClass("disabled");
      }else{
        $(this).find('.checkbox-row').prop('checked',true);
        $("#ubah_inspektur").removeClass("disabled");
        $("#hapus_inspektur").removeClass("disabled");
      }
});

$("#ubah_inspektur").addClass("disabled");
    $("#hapus_inspektur").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/wilayah-inspektur/update?id="+id;
        $(location).attr('href',url);
        
    });

$('#ubah_inspektur').click (function (e) {
        var count =$('.checkbox-row:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                message: "<center>Silahkan pilih hanya 1 data untuk diubah</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
        } else {
        var id = $('.checkbox-row:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/wilayah-inspektur/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_inspektur').click(function(){
    $('form').submit();

});

});*/

</script>