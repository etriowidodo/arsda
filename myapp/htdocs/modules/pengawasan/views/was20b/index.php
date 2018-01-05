<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\DasarSpWasMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-20b';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="dasar-sp-was-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Tambah Dasar Sp Was Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="cetak_was20b"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="hapus_was20b"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Hapus </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_was20b"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Ubah </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/was20b/create"><i class="glyphicon glyphicon-plus"> </i>&nbsp;&nbsp;WAS-20b</a>
        </div>
    </p>

    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
            <div id="w4" class="grid-view">
                <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                <?php
                echo GridView::widget([
                    'dataProvider'=> $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                    // 'filterModel' => $searchModel,
                    // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'contentOptions'=>['style'=>'text-align:center;'],
                        'class' => 'yii\grid\SerialColumn'],
                        
                        
                        ['label'=>'Nomor Surat Was20b',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'no_was_20b',
                        ],


                        ['label'=>'Nip Terlapor',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'nama_pegawai_terlapor',
                        ],

                        ['label'=>'Nama Terlapor',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'jabatan_pegawai_terlapor',
                        ],

                     ['class' => 'yii\grid\CheckboxColumn',
                     'headerOptions'=>['style'=>'text-align:center'],
                     'contentOptions'=>['style'=>'text-align:center; width:5%'],
                               'checkboxOptions' => function ($data) {
                                $result=json_encode($data);
                                return ['value' => $data['id_was_20b'],'class'=>'selection_one','json'=>$result];
                                },
                        ],
                        
                     ],   

                ]); ?>
               <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
<script type="text/javascript">
    window.onload=function(){
        $('#cetak_was20b,#ubah_was20b, #hapus_was20b').addClass('disabled');
        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x =$('.selection_one:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#cetak_was20b,#ubah_was20b, #hapus_was20b').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was20b').removeClass('disabled');
                   $('#cetak_was20b,#ubah_was20b').addClass('disabled');
                } else{
                   $('#cetak_was20b,#ubah_was20b, #hapus_was20b').addClass('disabled');
                }
        }

        $(document).on('click','#ubah_was20b',function(){
            var data=JSON.parse($('.selection_one:checked').attr('json'));
           // alert(data.id_was_20b);
            location.href='/pengawasan/was20b/update?id='+data.id_was_20b;   
        });


    $(document).on('click','#hapus_was20b',function(){
  
        var x=$(".selection_one:checked").length;
       // alert(x);/
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
                                      return $(this).attr('json');
                                }).get();
                                 var jml=$('.selection_one:checked').length;
                                    for (var i = 0; i<jml; i++) {
                                        var data=JSON.parse(checkValues[i]);
                                        $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was20b/delete',
                                            data:'id='+data.id_was_20b+'&jml='+jml,
                                            success:function(data){
                                                alert(data);
                                            }
                                            });

                                    };                          
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

        $(document).on('click', '#cetak_was20b', function () {

          // alert()
          var nilai=$('.selection_one:checked').val();
          //var data=JSON.parse(result);
          location.href='/pengawasan/was20b/cetak?id='+nilai;
          //alert(nilai);
        });
    }

    $(document).ready(function(){

        $('tr').dblclick(function(){
            var id = $(this).find('.selection_one').val();
         // var data=JSON.parse($('.selection_one:checked').attr('json'));
            location.href='/pengawasan/was20b/update?id='+id;   
       });
    }); 
</script>

