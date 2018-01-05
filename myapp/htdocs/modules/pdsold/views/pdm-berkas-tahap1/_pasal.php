<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsJenisPerkara;
use app\modules\pdsold\models\MsJenisPidana;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal-content" style="width: 900px; margin: 30px auto;">    
    <div class="modal-header">
        Data Pasal
        <div class="navbar-right" style="color: black; ">
            <h5>
            <input type="hidden" value='<?= $id_uu?>' id='id_uu'/>
                <?php
                    echo Html::dropDownList('kode_pidana1', null,
                        ArrayHelper::map(MsJenisPidana::find()->all(),'kode_pidana', 'akronim')
                        ,['options' =>
                            [$kode_pidana => ['Selected'=>'selected']],
                            'prompt' => ' -- Pilih Jenis Pidana --']
                        );
                    echo ' ';
                echo Html::dropDownList('jenis_perkara1', null,
                    ArrayHelper::map(MsJenisPerkara::find()->where('kode_pidana = :kode_pidana',[':kode_pidana'=>$kode_pidana])->all(), 'jenis_perkara', 'nama')
                    ,['options' =>
                        [$jenis_perkara => ['Selected'=>'selected']],
                        'prompt' => ' -- Pilih Jenis Perkara --']
                    );
            ?>
            </h5>
        </div>

        
    </div>
    

    <div class="modal-body">


			<?= GridView::widget([
		'id'=>'grid_master_pasal',
        'dataProvider' => $dataPasal,
        'filterModel' => $searchPasal,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'pasal',
            'bunyi',
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihPasal", "class" => "btn btn-warning",
                                    "pasal" => $model['pasal'],
                                    "onClick" => "pilihPasal($(this).attr('pasal'))"]);
                    }
                        ],
            ],
        ],
		'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
		'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ]
    ]); ?>
		</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
     
		
	
	   <div class="modal-footer">
            
            <a class="btn btn-danger" id="batal-modal-pasal">Batal</a>
            
        </div>

<script>
    
    $('#batal-modal-pasal').on('click',function(){
        $('#m_pasal').modal('hide');
    });
    
    $('select[name=kode_pidana1]').on('change',function() {
        var var_id_uu=$('#id_uu').val();
        var var_kode_pidana=$('select[name=kode_pidana1]').val();
        $.get( "/pdsold/pdm-berkas-tahap1/show-pasal-dg-kode-pidana",{kode_pidana:var_kode_pidana,id_uu:var_id_uu} ,function( data ) {
            $('#m_pasal').html(data).show();
            console.log(data);
        });
    });

    $('select[name=jenis_perkara1]').on('change',function() {
        var var_id_uu=$('#id_uu').val();
        var var_kode_pidana=$('select[name=kode_pidana1]').val();
        var var_jenis_perkara=$('select[name=jenis_perkara1]').val();
        $.get( "/pdsold/pdm-berkas-tahap1/show-pasal-dg-kode-pidana",{kode_pidana:var_kode_pidana,id_uu:var_id_uu,jenis_perkara:var_jenis_perkara} ,function( data ) {
            $('#m_pasal').html(data).show();
            console.log(data);
        });
    });

    
</script>

