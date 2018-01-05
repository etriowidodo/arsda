<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was10InspeksiSearch;
use yii\db\Query;
use yii\widgets\Pjax;
use app\modules\pengawasan\components\FungsiComponent; 

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-10 Surat Permintaan Keterangan Terlapor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was10-inspeksi-tu/index"> Kembali </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="tambah_nomor"><i class="fa fa-envelope"> </i> Tambah Nomor</a>
           <!-- <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="fa fa-pencil"> Ubah </i></a>&nbsp; -->
            <!-- <a class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#create"><i class="glyphicon glyphicon-plus"> Tambah Baru</i></a> -->
           <!--  <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was10-inspeksi/form1"><i class="fa fa-plus"> </i>Was10</a> -->
        </div>
    </p>


    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div id="w0" class="grid-view">
           
            <?=GridView::widget([
                                'dataProvider'=> $dataProvider,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'No Surat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'no_surat',
                                    ],

                                    ['label'=>'Tanggal Pemeriksaan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'tanggal_pemeriksaan_was10',
                                    ],

                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Pemriksa',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pemeriksa',
                                    ],

                                 [
                                 // 'class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
                                  'contentOptions'=>['class'=>'text-center '],
                                  'format'=>'raw',
                                  'header'=>'<input type="checkbox" name="Mselection_all" id="Mselection_all" />', 
                                        'value'=>function($data, $index){
                                          $result=json_encode($data);
                                            return "<input type='checkbox' name='Mselection[]' value='".$data['no_register']."' 
                                                panggilan='".$data['nip_pegawai_terlapor'].'#'.$data['id_surat_was10'].'#'.$data['no_register']."' class='Mselection_one' json='".$result."' />";
                                        },
                                    ],

                                 ],   

                            ]); ?>
        </div>
    </div>



     <?php
        $form = ActiveForm::begin([
                      'action' => ['insertnomor'],
                      'method' => 'POST',
                      'id'=>'formint', 
                    ]);
  ?>
<div class="modal fade" id="buat_nomor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Nomor</h4>
                </div>
                  <br>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label col-md-3">Nomor Surat</label>
                        <div class="col-md-9">
                          <input type="text" id="nomor" class="form-control" name="nomor" style="width: 300px;"> 
                          <input type="hidden" id="surat_was10_ins_tu" class="form-control" name="surat_was10_ins_tu" style="width: 300px;">
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer" style="margin-top:20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-default">Simpan</button>
                </div>
            </div>
               <?php ActiveForm::end(); ?>
      </div>
  </div>

    <style type="text/css">
    .modal-lebar{
      width: 1200px;
      overflow: hidden;
    }
    .modal-lebar table{
      font-size: 12px;
    }
    </style>

    <script type="text/javascript">
    window.onload=function(){

         $(document).on('click','#tambah_nomor',function(){
             var check=JSON.parse($('.Mselection_one:checked').attr('json'));
             $('#surat_was10_ins_tu').val(check.id_surat_was10);
             $('#nomor').val(check.no_surat);
             $('#buat_nomor').modal({backdrop: 'static', keyboard: false});
        });  

        $("#buat_nomor").addClass("disabled");

        $(document).on('change','#Mselection_all',function() {
            var c = this.checked ? true : false;
            $('.Mselection_one').prop('checked',c);
            var x=$('.Mselection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.Mselection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.Mselection_one:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#buat_nomor').removeClass('disabled');
                } else if(n > 1){
                   $('#buat_nomor').addClass('disabled');
                } else{
                   $('#buat_nomor').addClass('disabled');
                }
        }
    }
    </script>