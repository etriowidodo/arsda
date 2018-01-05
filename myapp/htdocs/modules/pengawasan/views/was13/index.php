<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\modules\pengawasan\models\Was13Search;

// use kartik\grid\GridView;
//use yii\bootstrap\Modal;
//use app\modules\pengawasan\models\Was11;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was13Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was13';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
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
                              <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Was-12"><i class="fa fa-search"> Cari </i></button>
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
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was13/create"><i class="glyphicon glyphicon-plus"> </i> WAS-13</a>
        </div>
    </p>

    <?php 
        $searchModel = new Was13Search();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        ?>
        <div id="w0" class="grid-view">
        <?php Pjax::begin(['id' => 'Was12-grid', 'timeout' => false,'formSelector' => '#searchFormWas13','enablePushState' => false]) ?>

    <? echo GridView::widget([
      //  'id' => 'was_13',
      'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_surat'].'.'.$model['id_was13']];
            },
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['header'=>'No',
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
                            return Html::a('<i class="fa fa-file-image-o"></i>', 'viewpdf?id_was13='.$data['id_was13'].'&id_surat='.$data['id_surat'], array('target'=>'_blank'));
							}else{
							return Html::a('<i class="fa fa-file-pdf-o"></i>', 'viewpdf?id_was13='.$data['id_was13'].'&id_surat='.$data['id_surat'], array('target'=>'_blank'));
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
                        return ['value' =>$data['id_was13'] ,'class'=>'checkbox-row','json'=>$json];
					 },
                ],

        ],
        // 'export' => false,
        //     'pjax' => true,
        //     'responsive'=>true,
        //     'hover'=>true,
    ]); ?>

</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

         $("#ubah_was13").click(function(){
            var cek = $('.checkbox-row:checked').length;
            var data= JSON.parse($('.checkbox-row:checked').attr('json'));
            if(cek<=0 || cek >=2){
               bootbox.alert({ 
                  size: "small",
                  // title: "Your Title",
                  message: "Harap Pilih Satu data saja!", 
                  callback: function(){ /* your callback code */ }
                });
            }else{
            location.href='/pengawasan/was13/update?id='+data.id_was13+'&id_surat='+data.id_surat;
            }
        });

     $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            if(c==true){
                $('tbody tr').addClass('danger');
                $('#ubah_was13').addClass("disabled");
                $('#cetak_was13').addClass("disabled");
            }else{
                $('tbody tr').removeClass('danger');
                $('#ubah_was13').removeClass("disabled");
                $('#cetak_was13').removeClass("disabled");
            }
            $('.checkbox-row').prop('checked',c);
            var x=$('.checkbox-row:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.checkbox-row',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.checkbox-row:checked').length;
            if(x<=0 || x >=2){
               $('#ubah_was13').addClass("disabled");
               $('#cetak_was13').addClass("disabled");
            }else{
               $('#ubah_was13').removeClass("disabled");
               $('#cetak_was13').removeClass("disabled");
            }
            ConditionOfButtonTr(x);
        });
      
  //   $('td').css('cursor', 'pointer');
    //  $('td').dblclick(function (e) {
    //     var id = $(this).closest('tr').data('id');
    //     var url = window.location.protocol + "//" + window.location.host + "/pengawasan/was13/update?id="+id;
    //     $(location).attr('href',url);
    // });



        $("#cetak_was13").click(function(){
            var cek = $('.checkbox-row:checked').length;
            var link=JSON.parse($('.checkbox-row:checked').attr('json'));
            // var res = link.split(".");
			//alert(res[1]); exit();
            if(cek<=0 || cek >=2){
                bootbox.alert({ 
                  size: "small",
                  
                  message: "Harap Pilih Satu data saja!", 
                  callback: function(){ /* your callback code */ }
                });
            }else{
            location.href='/pengawasan/was13/cetakwas?id='+link.id_was13+'&id_tingkat='+link.id_tingkat+'&id_kejati='+link.id_kejati+'&id_kejari='+link.id_kejari+'&id_cabjari='+link.id_cabjari+'&no_register='+link.no_register;
            }
        });

        $("#hapus_was13").click(function(){
         var cek = $('.checkbox-row:checked').length;
        
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
                                var checkValues = $('.checkbox-row:checked').map(function()
                                    {
                                        return $(this).val();
                                    }).get();
								$.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was13/delete',
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

      $(document).ready(function(){ 

          $('tr').dblclick(function(){
            //var data= JSON.parse($('.checkbox-row:checked').attr('json'));
             var dat = $(this).find('.checkbox-row').attr('json');
             var data= JSON.parse(dat);
             location.href='/pengawasan/was13/update?id='+data.id_was13+'&id_surat='+data.id_surat;
     });
    });
</script>
