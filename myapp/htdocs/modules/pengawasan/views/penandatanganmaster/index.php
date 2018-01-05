<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penandatangan Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penandatangan-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        // $from_tabel = $param;
        $searchModel = new \app\modules\pengawasan\models\PenandatanganSearch;
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $from_tabel); 
    ?>

    <p>
        <!--<?= Html::a('Tambah Inspektur Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_pegawai"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_pegawai"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/penandatanganmaster/create"><i class="glyphicon glyphicon-plus"> Penandatangan</i></a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/penandatanganmaster/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['nip']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nip',
            'nama_penandatangan',
            // 'pangkat_penandatangan',
            [
                'attribute' => 'pangkat_penandatangan',
                'label' => 'Pangkat'
            ],
            [
                'attribute' => 'golongan_penandatangan',
                'label' => 'Golongan'
            ],
            // 'golongan_penandatangan',
            'nama_wilayah',
            'jabatan_penandatangan',
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
                        return ['value' => $data['nip'],'class'=>'checkbox-row'];
            
                        },


                ],
        ],
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $("#ubah_pegawai").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_pegawai").addClass("disabled");
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
               $('#ubah_pegawai, #hapus_pegawai').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_pegawai').removeClass('disabled');
               $('#ubah_pegawai').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_pegawai, #hapus_pegawai').addClass('disabled');
            }
    }

// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tbody tr').on('click', function() {
//     $(this).toggleClass('click-row');
//     var z=$(this).attr('class');
//       if(z=='hover'){
//        $(this).find('.checkbox-row').prop('checked',false);
//         $("#ubah_pegawai").addClass("disabled");
//         $("#hapus_pegawai").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_pegawai").removeClass("disabled");
//         $("#hapus_pegawai").removeClass("disabled");
//       }
// });



// $("#ubah_pegawai").addClass("disabled");
//     $("#hapus_pegawai").addClass("disabled");

$('tbody tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/penandatanganmaster/update?id="+id;
        $(location).attr('href',url);
        
    });

$('#ubah_pegawai').click (function (e) {
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
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/penandatanganmaster/update?id="+id;
        $(location).attr('href',url);
        }
    });
// $('.select-on-check-all').click(function(){
//     $('.checkbox-row').attr('checked',this.checked);
// });
// $('.checkbox-row').click(function(){
//     if($(".checkbox-row").length >=2) {
//             $(".select-on-check-all").attr("checked", "checked");
//         } else {
//             $(".select-on-check-all").removeAttr("checked");
//         }
// });
$('#hapus_pegawai').click(function(){
    $('form').submit();

});

});

</script>