<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\pengawasan\models\SaksiEksternalInspeksi;
use app\modules\pengawasan\models\SaksiInternalInspeksi;
use app\modules\pengawasan\models\Was11InspeksiSearch;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-11 Inspeksi';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->subtitle = 'SURAT BANTUAN PENYAMPAIAN SURAT PANGGILAN SAKSI';
$session = Yii::$app->session;
// $this->params['ringkasan_perkara'] = $session->get('was_register');

//$this->params['ringkasan_perkara'] = $session->get('was_register');
//$this->params['breadcrumbs'][] = ['label' => 'Was-10', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>



<div class="was-11-index">
<h1><?//= Html::encode($this->title) ?></h1> 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    
   <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was11_int"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_was11_int"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_was11_int"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11-inspeksi/create?jns=Internal"><i class="glyphicon glyphicon-plus"> </i> WAS-11(saksi internal)</a>
        </div>
    </p>
  
  <br /><br />
  
  <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading single-project-nav">
            <ul class="nav nav-tabs"> 
                <li class="active">
                    <a href="#saksi_internal" data-toggle="tab" id="Msaksi_internal">Saksi Internal</a>
                </li>
                <li>
                    <a href="#saksi_eksternal" data-toggle="tab" id="Msaksi_eksternal">Saksi Eksternal</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="saksi_internal">
                  <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormgridwas11int', 
                      'options'=>['name'=>'searchFormgridwas11int'],
                      'fieldConfig' => [
                                  'options' => [
                                      'tag' => false,
                                      ],
                                  ],
                  ]); ?>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label col-md-1">Cari</label>
                          <div class="col-md-6 kejaksaan">
                            <div class="form-group input-group">       
                              <input type="text" name="cari" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Saksi Internal"><i class="fa fa-search"> Cari </i></button>
                            </span>
                          </div>
                      </div>
                    </div>
                  </div>
              <?php ActiveForm::end(); ?>
                  <?php 
                      $searchModel = new Was11InspeksiSearch();
                      $dataProviderInt = $searchModel->searchInt(Yii::$app->request->queryParams);
                  ?>
                  <?php Pjax::begin(['id' => 'grid-was10-inspeksi', 'timeout' => false,'formSelector' => '#searchFormgridwas11int','enablePushState' => false]) ?>
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderInt,

                    // 'filterModel' => $searchModel,
                     'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'internal'],
                     // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                         'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                         'contentOptions'=>['style'=>'text-align:center;'],            
                        'class' => 'yii\grid\SerialColumn'],

                        // 'header'=>'No'],
                        ['label'=>'No Register',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'attribute'=>'no_register',
                        ],

                         ['label' => 'Nama Saksi',
                         'format'=>'raw',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    $nm = explode('#', $data['nama_saksi']);
                                    $nama='';  
                                    $nomor = 1;
                                    for ($i=0; $i < count($nm) ; $i++) { 
                                       if(count($nm) <= 1){
                                          $nama .= $nm[$i];
                                       }else{
                                           $nama .= $nomor.' . '.$nm[$i].'<br>';
                                       }
                                     $nomor++;
                                     } 
                                    
                                    return $nama; 
                                  },
                              ],

                        ['label' => 'Jabatan Atasan',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    return $data['kepada_was11']; 
                                  },
                              ],
                        
                         
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                                'contentOptions'=>['style'=>'text-align:center;','class'=>'aksiInt'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) { 
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneInt','sts'=>'Internal'];
                                    },
                            ],
                          
                        ],
                     
                ]); 

                //  print_r($dataProviderInt);
                ?>
              <?php Pjax::end(); ?>
                </div>
                <div class="tab-pane fade" id="saksi_eksternal">
                  <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormgridwas11eks', 
                      'options'=>['name'=>'searchFormgridwas11eks'],
                      'fieldConfig' => [
                                  'options' => [
                                      'tag' => false,
                                      ],
                                  ],
                  ]); ?>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label col-md-1">Cari</label>
                          <div class="col-md-6 kejaksaan">
                            <div class="form-group input-group">       
                              <input type="text" name="cari" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Saksi Eksternal"><i class="fa fa-search"> Cari </i></button>
                            </span>
                          </div>
                      </div>
                    </div>
                  </div>
              <?php ActiveForm::end(); ?>
                  <?php 
                      $searchModel = new Was11InspeksiSearch();
                      $dataProviderEks = $searchModel->searchEks(Yii::$app->request->queryParams);
                  ?>
                  <?php Pjax::begin(['id' => 'grid-was11eks-inspeksi', 'timeout' => false,'formSelector' => '#searchFormgridwas11eks','enablePushState' => false]) ?>
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderEks,
                    // 'filterModel' => $searchModel,
                     'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'eksternal'],
                     // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                         'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                         'contentOptions'=>['style'=>'text-align:center;'],            
                        'class' => 'yii\grid\SerialColumn'],

                        // 'header'=>'No'],
                        ['label'=>'No Register',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'attribute'=>'no_register',
                        ],

                        ['label' => 'Nama Saksi',
                         'format'=>'raw',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    $nm = explode('#', $data['nama_saksi']);
                                    $nama='';  
                                    $nomor = 1;
                                    for ($i=0; $i < count($nm) ; $i++) { 
                                       if(count($nm) <= 1){
                                          $nama .= $nm[$i];
                                       }else{
                                           $nama .= $nomor.' . '.$nm[$i].'<br>';
                                       }
                                     $nomor++;
                                     } 
                                    
                                    return $nama; 
                                  },
                              ],

                        ['label' => 'Jabatan Atasan',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    return $data['kepada_was11']; 
                                  },
                              ],
                        
                         
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                                'contentOptions'=>['style'=>'text-align:center;','class'=>'aksiEks'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) {
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneEk','sts'=>'Eksternal'];
                                    },
                            ],
                          
                        ],
                     
                ]); ?>
                <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
  </div>      

</div>
<br />
<script type="text/javascript">
window.onload=function(){
   $('#cetak_was11_int,#ubah_was11_int, #hapus_was11_int').addClass('disabled');
   $('#cetak_was11_eks,#ubah_was11_eks, #hapus_was11_eks').addClass('disabled');
        $(document).on('click', '#ubah_was11_int', function () {
          // alert()
          var nilai=$('.selection_oneInt:checked').val();

          location.href='/pengawasan/was11-inspeksi/update?jns=Internal&id='+nilai;
          //alert(nilai);
        });

        $(document).on('click', '#ubah_was11_eks', function () {
          var nilai=$('.selection_oneEk:checked').val();


          location.href='/pengawasan/was11-inspeksi/update?jns=Eksternal&id='+nilai;
          //alert(nilai);
        });

        $(document).on('click', '#cetak_was11_int', function () {

          // alert()
          var nilai=$('.selection_oneInt:checked').val();
          location.href='/pengawasan/was11-inspeksi/cetak?jns=Internal&id='+nilai;
          //alert(nilai);
        });

        $(document).on('click', '#cetak_was11_eks', function () {
          var nilai=$('.selection_oneEk:checked').val();
          // alert()

          location.href='/pengawasan/was11-inspeksi/cetak?jns=Eksternal&id='+nilai;
          //alert(nilai);
        });


        $(document).on('change', '.select-on-check-all', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
        $(document).on('change', '.selection_one', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });

        $(document).on('click', '#Msaksi_internal', function () {
           $('.role').html('<a class="btn btn-primary btn-sm pull-right disabled" id="cetak_was11_int"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right disabled" id="hapus_was11_int"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right disabled" id="ubah_was11_int"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11-inspeksi/create?jns=Internal"><i class="glyphicon glyphicon-plus"> </i> WAS-11 Inspeksi(saksi internal)</a>');
           
           $('.selection_oneInt').prop('checked',false);
           $('.select-on-check-all').prop('checked',false); 
           $('tbody tr').removeClass('danger');
        });

        $(document).on('click', '#Msaksi_eksternal', function () {
           $('.role').html('<a class="btn btn-primary btn-sm pull-right disabled" id="cetak_was11_eks"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right disabled" id="hapus_was11_eks"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right disabled" id="ubah_was11_eks"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11-inspeksi/create?jns=Eksternal"><i class="glyphicon glyphicon-plus"> </i> WAS-11 Inspeksi(saksi eksternal)</a>');
           
           $('.selection_oneEk').prop('checked',false);
           $('.select-on-check-all').prop('checked',false);  
           $('tbody tr').removeClass('danger'); 
        });
        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
             if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_oneEk:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.selection_oneEk',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_oneEk:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#cetak_was11_eks,#ubah_was11_eks, #hapus_was11_eks').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was11_eks').removeClass('disabled');
                   $('#cetak_was11_eks,#ubah_was11_eks').addClass('disabled');
                } else{
                   $('#cetak_was11_eks,#ubah_was11_eks, #hapus_was11_eks').addClass('disabled');
                }
        }

        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            if(c== true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_oneInt:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.selection_oneInt',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_oneInt:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#cetak_was11_int,#ubah_was11_int, #hapus_was11_int').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was11_int').removeClass('disabled');
                   $('#cetak_was11_int,#ubah_was11_int').addClass('disabled');
                } else{
                   $('#cetak_was11_int,#ubah_was11_int, #hapus_was11_int').addClass('disabled');
                }
        }

};

  

$(document).on('click','#hapus_was11_int',function(){
  
            var x=$(".selection_oneInt:checked").length;
            // var data= JSON.parse($(".MselectionSIn_one:checked").attr('json'));
            // var checkValues = data.id_saksi;          
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
                                    var checkValues = $('.selection_oneInt:checked').map(function()
                                    {
                                         return $(this).val();
                                    }).get();
                                 //   alert(checkValues);
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was11-inspeksi/deleteint',
                                            data:'id='+checkValues,
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

$(document).on('click','#hapus_was11_eks',function(){
  
            var x=$(".selection_oneEk:checked").length;
            // var data= JSON.parse($(".MselectionSIn_one:checked").attr('json'));
            // var checkValues = data.id_saksi;          
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
                                    var checkValues = $('.selection_oneEk:checked').map(function()
                                    {
                                         return $(this).val();
                                    }).get();
                                 //   alert(checkValues);
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was11-inspeksi/deleteeks',
                                            data:'id='+checkValues,
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


  
    $(document).on('dblclick', '#internal tr td:not(.aksiInt)', function () {
      var id = $(this).closest('tr').find('.selection_oneInt').val(); 
             location.href='/pengawasan/was11-inspeksi/update?jns=Internal&id='+id;    
    });

  
    $(document).on('dblclick', '#eksternal tr td:not(.aksiEks)', function () {
      var id = $(this).closest('tr').find('.selection_oneEk').val(); 
             location.href='/pengawasan/was11-inspeksi/update?jns=Eksternal&id='+id;    
    });

    // $(document).on("dblclick", "#internal tr", function(e) {
    //           var nilai=$('.selection_oneInt').val();
    //           location.href='/pengawasan/was11-inspeksi/update?jns=Internal&id='+nilai;
    // });

    // $(document).on("dblclick", "#eksternal tr", function(e) {
    //           var nilai=$('.selection_oneEk').val();
    //           location.href='/pengawasan/was11-inspeksi/update?jns=Eksternal&id='+nilai;
    // });


// $(document).ready(function(){ 

//           $('tr').dblclick(function(){
//             var nilai=$('.selection_oneInt').val();
//             location.href='/pengawasan/was11-inspeksi/update?jns=Internal&id='+nilai;
//           }); 

//           $('tr').dblclick(function(){
//             var nilai=$('.selection_oneInt').val();
//             location.href='/pengawasan/was11-inspeksi/update?jns=Internal&id='+nilai;
//           });  

//      });

</script>
<style type="text/css">
.panel-default > .panel-heading {
        background-color: #2a8cbd;
        color: #0f5e86;
        text-transform: uppercase;
        font-weight: 500;
    }
    .nav-tabs > li.active > a:after {
        position: absolute;
        content: " ";
        background: #2a8cbd;
        width: 12px;
        height: 12px;
        border-radius: 3px 0 0 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        box-shadow: none;
        bottom: -35%;
        right: 50%;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
        border: none!important;
    }
</style>





