<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->

<div class="modal-content" style="width: 500px;margin: 30px auto;">
    <div class="modal-header">
        Data Tersangka

    </div>


    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;

            echo GridView::widget([
                'id'=>'id_tersangka-grid',
                'dataProvider'=> $dataProvider2,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'label' => 'Nama',
                      'attribute' => 'nama',
                      'contentOptions' => function ($model, $key, $index, $grid){
                            return ['data-id'=>json_encode($model)];

                        }
                    ],
                    [
                      'label' => 'Tempat Lahir',
                      'attribute' => 'tmpt_lahir',
                      'contentOptions' => function ($model, $key, $index, $grid){
                            return ['data-id'=>json_encode($model)];
                        }
                    ]
                ],
                'export' => false,
                'pjax' => true,
                'responsive'=>true,
                'hover'=>true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-book"></i>',
                ],
            ]);
            ?>
    <div class="modal-footer">
            <a class="btn btn-danger cancel" >Batal</a>
    </div>

    </div>
<?php


//var_dump($dataProvider2);
$this->registerJs(\yii\web\View::POS_BEGIN);

        $js = <<< JS


   //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
     function editTersangkaPt()
     {
         $('.close').hide();
         $('.panel-heading').hide();
         $('.kv-panel-before').hide();

         var text = $('.panel-heading').text();
         $('#daftar').html(text);
     }

     $(document).ajaxSuccess(function(){

      if($('#id_tersangka-grid-filters td').length>1)
      {
      $('#id_tersangka-grid-filters td').first().remove();
      $('#id_tersangka-grid-filters td').last().remove();
      $('#id_tersangka-grid-filters td').first().attr('colspan',3);
      }

      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka');
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         editTersangkaPt();
     });


$(document).ready(function(){

  $('.cancel').click(function()

    {
      $('#m_tersangka').modal('hide');
      $("body").addClass('modal-open');

    });

    // $('#m_tersangka').on('hidden.bs.modal', function () {
    //           $("#m_tersangka").css('overflow-y','scroll');
    //           $("body").css('overflow','hidden');
    //         });
    // $('#m_tersangka').on('show.bs.modal', function () {
    //             $("body").css('overflow','hidden');
    //         });


});


$(document).ajaxSuccess(function(){

       $('#id_tersangka-grid-container td ').off('click').click(function(){
                    var dataId = $(this).attr('data-col-seq');
                    var id_tersangka = $(this).attr('data-id');
                    var data = jQuery.parseJSON(id_tersangka);
                    var tgl = data.tgl_sp_penyidik;

                    var d = new Date(tgl);
                    var curr_date = d.getDate();
                    var curr_month = d.getMonth();
                    var curr_year = d.getFullYear();

                    
                    $('#pdmnotapendapat-tgl_ba4').val(data.tgl_ba4);
                    $('#pdmnotapendapat-no_urut_tersangka').val(data.no_urut_tersangka);
                    $('#pdmnotapendapat-nama_tersangka_ba4').val(data.nama);
                    $('#pdmnotapendapat-no_surat_perintah').val(data.no_sp_penyidik);
                    $('#pdmnotapendapat-tgl_srt_perintah-disp').val(curr_date + "-" + curr_month + "-" + curr_year);
                    $('#pdmnotapendapat-tgl_srt_perintah').val(data.tgl_sp_penyidik);

                    $('#m_tersangka').modal('hide');
                if(data.ada==0){
                  $('#pdmnotapendapat-tindakan_status').val('1');
                  $('#pdmnotapendapat-tindakan_status').attr('disabled',true);
                }else{
                  $('#pdmnotapendapat-tindakan_status').attr('disabled',false);
                }
                    
                });
     });

//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>
