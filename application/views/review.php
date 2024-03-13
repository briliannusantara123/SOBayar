<?php $this->load->view('template/head') ?>
<?php   $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
} ?>
<nav style="z-index: 10000;position: fixed;width: 100%;background-color: #223c77;color: white;">
  <div class="container">
    <p style="text-align: center;padding-top: 13px;color: white;"> Kritik, Saran dan Pujian</p>
  </div>
  <div style="width: 100%; height: 0px; border: 1px #000 solid;">
  </div>
</nav>
<br/>
<br/>
<br/>
<form action="<?= base_url() ?>index.php/review/save/<?= $nomeja;?>" method="post">
  <div style="padding-left: 10px; padding-right:10px;">
    <table width="100%" border="0">
    <?php foreach($category as $cat){ ?>
      <tr>
        <td width="100%" colspan="2" align="left"><b><h4><?php echo $cat->description?></h4></b></td>
      </tr>
      <tr>
        <td width="50%">
          <input type="hidden" id="cat_id_<?php echo $cat->id;?>" name="cat_id[]" value="<?php echo $cat->id;?>">
          <input type="hidden" id="desc_<?php echo $cat->id;?>" name="desc[]" value="<?php echo $cat->description;?>">
          <textarea class="form-control" id="kritik_<?php echo $cat->id;?>" name="kritik[]" rows="3" placeholder="Masukkan Kritik dan Saran"></textarea>
        </td>
        <td width="50%">
          <textarea class="form-control" id="pujian_<?php echo $cat->id;?>" name="pujian[]" rows="3" placeholder="Masukkan Pujian"></textarea>
        </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
    <?php }?>
    </table>
  </div>
  <div class="container text-center">
    <button type="submit" class="btn btn-outline-primary" style="padding-top: 10px;padding-bottom: 10px;padding-left: 30px;padding-right: 30px;"> Kirim </button>
    <a href="<?= $previous ?>" class="btn btn-outline-danger" style="padding-top: 10px;padding-bottom: 10px;padding-left: 30px;padding-right: 30px;">Kembali</a>
  </div>
</form>

<?php $this->load->view('template/footer') ?>