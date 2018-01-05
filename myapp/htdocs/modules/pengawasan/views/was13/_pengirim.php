
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
  /*$(document).ready(function(){

      $("#buttonTT").click(function(){
           var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');
    alert('test'+keys);
      });
  });*/
function pilihPegawaiTT(){
    
    var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');
    alert('test'+keys);
}
</script>
<div>
 <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Was-9</th>
                <th>Nama Saksi</th>
                <th>Nama Pemeriksa</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $id ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>