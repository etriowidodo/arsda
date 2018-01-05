<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was11;
use app\modules\pengawasan\models\Was12Search;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'DAFTAR WAS-12';
$this->subtitle = 'Bantuan Penyampaian Surat Panggilan Terlapor' ;//'SURAT BANTUAN UNTUK MELAKUKAN PEMANGGILAN TERHADAP TERLAPOR';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>

<div class="lapdu-index" style="padding-top:30px">
     <h4><?php ?></h4>
    <?php//  echo $this->render('_search', ['model' => $searchModel]); ?>
    
        <?php $form = ActiveForm::begin([
                    // 'action' => ['create'],
                    'method' => 'get',
                    'id'=>'searchFormWas12', 
                    'options'=>['name'=>'searchFormWas12'],
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
         <div class="btn-toolbar">
                <a class="btn btn-primary btn-sm pull-right" id="btnCetak"><i class="glyphicon glyphicon-print"> </i> Cetak </a>&nbsp;
                <a class="btn btn-primary btn-sm pull-right" id="btnHapus"><i class="glyphicon glyphicon-trash"> </i> Hapus </a>&nbsp;
                <a class="btn btn-primary btn-sm pull-right" id="btnUbah"><i class="glyphicon glyphicon-pencil"></i>  Ubah </a>&nbsp;
                <a class="btn btn-primary btn-sm pull-right" id="" href="/pengawasan/was12/create"><i class="glyphicon glyphicon-plus">  </i> Tambah</a>&nbsp;
         </div>
    </p>

        <?php 
        $searchModel = new Was12Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        ?>
        <div id="w0" class="grid-view">
        <?php Pjax::begin(['id' => 'Was12-grid', 'timeout' => false,'formSelector' => '#searchFormWas12','enablePushState' => false]) ?>
        <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'No WAS-12',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'value' => function ($data) {
                     return $data['no_surat']; 
                  },    
                ],
 
                ['label'=>'Nama Atasan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'value' => function ($data) {
                     return $data['kepada_was12']; 
                   },
                ], 


               ['class' => 'yii\grid\CheckboxColumn',
                'headerOptions'=>['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center; width:5%'],
                           'checkboxOptions' => function ($data) {
                            $result=json_encode($data);
                            return [ 'value'=>$data['id_was_12'],'json'=>$result,'class'=>'selection_one'];
                            },
                    ],
                 ],   

        ]); ?>
        <?php Pjax::end(); ?>
</div>
<script type="text/javascript">
window.onload=function(){

    $('#btnCetak,#btnUbah, #btnHapus').addClass('disabled');

        $(document).on('click','#btnUbah',function() {
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            location.href='/pengawasan/was12/update?id='+data.id_was_12;   
        });
        $(document).on('click','#btnCetak',function() {
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            location.href='/pengawasan/was12/cetakdocx?no_register='+data.no_register+'&id='+data.id_was_12+'&id_tingkat='+data.id_tingkat+'&id_kejati='+data.id_kejati+'&id_kejari='+data.id_kejari+'&id_cabjari='+data.id_cabjari;   
        });

        $('#btnHapus').click(function(){
        var x=$('.selection_one:checked').length;

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
                                var checkValues = $('.selection_one:checked').map(function()
                                {
                                    return $(this).val();
                                }).get();
                              //alert(checkValues);
                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/was12/hapus',
                                    data:'id_was12='+checkValues+'&jml='+x,
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

        // $(document).on('click','#btnHapus',function() {
        //     var jml=$('.selection_one:checked').length;
        //     var checkValues = $('.selection_one:checked').map(function()
        //                         {
        //                             return $(this).val();
        //                         }).get();
        //     $.ajax({
        //             type:'POST',
        //             url:'/pengawasan/was12/hapus',
        //             data:'id_was12='+checkValues+'&jml='+jml,
        //             success:function(data){
        //                 // $('#w1').html(data);
        //                 alert(data);
        //             }
        //             });
        // });


        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.selection_one:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_one:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#btnCetak,#btnUbah, #btnHapus').removeClass('disabled');
                } else if(n > 1){
                   $('#btnHapus').removeClass('disabled');
                   $('#btnCetak,#btnUbah').addClass('disabled');
                } else{
                   $('#btnCetak,#btnUbah, #btnHapus').addClass('disabled');
                }
        }
}

 $(document).ready(function(){ 

          $('tr').dblclick(function(){
            var data=JSON.parse($('.selection_one').attr('json'));
           //  var data=JSON.parse($('.selection_one').attr('json'));
            location.href='/pengawasan/was12/update?id='+data.id_was_12;  
        });

     });
</script>
