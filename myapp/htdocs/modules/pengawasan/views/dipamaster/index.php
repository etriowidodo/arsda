<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dipa Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/dipamaster/create"><i class="glyphicon glyphicon-plus"> Dipa</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/dipamaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    );

    $dataProvider->pagination->pageSize=10;
    ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_dipa']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','headerOptions'=>['style'=>'width: 4%;']],

            // 'id_dipa',
            [
                'label'=>'Dipa',
                'attribute' => 'dipa'
            ],

            [
            'label'=>'Tahun',
            'attribute'=>'tahun',
            'headerOptions'=>['style'=>'width: 20%;'],
            ],
            // 'is_aktif',
            [
                'label' => 'Status',
                'value' => function($data){
                $is_aktif="";
                $status=$data['is_aktif'];
                if($status==TRUE){
                    $is_aktif="Aktif";
                }else{
                    $is_aktif="Tidak Aktif";
                }
                return $is_aktif;
                },
                'headerOptions'=>['style'=>'width: 20%;'],
            ],

            //['class' => 'yii\grid\ActionColumn'],
            [
                    'class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'width: 4%;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_dipa'],'class'=>'checkbox-row'];

                        },


                ],
        ],
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){

     $("#ubah_inspektur").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_inspektur").addClass("disabled");
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
               $('#ubah_inspektur, #hapus_inspektur').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_inspektur').removeClass('disabled');
               $('#ubah_inspektur').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_inspektur, #hapus_inspektur').addClass('disabled');
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
//         $("#ubah_inspektur").addClass("disabled");
//         $("#hapus_inspektur").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_inspektur").removeClass("disabled");
//         $("#hapus_inspektur").removeClass("disabled");
//       }
// });

// $("#ubah_inspektur").addClass("disabled");
//     $("#hapus_inspektur").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');

        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dipamaster/update?id="+id;
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
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dipamaster/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_inspektur').click(function(){
    bootbox.dialog({
        title: "Peringatan",
        message: "Apakah anda ingin menghapus data ini?",
        buttons:{
            ya : {
                label: "Ya",
                className: "btn-primary",
                callback: function(){
                    $('form').submit();
                }
            },
            tidak : {
                label: "Tidak",
                className: "btn-primary"
            },
        },
    });
});

});

</script>
