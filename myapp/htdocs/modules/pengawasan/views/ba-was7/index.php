<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\db\Query;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'BA-WAS 7';
$this->subtitle = 'SURAT PERNYATAAN MENERIMA / MENOLAK DAN TIDAK AKAN MENGAJUKAN / AKAN MENGAJUKAN KEBERATAN TERHADAP SURAT KEPUTUSAN PHD';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>




<section class="content" style="padding: 0px;">
<br />

<div class="pidum-pdm-spdp-index">
    <br />
<p>
        <!--<?= Html::a('Tambah Dasar Sp Was Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="cetak_bawas7"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="hapus_bawas7"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Hapus </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_bawas7"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Ubah </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/ba-was7/create"><i class="glyphicon glyphicon-plus"> </i>&nbsp;&nbsp;BA-WAS7</a>
        </div>
    </p>

    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
            <div id="w4" class="grid-view">
                <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                <?php
                echo GridView::widget([
                    'dataProvider'=> $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-bordered table-hover'],
                    // 'filterModel' => $searchModel,
                    // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'contentOptions'=>['style'=>'text-align:center;'],
                        'class' => 'yii\grid\SerialColumn'],

                        ['label'=>'Nama Terlapor',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'nama_terlapor',
                        ],

                        ['label'=>'Yang Menyampaiakan SK',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'nama_penyampai',
                        ],

                         ['label'=>'Saksi',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            //'attribute'=>'nama_saksi1',
                            'value'=>function($data){
                              return 'Saksi 1 : '. $data['nama_saksi1'].'<br> Saksi 2 : '. $data['nama_saksi2'];
                            }
                        ],

                     ['class' => 'yii\grid\CheckboxColumn',
                     'headerOptions'=>['style'=>'text-align:center'],
                     'contentOptions'=>['style'=>'text-align:center; width:5%','class'=>'aksinya'],
                               'checkboxOptions' => function ($data) {
                                $result=json_encode($data);
                                return ['value' => $data['id_ba_was_7'],'class'=>'selection_one','json'=>$result];
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
        $('#cetak_bawas7,#ubah_bawas7, #hapus_bawas7').addClass('disabled');
        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
             if(c==true){
                 $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_one:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#cetak_bawas7,#ubah_bawas7, #hapus_bawas7').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_bawas7').removeClass('disabled');
                   $('#cetak_bawas7,#ubah_bawas7').addClass('disabled');
                } else{
                   $('#cetak_bawas7,#ubah_bawas7, #hapus_bawas7').addClass('disabled');
                }
        }

        $(document).on('click','#ubah_bawas7',function(){
            var data=JSON.parse($('.selection_one:checked').attr('json'));
           // alert(data.id_was_16b);
            location.href='/pengawasan/ba-was7/update?id='+data.id_ba_was_7;   
        });


    $(document).on('click','#hapus_bawas7',function(){
  
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
                                            url:'/pengawasan/ba-was7/delete',
                                            data:'id='+data.id_ba_was_7+'&jml='+jml,
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

        $(document).on('click', '#cetak_bawas7', function () {

          // alert()
          var nilai=$('.selection_one:checked').val();
          //var data=JSON.parse(result);
          location.href='/pengawasan/ba-was7/cetak?id='+nilai;
          //alert(nilai);
        });

        $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.selection_one').val();
          // alert(id);
                 location.href='/pengawasan/ba-was7/update?id='+id;   
          //do something with id
        });
    }

    $(document).ready(function(){

        // $('tr').dblclick(function(){
        //     var id = $(this).find('.selection_one').val();
        //  // var data=JSON.parse($('.selection_one:checked').attr('json'));
        //           location.href='/pengawasan/ba-was7/update?id='+id; 
        // });
 });
</script>

