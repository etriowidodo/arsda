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
                    ],
               
                     [
                         'class' => 'yii\grid\ActionColumn',
                         'template' => '{select}',
                         'buttons' => [
                             'select' => function ($url, $model) {
                                 return Html::checkbox('pilih', false, ['value' => $model['id_tersangka'].'#'.$model['nama'].'#'.$model['id_tersangka']]);
                             },
                        ]
                     ],
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
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a id="pilih-tersangka" class="btn btn-warning">Pilih</a>
            <!-- jaka | tambah tombol batal -->
            <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            <!-- END -->
    </div>

    </div>
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);

        $js = <<< JS
	      
        $('#pilih-tersangka').click(function () {
            
            $('input:checkbox:checked').each(function (index,value) {
                var value = $(this).val();
                var data = value.split('#');
                var trCount = $("#table_tersangka tr").length;
                var idTersangkaValue = [];
                $("input[name='id_tersangka[]']").each(function(){
                    idTersangkaValue.push($(this).val());
                });
						
                if(jQuery.inArray(data[0], idTersangkaValue) > -1) {
                    // console.log(idTersangkaValue);
                    // console.log(data[4]);
                    // $('input:checkbox').prop('checked', false);
                    // alert(data[1] + ' Sudah terpilih');return false;
                }else{
                    $('#tbody_tersangka').append(
                        '<tr data-id="'+data[0]+'">' +
                      
						   '<td id="tdTRS" width="20px"><input type="checkbox" name="tersangka[]"" class="hapusTersangka" id="hapusTersangka" value="'+data[0]+'">' +
						   '<td><a  class="tambah_calon_tersangka" name="nama_tersangka[]"  href="#'+ data[0] + '">' + data[1] + '</a> </td>' +
                       '<input type="hidden" id="id_tersangka" name="id_tersangka[]" value="' + data[0] + '">' +
                        '</tr>'
                    );
                    $('#m_tersangka').modal('hide');
                }

            });
			
			
        });
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
      $('thead th').hide();
      if($('#id_tersangka-grid-filters td').length>1)
      {
      $('#id_tersangka-grid-filters td').first().remove();
      $('#id_tersangka-grid-filters td').last().remove();
      $('#id_tersangka-grid-filters td').first().attr('colspan',3);
      }
      
      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka'); 
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         edit();
     });
//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>