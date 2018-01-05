<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\pengawasan\models\PemeriksaBawas3;
use yii\db\Query;
use yii\db\Command;
use yii\widgets\ActiveForm; 
use app\modules\pengawasan\models\BaWas3Search;
use yii\widgets\Pjax;

$this->title = 'Daftar BA.WAS-3';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
// $this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<?php// print_r($_SESSION); ?>
<div class="ba-was3-index">

    <h4><?php ?></h4><br />
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin([
            // 'action' => ['create'],
            'method' => 'get',
            'id'=>'searchFormBawas3', 
            'options'=>['name'=>'searchFormBawas3'],
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
			  <a class="btn btn-primary btn-sm pull-right" id="cetak_bawas3"><i class="glyphicon glyphicon-print"> </i> Cetak </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_bawas3"><i class="glyphicon glyphicon-trash"> </i> Hapus </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_bawas3"><i class="glyphicon glyphicon-pencil"> </i> Ubah </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="" href="/pengawasan/ba-was3/create"><i class="glyphicon glyphicon-plus"> </i> BA.WAS-3</a>
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
        <legend class="group-border">Daftar BA.WAS-3</legend>

    <?php 
      $searchModel = new BaWas3Search();
      $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
    ?>
    <div id="w0" class="grid-view">
    <?php Pjax::begin(['id' => 'BaWas3-grid', 'timeout' => false,'formSelector' => '#searchFormBawas3','enablePushState' => false]) ?>
 
    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-striped table-bordered table-hover','id'=>'tabel','data-id' => $data['id_ba_was_3']],
         // 'layout' => "{items}\n{pager}",
        'columns' => [
                 ['header'=>'No',
                 'class' => 'yii\grid\SerialColumn'],
			
			           ['label' => 'Tanggal',
                      'value' => function ($data) {
                         return date('d-m-Y',strtotime($data['tanggal_ba_was3'])); 
                      },
                  ],
			
			           ['label' => 'Yang Dimintai Keterangan',
                      'value' => function ($data) {
                         return $data['nama_dimintai_keterangan']; 
                      },
                  ],
			
          			['label' => 'Yang Meminta Keterangan',
                'format'=>'raw',
                                'value' => function ($data) {
          				
          				return $data['nama_pemeriksa'];
                                },
                            ],

				        ['label' => 'Keterangan',
                      'value' => function ($data) {
                         return $data['keterangan']; 
                      },
                  ],
				  
                [
                    'class' => 'yii\grid\CheckboxColumn',
                       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
                    // you may configure additional properties here
						           'contentOptions'=>['style'=>'width: 9px;'],
                       'checkboxOptions' => function ($data) {
                        $result=json_encode($data);
                        return ['value' => $data['id_ba_was3'],'json'=>$result,'class'=>'checkbox-row'];           
                        },


                ],
            ],
         
    ]); ?>
</fieldset>
</div>
</div>
<!-- <style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
</style> -->
<script type="text/javascript">
$(document).ready(function(){ 
   
  $(document).on('change','.select-on-check-all',function() {
      var c = this.checked ? true : false;
      if(c==true){
          $('tbody tr').addClass('danger'); 
          // $('#hapus_bawas3').removeClass("disabled");
          // $('#cetak_bawas3').addClass("disabled");
          // $('#ubah_bawas3').addClass("disabled");
      }else{
          $('tbody tr').removeClass('danger'); 
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
      ConditionOfButtonTr(x);
  });

  function ConditionOfButtonTr(tx){
    if(tx==0){ 
        $('#hapus_bawas3').addClass("disabled"); 
        $('#cetak_bawas3').addClass("disabled");
        $('#ubah_bawas3').addClass("disabled"); 
    }

    if(tx>1){ 
        $('#hapus_bawas3').removeClass("disabled");   
        $('#cetak_bawas3').addClass("disabled");
        $('#ubah_bawas3').addClass("disabled"); 
    }

    if(tx==1){ 
        $('#hapus_bawas3').removeClass("disabled"); 
        $('#cetak_bawas3').removeClass("disabled");
        $('#ubah_bawas3').removeClass("disabled"); 
    }
  }

// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tr').on('click', function() {
//       $(this).toggleClass('click-row');
//       var z=$(this).attr('class');
//       if(z=='hover'){
//        $(this).find('.checkbox-row').prop('checked',false);
//         $("#ubah_bawas3").addClass("disabled");
//         $("#hapus_bawas3").addClass("disabled");
// 		$("#cetak_bawas3").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_bawas3").removeClass("disabled");
//         $("#hapus_bawas3").removeClass("disabled");
// 		$("#cetak_bawas3").removeClass("disabled");
//       }
//       // alert(z);
// });

    $("#ubah_bawas3").addClass("disabled");
    $("#hapus_bawas3").addClass("disabled");
	$("#cetak_bawas3").addClass("disabled");
    /*permintaan pa putut*/
    $(".checkbox-row").click(function(){
            var x=$(".checkbox-row:checked").length;
            if(x>0){
         $("#ubah_bawas3").removeClass("disabled");
         $("#hapus_bawas3").removeClass("disabled");
		 $("#cetak_bawas3").removeClass("disabled");
                
        }else{
          $("#ubah_bawas3").addClass("disabled");
          $("#hapus_bawas3").addClass("disabled");
		  $("#cetak_bawas3").addClass("disabled");		  
            }
    // alert(x);
    });

    $('#ubah_bawas3').click(function(){
        
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var check=JSON.parse($('.checkbox-row:checked').attr('json'));
          // alert(id); 
       if(x>=2 || x<=0){
            var warna='black';
            bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			//notify(warna);
         return false
         }else{
            
        location.href='/pengawasan/ba-was3/update?id='+check.id_ba_was3+'&id2='+check.id_terlapor_saksi;
         }
    });

	$('#cetak_bawas3').click(function(){
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var check=JSON.parse($('.checkbox-row:checked').attr('json'));
        
        if(check.keterangan=='Terlapor'){
          location.href='/pengawasan/ba-was3/cetak?id='+check.id_ba_was3;
        }else if(check.keterangan=='Saksi Internal'){
          location.href='/pengawasan/ba-was3/cetak_int?id='+check.id_ba_was3;
        }else if(check.keterangan=='Saksi Eksternal'){
          location.href='/pengawasan/ba-was3/cetak_eks?id='+check.id_ba_was3;
        }
        
    });
        
    $('#hapus_bawas3').click(function(){
        var x=$(".checkbox-row:checked").length;
         // var link=$(".chk1:checked").val();
        var data= JSON.parse($(".checkbox-row:checked").attr('json'));
        var id = data.id_ba_was3;
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
                         //   alert(checkValues);
                             
                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/ba-was3/hapus',
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
});

$(document).ready(function(){

     $('tr').dblclick(function(){
      var id = $(this).find('.checkbox-row').val();
      var data= JSON.parse($(".checkbox-row").attr('json'));
      var id2 = data.id_terlapor_saksi;
      // alert(id);
             location.href='/pengawasan/ba-was3/update?id='+id+'&id2='+id2;   
      //do something with id
    });

 });

// $('tr').dblclick(function(){
//   var id = $(this).find('.checkbox-row').val();
//   var data= JSON.parse($(".checkbox-row:checked").attr('json'));
//   var id2 = data.id_terlapor_saksi;
//   // alert(id);
//          location.href='/pengawasan/ba-was3/update?id='+id+'&id2='+id2;   
//   //do something with id
// });

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


