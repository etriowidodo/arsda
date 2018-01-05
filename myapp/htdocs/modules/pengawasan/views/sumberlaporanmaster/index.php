<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sumber Laporan Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sumber-laporan-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]);

    $dataProvider->pagination->pageSize=10; ?>

    <p>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_laporan"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_laporan"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/sumberlaporanmaster/create"><i class="glyphicon glyphicon-plus"> Sumber Laporan</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/sumberlaporanmaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_sumber_laporan']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_sumber_laporan',
            'nama_sumber_laporan',
            //'id_inspektur',
            'akronim',
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
                        return ['value' => $data['id_sumber_laporan'],'class'=>'checkbox-row'];
            
                        },


                ],
        ],
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){

      $("#ubah_laporan").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_laporan").addClass("disabled");
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
               $('#ubah_laporan, #hapus_laporan').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_laporan').removeClass('disabled');
               $('#ubah_laporan').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_laporan, #hapus_laporan').addClass('disabled');
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
//         $("#ubah_laporan").addClass("disabled");
//         $("#hapus_laporan").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_laporan").removeClass("disabled");
//         $("#hapus_laporan").removeClass("disabled");
//       }
// });

// $("#ubah_laporan").addClass("disabled");
//     $("#hapus_laporan").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/sumberlaporanmaster/update?id="+id;
        $(location).attr('href',url);
        
    });

$('#ubah_laporan').click (function (e) {
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
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/sumberlaporanmaster/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_laporan').click(function(){
    $('form').submit();

});

});

</script>