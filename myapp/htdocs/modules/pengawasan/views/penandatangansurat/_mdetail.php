<style type="text/css">
    .modal-dialog{
        width: 800px;
    }
</style>
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

   
    <div class="modal-body">
        Penandatangan Surat :
       <div class="col-md-12" style="margin-top:10px;">
       <div class="form-group">
            <label class="control-label col-md-3" >Nama Surat :</label>
            <div class="col-md-5">          
               <input type="text" name="namasurat" class="form-control" value="" id="namasurat" readonly="readonly">
            </div>
        </div>
       </div>
       <div class="col-md-12" style="margin-top:10px;">
       <div class="form-group">
            <label class="control-label col-md-3" >Nama</label>
            <div class="col-md-5">          
               <input type="text" name="nama_penadatangan_asli"  class="form-control" value="" id="nama_penadatangan_asli" readonly="readonly">
            </div>
        </div>
       </div>
         <div class="col-md-12" style="margin-top:10px;">
       <div class="form-group">
            <label class="control-label col-md-3" >Jabatan</label>
            <div class="col-md-5">          
               <input type="text" name="namasurat" class="form-control" value="" id="jabatan_asli" readonly="readonly">
            </div>
        </div>
       </div>

       <div class="col-md-12" style="margin-top:20px;">
            <label class="control-label col-md-5" >Penandatangan Pengganti :</label>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nip</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody class="bd_detail">
        
            </tbody>
        </table>
       </div>
    <div class="col-md-12 text-center" style="margin-top:20px; margin-bottom:20px;">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
    </div>
    </div>

 


