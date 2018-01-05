<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\SaksiEksternal;
use yii\widgets\Pjax;
use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\Was11Search;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-11';
$this->subtitle = 'SURAT BANTUAN PENYAMPAIAN SURAT PANGGILAN SAKSI';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
// $this->params['ringkasan_perkara'] = $session->get('was_register');

//$this->params['ringkasan_perkara'] = $session->get('was_register');
//$this->params['breadcrumbs'][] = ['label' => 'Was-10', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>



<div class="was-11-index">

    
    <br />

   <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was11_int"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_was11_int"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_was11_int"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11/create?jns=Internal"><i class="glyphicon glyphicon-plus"> </i> WAS-11(saksi internal)</a>
        </div>
    </p>
	
	<br />
	
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
                  <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                  <?php $form = ActiveForm::begin([
                                // 'action' => ['create'],
                                'method' => 'get',
                                'id'=>'searchFormSaksiInternal', 
                                'options'=>['name'=>'searchFormSaksiInternal'],
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
                    $searchModel = new Was11Search();
                    $dataProviderSaskiInternal = $searchModel->searchInt(Yii::$app->request->queryParams);
                    ?>
                    <div id="w0" class="grid-view">
                   <?php Pjax::begin(['id' => 'MSaksi-internal-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiInternal','enablePushState' => false]) ?>
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderSaskiInternal,
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

                        ['label'=>'Nama Saksi Internal',
                         'format'=>'raw',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'value' => function ($data) {
                          $pecah1=explode('#',$data['nama_saksi_internal']);
                          $result ='';
                                  for ($i=0; $i < count($pecah1); $i++) { 
                                   
                                    $result .=$pecah1[$i].'<br>';
                                  }
                                  return $result; 
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
                                'contentOptions'=>['style'=>'text-align:center;'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) {
                                    $json=json_encode($data);
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneInt', 'json'=>$json];
                                    },
                            ],
                          
                        ],
                     
                ]); ?>
                <?php Pjax::end(); ?>
                </div>
                </div>

                <div class="tab-pane fade" id="saksi_eksternal">
                  <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                  <?php $form = ActiveForm::begin([
                                // 'action' => ['create'],
                                'method' => 'get',
                                'id'=>'searchFormSaksiEksternal', 
                                'options'=>['name'=>'searchFormSaksiEksternal'],
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
                                        <input type="text" name="carieks" class="form-control">
                                      <span class="input-group-btn">
                                          <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Saksi Eksternal"><i class="fa fa-search"> Cari </i></button>
                                      </span>
                                    </div>
                                </div>
                              </div>
                            </div>
                    <?php ActiveForm::end(); ?>

                    <?php 
                    $searchModelEks = new Was11Search();
                    $dataProviderSaskiEksternal = $searchModelEks->searchEks(Yii::$app->request->queryParams);
                    ?>
                    <div id="w1" class="grid-view">
                   <?php Pjax::begin(['id' => 'MSaksi-eksternal-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiEksternal','enablePushState' => false]) ?>
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderSaskiEksternal,
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

                        ['label'=>'Nama Saksi Eksternal',
                         'format'=>'raw',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'value' => function ($data) {
                          $pecah2=explode('#',$data['nama_saksi_eksternal']);
                          $result2 ='';
                                  for ($i=0; $i < count($pecah2); $i++) { 
                                    $result2 .=$pecah2[$i].'<br>';
                                  }
                                  return $data['nama_saksi_eksternal']; 
                                },
                        ],

                        ['label' => 'Alamat',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    return $data['alamat_saksi_eksternal']; 
                                  },
                              ],
                        
                         
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                                'contentOptions'=>['style'=>'text-align:center;'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) {
                                    $json=json_encode($data);
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneEk','json'=>$json];
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

</div>
<br />
<script type="text/javascript">
window.onload=function(){
   $('#cetak_was11_int,#ubah_was11_int, #hapus_was11_int').addClass('disabled');
   $('#cetak_was11_eks,#ubah_was11_eks, #hapus_was11_eks').addClass('disabled');
        /*internal*/        
        $(document).on('click', '#ubah_was11_int', function () {
          var data=JSON.parse($('.selection_oneInt:checked').attr('json'));
          location.href='/pengawasan/was11/update?id='+data.id_surat_was11+'&jns='+data.jenis_saksi;   
        });
        $(document).on('click', '#cetak_was11_int', function () {
          var data=JSON.parse($('.selection_oneInt:checked').attr('json'));
          location.href='/pengawasan/was11/cetakdocx?no_register='+data.no_register+'&id='+data.id_surat_was11+'&id_tingkat='+data.id_tingkat+'&id_kejati='+data.id_kejati+'&id_kejari='+data.id_kejari+'&id_cabjari='+data.id_cabjari;   
        });

      
      $('#hapus_was11_int').click(function(){
        var x=$('.selection_oneInt:checked').length;

        if(x<=0){
   //          var warna='black';
         
      // notifyHapus(warna);
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
                              //alert(checkValues);
                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/was11/delete',
                                    data:'id='+checkValues+'&jml='+x,
                                    success:function(data){
                                        //alert(data);
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



/*{"id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00",
"id_wilayah":1,"id_level1":6,"id_level2":8,"id_level3":2,"id_level4":1,
"no_register":"Reg00190","id_surat_was11":5,"no_was_11":"345",
"tgl_was_11":"2017-09-30","sifat_surat":1,"lampiran_was11":"qwe",
"perihal":"Bantuan penyampaian Surat panggilan saksi",
"upload_file":null,"kepada_was11":"qwe","di_was11":"qwe",
"nip_penandatangan":"195702141979011001","nama_penandatangan":"WIDODO SUPRIADI, 
S.H., M.M.","pangkat_penandatangan":"Jaksa Utama Madya","golongan_penandatangan":"IV\/d",
"jabatan_penandatangan":"Plh Inspektur I ","jbtn_penandatangan":"Inspektur II",
"created_by":6,"created_ip":"127.0.0.1","created_time":"2017-11-22 08:55:47",
"updated_by":null,"updated_ip":null,"updated_time":null,"id_sp_was":2,
"jenis_saksi":"Internal","nama_saksi_internal":"198005052007101001-GUNTUR TAULABI,
 S.H.#195805161977032001-ATI RADJA"}*/
 

        // $(document).on('click', '#hapus_was11_int', function () {
        //   var checkValues = $('.selection_oneInt:checked').map(function()
        //                         {
        //                             return $(this).attr('json');
        //                         }).get();
        //      var jml=$('.selection_oneInt:checked').length;
        //         // var pecah=checkValues.split(',');
        //         for (var i = 0; i<jml; i++) {
        //             var data=JSON.parse(checkValues[i]);
        //             $.ajax({
        //                 type:'POST',
        //                 url:'/pengawasan/was11/delete',
        //                 data:'id='+data.id_surat_was11+'&jml='+jml,
        //                 success:function(data){

        //                 }
        //                 });

        //         };
        // });

      // $(document).on('click', '#hapus_was11_eks', function () {
      //           var checkValues = $('.selection_oneEk:checked').map(function()
      //                                 {
      //                                     return $(this).attr('json');
      //                                 }).get();
      //              var jml=$('.selection_oneEk:checked').length;
      //                 // var pecah=checkValues.split(',');
      //                 for (var i = 0; i<jml; i++) {
      //                     var data=JSON.parse(checkValues[i]);
      //                     $.ajax({
        //                         type:'POST',
        //                         url:'/pengawasan/was11/delete',
        //                         data:'id='+data.id_surat_was11+'&jml='+jml,
        //                         success:function(data){

        //                         }
      //                         });

      //                 };
      //         });

        /*Eksternal*/
        $(document).on('click', '#ubah_was11_eks', function () {
          var data=JSON.parse($('.selection_oneEk:checked').attr('json'));
          location.href='/pengawasan/was11/update?id='+data.id_surat_was11+'&jns='+data.jenis_saksi;   
        });
        $(document).on('click', '#cetak_was11_eks', function () {
          var data=JSON.parse($('.selection_oneEk:checked').attr('json'));
          location.href='/pengawasan/was11/cetakdocx?no_register='+data.no_register+'&id='+data.id_surat_was11+'&id_tingkat='+data.id_tingkat+'&id_kejati='+data.id_kejati+'&id_kejari='+data.id_kejari+'&id_cabjari='+data.id_cabjari;   
        });
        
         $(document).on('click','#hapus_was11_eks',function(){  
             // alert('aaa');
                      var x=$('.selection_oneEk:checked').length;

                      if(x<=0){
                 //          var warna='black';
                       
                    // notifyHapus(warna);
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
                                            //alert(checkValues);
                                              $.ajax({
                                                  type:'POST',
                                                  url:'/pengawasan/was11/delete',
                                                  data:'id='+checkValues+'&jml='+x,
                                                  success:function(data){
                                                      //alert(data);
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
           $('.role').html('<a class="btn btn-primary btn-sm pull-right" id="cetak_was11_int"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" id="hapus_was11_int"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" id="ubah_was11_int"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11/create?jns=Internal"><i class="glyphicon glyphicon-plus"> </i> WAS-11(saksi internal)</a>');
              
              $('.selection_oneInt').prop('checked',false);
              $('.select-on-check-all').prop('checked',false); 
              $('tbody tr').removeClass('danger');
        });

        $(document).on('click', '#Msaksi_eksternal', function () {
           $('.role').html('<a class="btn btn-primary btn-sm pull-right" id="cetak_was11_eks"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" id="hapus_was11_eks"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" id="ubah_was11_eks"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;'+
              '<a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was11/create?jns=Eksternal"><i class="glyphicon glyphicon-plus"> </i> WAS-11(saksi eksternal)</a>');
        
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
            if(c==true){
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

$(document).on("dblclick", "#internal tr", function(e) {
              // var nilai=$('.selection_oneInt').val();
              // location.href='/pengawasan/was11/update?jns=Internal&id='+nilai;
              var data=JSON.parse($('.selection_oneInt').attr('json'));
              location.href='/pengawasan/was11/update?id='+data.id_surat_was11+'&jns='+data.jenis_saksi;
    });

    $(document).on("dblclick", "#eksternal tr", function(e) {
              var data=JSON.parse($('.selection_oneEk').attr('json'));
              location.href='/pengawasan/was11/update?id='+data.id_surat_was11+'&jns='+data.jenis_saksi; 
              // var nilai=$('.selection_oneEk').val();
              // location.href='/pengawasan/was11/update?jns=Eksternal&id='+nilai;
    });

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





