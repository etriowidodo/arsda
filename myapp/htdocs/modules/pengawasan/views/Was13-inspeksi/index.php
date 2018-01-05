<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was13InspeksiSearch;

//use kartik\grid\GridView;
//use yii\bootstrap\Modal;
//use app\modules\pengawasan\models\Was11;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was13Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was13 Inspeksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was13-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin([
            // 'action' => ['create'],
            'method' => 'get',
            'id'=>'searchFormWas13', 
            'options'=>['name'=>'searchFormWas13'],
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
                      <button class="btn btn-default browse" type="submit" data-placement="left" title="Pencarian"><i class="fa fa-search"> Cari </i></button>
                  </span>
                </div>
            </div>
          </div>
        </div>
    <?php ActiveForm::end(); ?>
    <p>
        <?//= Html::a('Create Was13', ['create'], ['class' => 'btn btn-success']) ?>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was13"><i class="glyphicon glyphicon-print">  </i> Cetak</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_was13"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_was13"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was13-inspeksi/create"><i class="glyphicon glyphicon-plus"> </i> WAS-13 Inspeksi</a>
        </div>
    </p>

    <?php 
      $searchModel = new Was13InspeksiSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    ?>
    <?php Pjax::begin(['id' => 'Was12-grid', 'timeout' => false,'formSelector' => '#searchFormWas13','enablePushState' => false]) ?>

    <? echo GridView::widget([
      //  'id' => 'was_13',
      // 'rowOptions'   => function ($model, $key, $index, $grid) {
      //           return ['data-id' => $model['id_was13']];
      //       },
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],

            ['label' => 'Nama Surat',
            'format' => 'raw',
                      'value' => function ($data) {
                        return  $data['nama_surat'];
                      },
                  ],

            ['label' => 'Nama Pengirim',
            'format' => 'raw',
                      'value' => function ($data) {
                        return  $data['nama_pengirim'];
                      },
                  ],

            ['label' => 'Nama Penerima',
            'format' => 'raw',
                      'value' => function ($data) {
                        return  $data['nama_penerima'];
                      },
                  ],

            ['label' => 'Tanggal Dikirim',
            'format' => 'raw',
                      'value' => function ($data) {
                        return  date("d-m-Y",strtotime($data['tanggal_dikirim']));
                      },
                  ],

            ['label' => 'Tanggal Diterima',
            'format' => 'raw',
                      'value' => function ($data) {
                        return  date("d-m-Y",strtotime($data['tanggal_diterima']));
                      },
                  ],

            ['label' => 'File Was13',
            // 'format' => 'url',
            'format' => 'raw',
                      'value' => function ($data) {
                        // $basepath = str_replace('\\', '/', Yii::$app->basePath).'/web/';
                        //     $path = str_replace($basepath, '', $data->file);
                        if($data['was13_file']!=''){
              if (substr($data['was13_file'],-3)!='pdf'){
                            return Html::a('<i class="fa fa-file-image-o"></i>', 'viewpdf?id='.$data['id_was13'], array('target'=>'_blank'));
              }else{
              return Html::a('<i class="fa fa-file-pdf-o"></i>', 'viewpdf?id='.$data['id_was13'], array('target'=>'_blank'));
              }
                        }else{
                            return false;
                        }
                         // Yii::$app->params['uploadPath'] . 'was_13/'.$data['was13_file']
                      },
                  ],

            ['class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function ($data) {
                        $json=json_encode($data);
                       // print_r($data['id_was9']);
                        if($data['id_was9'] <> ''){
                            $id_surat = $data['id_was9'];
                        }else if($data['id_was10'] <> ''){
                          $id_surat = $data['id_was10'];
                        }else if($data['id_was11']){
                          $id_surat = $data['id_was11'];
                        }else if($data['id_was12'] <> ''){
                          $id_surat = $data['id_was12'];
                        }

                        return ['value' =>$data['id_was13'],'class'=>'selection_on','json'=>$json , 'id_surat'=>$data['id_was13'].'#'.$id_surat];
           },
                ],

        ],
        // //'export' => false,
        //     'pjax' => true,
        //     'responsive'=>true,
        //     'hover'=>true,
    ]); ?>
    <?php pjax::end(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){

         $("#ubah_was13").click(function(){
            var cek = $('.selection_on:checked').length;
            var data= JSON.parse($('.selection_on:checked').attr('json'));
            if(cek<=0 || cek >=2){
               bootbox.alert({ 
                  size: "small",
                  // title: "Your Title",
                  message: "Harap Pilih Satu data saja!", 
                  callback: function(){ /* your callback code */ }
                });
            }else{
            location.href='/pengawasan/was13-inspeksi/update?id='+data.id_was13+'&nm_surat='+data.nama_surat;
            }
        });
      
    //  $('td').css('cursor', 'pointer');
    //  $('td').dblclick(function (e) {
    //     var id = $(this).closest('tr').data('id');
    //     var url = window.location.protocol + "//" + window.location.host + "/pengawasan/was13/update?id="+id;
    //     $(location).attr('href',url);
    // });

        $("#cetak_was13").click(function(){
            var cek = $('.selection_on:checked').length;
            var link=$(".selection_on:checked").val();
            var data=JSON.parse($(".selection_on:checked").attr('json'));
      //alert(res[1]); exit();
            if(cek<=0 || cek >=2){
                bootbox.alert({ 
                  size: "small",
                  
                  message: "Harap Pilih Satu data saja!", 
                  callback: function(){ /* your callback code */ }
                });
            }else{
            location.href='/pengawasan/was13-inspeksi/cetakwas?id='+data.id_was13+'&id_tingkat='+data.id_tingkat+'&id_kejati='+data.id_kejati+'&id_kejari='+data.id_kejari+'&id_cabjari='+data.id_cabjari+'&no_register='+data.no_register;
            }
        });

        $("#hapus_was13").click(function(){
         var cek = $('.selection_on:checked').length;

      //  alert(cek);
        if(cek<=0){
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
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.selection_on:checked').map(function()
                                    {
                                        return $(this).attr('id_surat');
                                    }).get();
                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was13-inspeksi/delete',
                                        data:'id='+checkValues+'&jml='+cek,
                                        success:function(data){
                                             alert(data);
                                        }
                                        });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        
        }  
               
        });
    });
    window.onload=function(){
      $('#cetak_was13, #ubah_was13, #hapus_was13').addClass('disabled');

      $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_on:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.selection_on',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_on:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#cetak_was13, #ubah_was13, #hapus_was13').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was13').removeClass('disabled');
                   $('#cetak_was13,#ubah_was13').addClass('disabled');
                } else{
                   $('#cetak_was13,#ubah_was13, #hapus_was13').addClass('disabled');
                }
        }
    }
</script>
