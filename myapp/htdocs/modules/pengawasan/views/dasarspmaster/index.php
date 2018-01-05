<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\DasarSpWasMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dasar Sp Was Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dasar-sp-was-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Tambah Dasar Sp Was Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_dasarspwas"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_dasarspwas"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/dasarspmaster/create"><i class="glyphicon glyphicon-plus"> Dasar SP_Was</i></a>
            </div>
    </p>
    <?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/dasarspmaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    );
    $dataProvider->pagination->pageSize=10;
    ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            // 'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_dasar_spwas']];
                        },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                'headerOptions'=>['style'=>'width: 4%;'],
                ],

                [
                    'attribute' => 'isi_dasar_spwas',
                    'label' => 'Isi Dasar SP_Was',
                    'value' => function ($model, $key, $index, $widget) {
                                            return $model->isi_dasar_spwas;
                                        },
                ],

                [
                    'attribute' => 'tahun',
                    'label' => 'Tahun Dasar SP_Was',
                    'value' => function ($model, $key, $index, $widget) {
                                            return $model->tahun;
                                        },
                    'headerOptions'=>['style'=>'width: 20%;'],
                ],

                //'id_dasar_spwas',
                // 'isi_dasar_spwas:ntext',
                // 'tahun',

                //['class' => 'yii\grid\ActionColumn','headerOptions'=>['style'=>'width: 10%;'],],
                [
                    'class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'width: 4%;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_dasar_spwas'],'class'=>'checkbox-row'];

                        },


                ],

            ],
        ]); ?>
    </div>
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $("#ubah_dasarspwas").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_dasarspwas").addClass("disabled");
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
               $('#ubah_dasarspwas, #hapus_dasarspwas').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_dasarspwas').removeClass('disabled');
               $('#ubah_dasarspwas').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_dasarspwas, #hapus_dasarspwas').addClass('disabled');
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
//         $("#ubah_dasarspwas").addClass("disabled");
//         $("#hapus_dasarspwas").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_dasarspwas").removeClass("disabled");
//         $("#hapus_dasarspwas").removeClass("disabled");
//       }
// });

// $("#ubah_dasarspwas").addClass("disabled");
//     $("#hapus_dasarspwas").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');

        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dasarspmaster/update?id="+id;
        $(location).attr('href',url);

    });

$('#ubah_dasarspwas').click (function (e) {
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
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dasarspmaster/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_dasarspwas').click(function(){
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
