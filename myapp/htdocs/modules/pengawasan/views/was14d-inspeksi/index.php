<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\modules\pengawasan\models\was14dSearch;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\DasarSpWasMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-14D';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dasar-sp-was-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin([
          // 'action' => ['create'],
          'method' => 'get',
          'id'=>'searchFormWas14d', 
          'options'=>['name'=>'searchFormWas14d'],
          'fieldConfig' => [
                      'options' => [
                          'tag' => false,
                          ],
                      ],
      ]); ?>
      <div class="col-md-12" style="margin-top: 20px;">
         <div class="form-group">
            <label class="control-label col-md-1">Cari</label>
              <div class="col-md-6 kejaksaan">
                <div class="form-group input-group">       
                  <input type="text" name="cari" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default browse" type="submit" data-placement="left" title="Pencarian"><i class="fa fa-search"> Cari </i></button>
                </span>
              </div>
          </div>
        </div>
      </div>
    <?php ActiveForm::end(); ?>
    <p>
        <!--<?= Html::a('Tambah Dasar Sp Was Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="cetak_was14d"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="hapus_was14d"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Hapus </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_was14d"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Ubah </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/was14d-inspeksi/create"><i class="glyphicon glyphicon-plus"> </i>&nbsp;&nbsp;WAS-14D</a>
        </div>
    </p>

    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
            <div id="w4" class="grid-view">
                <?php 
                  $searchModel = new was14dSearch();
                  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                ?>
                <?php Pjax::begin(['id' => 'was14d-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormWas14d','enablePushState' => false]) ?>
                <?php
                echo GridView::widget([
                    'dataProvider'=> $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'tbl_was14d'],
                    // 'filterModel' => $searchModel,
                    // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'contentOptions'=>['style'=>'text-align:center;'],
                        'class' => 'yii\grid\SerialColumn'],
                        
                        
                        ['label'=>'Nomor Surat',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'no_was14d',
                        ],


                        ['label'=>'Nip Terlapor',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'nip_terlapor',
                        ],

                        ['label'=>'Nama Terlapor',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'nama_terlapor',
                        ],

                        ['label'=>'Kepada',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'kepada_was14d',
                        ],

                     ['class' => 'yii\grid\CheckboxColumn',
                     'headerOptions'=>['style'=>'text-align:center'],
                     'contentOptions'=>['style'=>'text-align:center; width:5%','class'=>' aksinya'],
                     // 'contentOptions'=>['class'=>' aksinya'],
                               'checkboxOptions' => function ($data) {
                                $result=json_encode($data);
                                return ['value' => $data['id_was14d'],'class'=>'selection_one','json'=>$result];
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
        $('#cetak_was14d,#ubah_was14d, #hapus_was14d').addClass('disabled');
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
                   $('#cetak_was14d,#ubah_was14d, #hapus_was14d').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was14d').removeClass('disabled');
                   $('#cetak_was14d,#ubah_was14d').addClass('disabled');
                } else{
                   $('#cetak_was14d,#ubah_was14d, #hapus_was14d').addClass('disabled');
                }
        }

        $(document).on('click','#ubah_was14d',function(){
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            location.href='/pengawasan/was14d-inspeksi/update?id='+data.id_was14d;   
        });

        $(document).on('click','#hapus_was14d',function(){
  
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
                                                url:'/pengawasan/was14d-inspeksi/delete',
                                                data:'id='+data.id_was14d+'&jml='+jml,
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


        $(document).on('click', '#cetak_was14d', function () {

          // alert()
          var nilai=$('.selection_one:checked').val();
          //var data=JSON.parse(result);
          location.href='/pengawasan/was14d-inspeksi/cetak?id='+nilai;
          //alert(nilai);
        });

         $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.selection_one').val();
          // alert(id);
                 location.href='/pengawasan/was14b-inspeksi/update?id='+id;   
          //do something with id
        });
    }

</script>
