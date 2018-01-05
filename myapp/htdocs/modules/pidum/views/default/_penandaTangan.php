<?php  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div class="modal-content" style="width: 700px;margin: 30px auto;">    
    <div class="modal-header">
        Penandatangan 
    </div>
    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;

            echo GridView::widget([
                'id'=>'id_tersangka-grid-grid',
                'dataProvider'=> $dataProvider2,
                'filterModel' => $searchModelPenandatangan,
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
                      'label' => 'Jabatan',
                      'attribute' => 'jabatan',
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
$this->registerJs(\yii\web\View::POS_BEGIN);
        $js = <<< JS
	var parentURL = window.parent.location.href;
    var arr = parentURL.split('/');
        
   //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->     
     function edit()
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
       $('#id_tersangka-grid-filters').remove();
      }
      
      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka'); 
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         edit();
     });


$(document).ready(function(){

  $('.cancel').click(function(e){
    $('#m_tanda_tangan').modal('hide');
   $('#m_tanda_tangan.modal.in').modal('hide');
   if(arr[4]=='pdm-penyelesaian-pratut'){
		$('body').css( 'overflow-y','hidden' );
		$('#bannerformmodal').css( 'overflow-y','scroll' );
   }
  });  

});


$(document).ajaxSuccess(function(){
       $('td ').click(function(){
                    var dataId = $(this).attr('data-col-seq');
                    if(dataId >0){
                           var id_tersangka = $(this).attr('data-id');
                           var data = jQuery.parseJSON(id_tersangka);
                           var index = $('select[peg_nip_baru=jabatan]  option[value='+data.peg_nip_baru+']').index();
                           $('select[peg_nip_baru=jabatan]  option:eq('+index+')').prop('selected','true');
						   $('#hdn_nama_penandatangan').val(data.nama);
						   $('#hdn_pangkat_penandatangan').val(data.pangkat);
						   $('#hdn_jabatan_penandatangan').val(data.jabatan);
						   $('#m_tanda_tangan.modal.in').modal('hide');
						   
						   if(arr[4]=='pdm-penyelesaian-pratut'){
							   $('body').css( 'overflow-y','hidden' );
							   $('#bannerformmodal').css( 'overflow-y','scroll' );
						   }
                    }
                    
                });
     });
      $('#m_tanda_tangan').on('hidden.bs.modal', function () {
           $('.help-block').remove();
        });


//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>