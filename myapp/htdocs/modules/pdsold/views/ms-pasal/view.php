<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPasal */

$this->title = $model->uu;
$this->params['breadcrumbs'][] = ['label' => 'Ms Pasals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-pasal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'uu' => $model->uu, 'pasal' => $model->pasal], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'uu' => $model->uu, 'pasal' => $model->pasal], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uu',
            'pasal',
            'bunyi',
        ],
    ]) ?>

</div>
<script type="text/javascript">

    $('#printToSave').click(function(){
        var print       = $('#pdmp18-no_surat').val();
        var tempat      = $('#pdmp18-dikeluarkan').val();
        var tgl         = $('#pdmp18-tgl_dikeluarkan-disp').val();        
        var tandaTangan = $('#pdmp18-id_penandatangan').val(); 
        if(print!=''&&tempat!=''&&tgl!=''&&tandaTangan!=''){
             $.ajax({
                type        : 'POST',
                url         :'/pdsold/p18/cek-no-surat-p18',
                data        : 'no_surat='+print,                                
                success     : function(data){
                                  if(data>0){
                                    alert('No P-18 : Telah Tersedia Silahkan Input No Lain');
                                  }else{
                                    $('input[name="printToSave"]').val('1');
                                         $.ajax({
                                            type: "POST",
                                            async:    false,
                                            url: '/pdsold/pdm-p18/update',
                                            data: $("form").serialize(),
                                            success:function(data){ 
                                            $('.box-footer').hide(); 
                                            var cetak   = '/pdsold/pdm-p18/cetak?id='+data;  
                                            var update  =  'update?id='+data;
                                                window.location.href = cetak;
                                                setTimeout(function(){ window.location = update; }, 3000);
                                        
                                            },
                                        });
                                  }
                              }
                });
            $('form').submit();
        }else{
            alert("Nomor /  Tanggal / penandatangan Belum Terisi!!");
        }
    });
</script>