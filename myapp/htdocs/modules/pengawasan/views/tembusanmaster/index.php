<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tembusan Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tembusan-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Tambah Tembusan Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_tembusan"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_tembusan"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/tembusanmaster/create"><i class="glyphicon glyphicon-plus"> Tembusan</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/tembusanmaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_tembusan']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tembusan',
            'nama_tembusan',
            'for_tabel',
            'nama_wilayah',
            // 'flag',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

            //['class' => 'yii\grid\ActionColumn'],
            [
                    'class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'width: 4%;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_tembusan'],'class'=>'checkbox-row'];
            
                        },


                ],
        ],
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#ubah_tembusan").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_tembusan").addClass("disabled");
    /*permintaan pa putut*/
   
         $('.select-on-check-all').change(function() {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.checkbox-row:checked').length;
            ConditionOfButton(x);
        });
        
        $('.checkbox-row').change(function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.checkbox-row:checked').length;
            ConditionOfButton(x);
        });

    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_tembusan, #hapus_tembusan').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_tembusan').removeClass('disabled');
               $('#ubah_tembusan').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_tembusan, #hapus_tembusan').addClass('disabled');
            }
    }
// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tr').on('click', function() {
//     $(this).toggleClass('click-row');
//     var z=$(this).attr('class');
//       if(z=='hover'){
//        $(this).find('.checkbox-row').prop('checked',false);
//         $("#ubah_tembusan").addClass("disabled");
//         $("#hapus_tembusan").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_tembusan").removeClass("disabled");
//         $("#hapus_tembusan").removeClass("disabled");
//       }
// });

// $("#ubah_tembusan").addClass("disabled");
//     $("#hapus_tembusan").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/tembusanmaster/update?id="+id;
        $(location).attr('href',url);
        
    });

$('#ubah_tembusan').click (function (e) {
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
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/tembusanmaster/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_tembusan').click(function(){
    $('form').submit();

});

});

</script>