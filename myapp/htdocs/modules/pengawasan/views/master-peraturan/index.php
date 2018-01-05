<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\MasterPeraturanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Peraturan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-peraturan-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Create Master Peraturan', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
          <a class="btn btn-primary btn-sm pull-right" id="hapus_peraturan"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
          <a class="btn btn-primary btn-sm pull-right" id="ubah_peraturan"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
          <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/master-peraturan/create"><i class="glyphicon glyphicon-plus"> Tambah</i></a>
        </div>
    </p>
    <?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/master-peraturan/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_peraturan',
            'isi_peraturan:ntext',
            'tgl_perja',
            'kode_surat',
            'pasal',
            // 'tgl_inactive',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',
            // [
            //     'class' => 'yii\grid\CheckboxColumn',
            //     'headerOptions'=>['style'=>'width: 4%;'],
            //     'checkboxOptions' => function ($data) {
            //         return ['value' => $data['id_peraturan'],'class'=>'selection_one']; 
            //     }, 
            // ],

            ['class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'text-align:center'],
             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                       'checkboxOptions' => function ($data) {
                        $result=json_encode($data);
                        return ['value' => $data['id_peraturan'],'class'=>'selection_one','json'=>$result];
                        },
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
$(document).ready(function(){
  
     $("#ubah_peraturan").addClass("disabled");
    //$("").addClass("disabled");
    $("#hapus_peraturan").addClass("disabled");
    /*permintaan pa putut*/
   
         $('.select-on-check-all').change(function() {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
        $('.selection_one').change(function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });

    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_peraturan, #hapus_peraturan').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_peraturan').removeClass('disabled');
               $('#ubah_peraturan').addClass('disabled');
             //  $('').addClass('disabled');
            } else{
               $('#ubah_peraturan, #hapus_peraturan').addClass('disabled');
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
    //        $(this).find('.selection_one').prop('checked',false);
    //         $("#ubah_peraturan").addClass("disabled");
    //         $("#hapus_peraturan").addClass("disabled");
    //       }else{
    //         $(this).find('.selection_one').prop('checked',true);
    //         $("#ubah_peraturan").removeClass("disabled");
    //         $("#hapus_peraturan").removeClass("disabled");
    //       }
    // });

    // $("#ubah_peraturan").addClass("disabled");
    // $("#hapus_peraturan").addClass("disabled");
 
    $('#ubah_peraturan').click (function (e) {
        var count =$('.selection_one:checked').length;
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
        var id = $('.selection_one:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/master-peraturan/update?id="+id;
        $(location).attr('href',url);
        }
    });

// $('#hapus_peraturan').click(function(){
//     $('form').submit();

// });

$(document).on('click','#hapus_peraturan',function(){  
    var x=$(".selection_one:checked").length; 
                 if(x<=0){ 
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
                                }).get();
          
            //alert(checkValues);
            //return false();
                                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/master-peraturan/delete',
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

});

</script>
