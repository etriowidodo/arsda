<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\pengawasan\models\BaWas4InspeksiSearch;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BA.WAS-4 Inspeksi SURAT PERNYATAAN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ba-was4-inspeksi-index">

    <h4><?php ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin([
            // 'action' => ['create'],
            'method' => 'get',
            'id'=>'searchFormBawas4', 
            'options'=>['name'=>'searchFormBawas4'],
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
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="cetak_bawas4"><i class="fa fa-print"></i>  Cetak</a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="hapus_bawas4"><i class="glyphicon glyphicon-trash"></i>  Hapus</a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_bawas4"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/ba-was4-inspeksi/create"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </div>
    </p>
<style type="text/css">
    fieldset.group-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }
    legend.group-border {
        width:inherit; /* Or auto */
        padding:0 10px; /* To give a bit of padding on the left and right */
        border-bottom:none;
        font-size: 14px;
    }
</style>
    <fieldset class="group-border">
        <legend class="group-border">Daftar BA.WAS-4 Inspeksi</legend>
    <?php 
      $searchModel = new BaWas4InspeksiSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    ?>
    <?php Pjax::begin(['id' => 'Was12-grid', 'timeout' => false,'formSelector' => '#searchFormBawas4','enablePushState' => false]) ?>
    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-striped table-bordered table-hover','id'=>'tabel'],
         // 'rowOptions'=>['class'=>'text-center aksinya'],
        'columns' => [
             ['header'=>'No',
              'headerOptions'=>['style'=>'text-align:center;'],
              'contentOptions'=>['style'=>'text-align:center;'],
              'class' => 'yii\grid\SerialColumn'],
            
             ['label' => 'Tanggal',
                      'value' => function ($data) {
                         return date('d-m-Y',strtotime($data['tanggal_ba_was_4'])); 
                      },
                  ],
            
            ['label' => 'Nama',
                      'value' => function ($data) {
                         return $data['nama_saksi_eksternal']; 
                      },
                  ],
            

                  ['label' => 'Alamat',
                      'value' => function ($data) {
                         return $data['alamat_saksi_eksternal']; 
                      },
                  ],
                  
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'contentOptions'=>['class'=>' aksinya'],
                    // you may configure additional properties here
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_ba_was4'],'class'=>'checkbox-row'];
                        },


                ],
            ],
         
    ]); ?>
    <?php pjax::end();?>
</fieldset>
</div>
<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
</style>
<script type="text/javascript">

window.onload=function(){
        $('#cetak_bawas4,#ubah_bawas4, #hapus_bawas4').addClass('disabled');
        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
             if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            // $('.selection_one').prop('checked',c);
            var x=$('.checkbox-row:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.checkbox-row',function() {
            var c = this.checked ? '#f00' : '#09f';
           //  alert(c);
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x =$('.checkbox-row:checked').length;
            ConditionOfButton(x);
        });

        function ConditionOfButton(n){
                if(n == 1){
                   $('#cetak_bawas4,#ubah_bawas4, #hapus_bawas4').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_bawas4').removeClass('disabled');
                   $('#cetak_bawas4,#ubah_bawas4').addClass('disabled');
                } else{
                   $('#cetak_bawas4,#ubah_bawas4, #hapus_bawas4').addClass('disabled');
                }
        }

        $(document).on('click','#ubah_bawas4',function(){
            var data=JSON.parse($('.checkbox-row:checked').val());
           // alert(data);
            location.href='/pengawasan/ba-was4-inspeksi/update?id='+data;   
        });


         $('#hapus_bawas4').click(function(){
        var x=$(".checkbox-row:checked").length;
         // var link=$(".chk1:checked").val();
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
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.checkbox-row:checked').map(function()
                                {
                                    return $(this).val();
                                }).get();
                             //alert(checkValues);
                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/ba-was4-inspeksi/delete',
                                    data:'id='+checkValues+'&jml='+x,
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


        $(document).on('click', '#cetak_bawas4', function () {
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
          //alert(data.id_ba_was4);
          location.href='/pengawasan/ba-was4-inspeksi/cetak?id='+link;
        });
    }                       

       // $('tr').dblclick(function(){
        $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.checkbox-row').val();
          // alert(id);
                 location.href='/pengawasan/ba-was4-inspeksi/update?id='+id;   
          //do something with id
        });






function notify(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Merubah data harus memilih satu data,Harap pilih satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }

function notifyHapus(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Menghapus data harus memilih salah data,Harap pilih salah satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
</script>