<?php
  $page_title = 'All Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(6);
?>
<?php


$sales = find_all_global('pengajuan',$_GET['id'],'id_nodin');
$id = find_all_global('pengajuan',$_GET['id'],'id_nodin');
$pengajuan = find_by_id('pengajuan',(int)$_GET['id']);
$idi= $_GET['id'];


if(isset($_GET['s']) and $_GET['s']==='hapus_adk'){
      $query  = "UPDATE pengajuan SET ";
      $query .= "upload_adk=''";
      $query .= "WHERE id='{$idi}'";
     // echo $query; exit();
      $result = $db->query($query);
      $session->msg('s',' Berhasil di Batalkan');
      if($user['user_level']==5){
    redirect('pengajuan_bpp.php?id='.$pengajuan['id_nodin']);
    }else{
    redirect('pengajuan_bpp.php?id='.$pengajuan['id_nodin'], false);
    }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>All Pengajuan</span>
          </strong>
          <div class="pull-right">
            <a href="add_pengajuan.php?id=<?=$idi;?>" class="btn btn-primary">Add pengajuan</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center"> SPM/Jenis Pengajuan </th>
                <th class="text-center" style="width: 15%;"> Status Verifikasi </th> 
                <th class="text-center" style="width: 15%;"> Status SPM </th>
                <th class="text-center">Berkas SPM</th>             
                <th class="text-center" style="width: 15%;"> Status KPPN </th> 
                <th class="text-center" style="width: 15%;"> Status SP2D </th>
                <th class="text-center" style="width: 15%;"> Status Pengambilan Uang </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['SPM']); ?>/<?php $jenis = find_by_id('jenis_pengajuan',$sale['id_jenis_pengajuan']); echo $jenis['keterangan']?></td>
               <td class="text-center"><?php if($sale['status_verifikasi']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
             <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$sale['status_verifikasi']);echo $user['name'];?></span><?php } ?>
            <?php $verif = find_all_global('verifikasi',$sale['id'],'id_pengajuan');if($verif[0]['id_pengajuan']!=NULL){?>
               <a href="<?php 
                  if($sale['id_jenis_pengajuan']==1){
                    echo "verif_LSsppd.php?id=".$sale['id_nodin']."&v=".$sale['id'];
                  }else if($sale['id_jenis_pengajuan']==2){
                    echo "verif_sppdLn.php?id=".$sale['id_nodin']."&v=".$sale['id'];
                  }else if($sale['id_jenis_pengajuan']==3){
                    echo "verif_LSHonor.php?id=".$sale['id_nodin']."&v=".$sale['id'];
                  }else if($sale['id_jenis_pengajuan']==4){
                    echo "verif_LSjasprof.php?id=".$sale['id_nodin']."&v=".$sale['id'];
                  }else if($sale['id_jenis_pengajuan']==5){
                    echo "verif_LSkur50.php?id=".$sale['id_nodin']."&v=".$sale['id'];
                  }else{
                    echo "verif_GU.php?id=".$sale['id_nodin']."&v=".$sale['id'];
            
                  }
                
                ?>" class="btn btn-warning">Kekurangan</a>
            <?php } ?>
            </td>
            
            <td class="text-center"><?php if($sale['status_spm']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
             <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$sale['status_spm']);echo $user['name'];?></span><?php } ?>
            </td>
            <td class="text-center">
                <a href="detail_dokumen.php?id=<?=$sale['id']?>" class="btn btn-primary">Upload Dokumen</a>
            </td>

            <td class="text-center">
            <?php if($sale['penolakan_kppn']!=''){?><span class="label label-danger">Penolakan KPPN perbaiakan= <?=$sale['penolakan_kppn'];?></span><?php }else{ ?>
               
               <?php } ?>
               <?php if($sale['status_kppn']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
                <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$sale['status_kppn']);echo $user['name'];?></span><?php } ?>
            </td>

            <td class="text-center"><?php if($sale['status_sp2d']==0){?><span class="label label-danger">Belom Cair</span><?php }else{?>
             <span class="label label-success">Sudah Cair [<?php $user = find_by_id('users',(int)$sale['status_sp2d']);echo $user['name'];?>]</span><?php } ?>
            </td>
            <td class="text-center">
                <?php if($sale['status_pengambilan_uang']==0){?><span class="label label-danger">Belom di Ambil</span><?php }else{?>
                 <span class="label label-success">Sudah Diambil <?php $user = find_by_id('users',(int)$sale['status_sp2d']);?></span><?php } ?>
            </td>

            

            <!-- <td class="text-center"><?php if($sale['upload']==''){?><a href="media.php?id=<?=$sale['id']?>" class="btn btn-primary">Upload</a><?php }else{?>
             <a href="uploads/products/<?=$sale['upload']?>" class="btn btn-success" target="_blank">Preview</a>
             <a href="batal_upload.php?id=<?=$sale['id']?>" class="btn btn-danger">Batal</a>
             <?php } ?>
            </td>
            <td class="text-center"><?php if($sale['upload_pertanggungjawaban']==''){?><a href="media_pertanggungjawaban.php?id=<?=$sale['id']?>" class="btn btn-primary">Upload</a><?php }else{?>
             <a href="uploads/pertanggungjawaban/<?=$sale['upload_pertanggungjawaban']?>" class="btn btn-success" target="_blank">Preview</a>
             <a href="batal_uploadPj.php?id=<?=$sale['id']?>" class="btn btn-danger">Batal</a>
             <?php } ?>
            </td>

            <td class="text-center"><?php if($sale['upload_adk']==''){?><a href="media_adk.php?id=<?=$sale['id']?>" class="btn btn-primary">Upload</a><?php }else{?>
             <a href="uploads/adk/<?=$sale['upload_adk']?>" class="btn btn-success" target="_blank">Download</a>
             <a href="pengajuan_bpp.php?id=<?=$sale['id']?>&s=hapus_adk" class="btn btn-danger">Hapus</a>
             <?php } ?>
            </td> -->

               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_pengajuan.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="detail_pengajuan.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-primary btn-xs"  title="Detail Pengajuan" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a onclick="return confirm('Yakin Hapus?')" href="delete_pengajuan.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>