<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
// use kartik\grid\DataColumn;
// use yii\helpers\Url;
// use yii\web\View;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LapduSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//
$this->title = 'WAS - 1';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lapdu-index">

    <h4><?//= Html::encode($this->title) ?></h4>
    <br><?//= Html::encode($this->title) ?></br>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
        <div class="role-index">
         <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_was1"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_was1"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="cetak"><i class="glyphicon glyphicon-pencil">  </i> Cetak</a>&nbsp;
              <!-- <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/> -->
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was1/create?id=0"><i class="glyphicon glyphicon-plus"> </i> WAS-1</a>
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
        <legend class="group-border">Daftar WAS-1</legend>
    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
         // 'layout' => "{items}\n{pager}",
        'columns' => [
            ['header'=>'No',
			'class' => 'yii\grid\SerialColumn'],

            // 'header'=>'No'],
			
			/* ['label' => 'Dari -> Ke',
                      'value' => function ($data) {
						if ($data['id_level_was1']=='1'){
							return  'Pemeriksa -> Irmud';
						}elseif ($data['id_level_was1']=='2'){
							return 'Irmud -> Inspektur';
						}elseif ($data['id_level_was1']=='3'){
							return 'Inspektur -> JAMWAS';
						}
                         
                      },
                  ], */
			
            //'no_register',
            // ['label' => 'Register',
            //           'value' => function ($data) {
            //             return $data['satker_terlapor_awal']; 
            //           },
            //       ],
			
			 ['label' => 'No Surat',
                      'value' => function ($data) {
                         return $data['no_surat']; 
                      },
                  ],
			
			['label' => 'Tanggal Surat',
                      'value' => function ($data) {
                         return date("d-m-Y",strtotime($data['was1_tgl_surat'])); 
                      },
                  ],
			
			['label' => 'Dari',
                      'value' => function ($data) {
                         return $data['was1_dari']; 
                      },
                  ],
				  
			['label' => 'Kepada',
                      'value' => function ($data) {
                         return $data['was1_kepada']; 
                      },
                  ],
			['label' => 'Saran',
                      'value' => function ($data) {
                         return $data['isi_saran_was1']; 
                      },
                  ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                       // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                    // you may configure additional properties here

                       'checkboxOptions' => function ($data) {
                        $tmp=json_encode($data);  
                        return ['value' => $data['no_register'],'rel'=>$tmp,'id_level_was1'=>$data['id_level_was1'],'id_was1'=>$data['id_was1'],'id_tingkat'=>$data['id_tingkat'],'id_kejati'=>$data['id_kejati'],'id_kejari'=>$data['id_kejari'],'id_cabjari'=>$data['id_cabjari'],'class'=>'selection_one'];
                        },


                ],
                // manual checkbox
            // [
            // 'label' =>'',
            // 'format' => 'raw',
            // 'value' => function($data)
            // {
            //     return Html::checkbox('chk1', false, ["class" => "chk1",'value' => $data['no_register']]);
            // },
            // ],


            /*manual button*/
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{Tampil}{Edit}{Hapus}',
            //     'buttons' => [
            //         'Tampil' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/view?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-eye-open']);
                        
            //         },
            //         'Edit' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/update?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-pencil']);
                        
            //         },
            //         'Hapus' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/delete?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-trash']);
                        
            //         },
            //     ],
            // ],
            ],
         
    ]); ?>
</fieldset>
</div>

</div>

<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
{
  vertical-align:top;
  
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td
{
  
  text-align:center;
}
.summary{
	Display:none;
}
tr.click-row {
  background-color: #81bcf8;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tr').on('click', function() {
//       // $('.table-bordered tr').not(this).removeClass('click-row')
//       $(this).toggleClass('click-row');
//       // $(this).find('.selection_one').attr('checked','checked');
//       // $(this).find('.selection_one').prop('checked',false);
      
//       // var x=$(this).find('.selection_one:checked').attr('checked');
//       // if(x!=''){
//       //   $(this).toggleClass('click-row');
//       //   // $(this).find('.selection_one').attr('checked','checked');
//       // }else {
//       //   // $(this).removeClass('click-row');
//       //   $(this).find('.selection_one').attr('checked',false);
//       // }
//       // var z=$(this).attr('class');
//       // if(z=='hover'){
//       //  $(this).find('.selection_one').prop('checked',false);
//       //   $("#ubah_was1").addClass("disabled");
//       //   $("#hapus_was1").addClass("disabled");
//       // }else{
//       //   $(this).find('.selection_one').prop('checked',true);
//       //   $("#ubah_was1").removeClass("disabled");
//       //   $("#hapus_was1").removeClass("disabled");
//       // }
//       // alert(z);
// });

    $("#ubah_was1").addClass("disabled");
    $("#cetak").addClass("disabled");
    $("#hapus_was1").addClass("disabled");
    /*permintaan pa putut*/
   
         $('.select-on-check-all').change(function() {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
        $('.selection_one').change(function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_was1, #hapus_was1, #cetak').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_was1').removeClass('disabled');
               $('#ubah_was1').addClass('disabled');
               $('#cetak').addClass('disabled');
            } else{
               $('#ubah_was1, #hapus_was1, #cetak').addClass('disabled');
            }
    }

    $('#ubah_was1').click(function(){
        
        var x=$(".selection_one:checked").length;
        var link=$(".selection_one:checked").val();
        var lv=$(".selection_one:checked").attr('id_level_was1');
        var id_tingkat=$(".selection_one:checked").attr('id_tingkat');
        var id_kejati=$(".selection_one:checked").attr('id_kejati');
        var id_kejari=$(".selection_one:checked").attr('id_kejari');
		    var id_cabjari=$(".selection_one:checked").attr('id_cabjari');
            
        location.href='/pengawasan/was1/update?id='+link+'&option='+lv+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;   
    });

        
    $('#hapus_was1').click(function(){
        var x=$(".selection_one:checked").length;
         // var link=$(".chk1:checked").val();
         //alert(x);
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
                                    return $(this).attr('id_level_was1');
                                    //return $(this).val();
                                }).get();
                             //alert(checkValues);

                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/was1/delete',
                                    data:'id='+checkValues+'&jml='+x,
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

$('tr').dblclick(function(){
  var id = $(this).find('.selection_one').val();
  var lv = $(this).find('.selection_one').attr('id_level_was1');
  var id_tingkat=$(this).find(".selection_one").attr('id_tingkat');
  var id_kejati=$(this).find(".selection_one").attr('id_kejati');
  var id_kejari=$(this).find(".selection_one").attr('id_kejari');
  var id_cabjari=$(this).find(".selection_one").attr('id_cabjari');
  
   //alert(lv);
         location.href='/pengawasan/was1/update?id='+id+'&option='+lv+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;   
  //do something with id
});

  $('#cetak').click(function(){
        var data  =JSON.parse($(".selection_one:checked").attr('rel'));

        var id        =$(".selection_one:checked").val();
        var option    =$(".selection_one:checked").attr('id_level_was1');
        var tgl_cetak =data.tgl_cetak;
        var tempat    ="Jakarta";
        //var 
       // alert(tempat);


        location.href='/pengawasan/was1/cetak-index?id='+id+'&option='+option+'&tempat='+tempat+'&tglcetak='+tgl_cetak;   
    });
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


