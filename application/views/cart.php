<?php $this->load->view('template/head') ?>
<?php   $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
} ?>
<style type="text/css">
  .loading {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 1s linear infinite;
  margin: 10px auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

  .modal {
   margin-top: 100px;
   top: 10px;
   right: 100px;
   bottom: 0;
   left: 0;
   z-index: 10040000;
   overflow: auto;
   overflow-y: auto;
}
.modalbyr {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
}

.modalbyr-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fefefe;
  padding: 20px;
  border: 1px solid #888;
  border-radius: 5px;
  max-width: 400px;
  text-align: center;
}

.closebyr {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.closebyr:hover,
.closebyr:focus {
  color: black;
}
footer{
  text-align: center;
  background-color: white;
  margin-top: 10px;
  border-radius: 10%;
  /*position: absolute;*/
  bottom: 0;
  width: 100%;
  position: fixed;
  z-index: 200000;
}
.center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }
</style>
<div id="loadingkonek"></div>
<nav style="background-color: #223c77">
  <div class="container">
    <p style="text-align: center;padding-top: 13px;color: white;">Cart Order</p>
  </div>
  <div style="width: 100%; height: 0px; border: 1px #000 solid;">
</div>
</nav>
<br>
<form action="<?= base_url() ?>index.php/cart/vo/<?= $nomeja ?>/<?= $cek ?>/<?= $sub ?>#<?= $sub ?>" method="POST">
<div class="container" >
<?php if ($item == NULL): ?>
  <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" color="lightblue" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" style="display: block;margin-left: auto;margin-right: auto;">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  <h5 style="margin-top: 20px;text-align: center;color: #223c77;">Your Cart is Still Empty <br> Let`s Order Now!</h5>
 <?php else: ?>
  
    
    <div class="row">
    <!-- <?php if ( $i->image_path != "" ): ?> -->
        <div class="col-1">
          <!-- <img src="<?= $i->image_path ?>" alt="Red dot" style="width: 80px;height: 80px;border-radius: 20px;" /> -->
        </div>
      <!-- <?php  else: ?> -->
        <!-- <div class="col-4"><img src="<?= base_url();?>/assets/picture.png" alt="Red dot" style="width: 120px;height: 120px;border-radius: 20px;" /></div> -->
      <!-- <?php endif ?> -->
    
    <!-- <div class="col-6" style="margin-top: 10px;color: #223c77;"><?= $i->description?><br>Rp <?= number_format($i->unit_price)?><br><?= $i->extra_notes?></div>
    <div class="col-1" style="margin-top: 10px;text-align: center;color: #223c77;">Qty <br> <p style="padding-left: 7px;"><?= $i->qty ?></p></div>
    <div class="col-3" style="margin-top: 10px;text-align: center;margin-left: 5px;color: #223c77;">Aksi <br> <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i->id ?>" class="btn btn-success" style="padding:7px 7px; "><i class="fas fa-pen" style="color: white"></i></a><a href="<?= base_url() ?>cart/delete/<?= $i->id ?>/<?= $i->description ?>/<?= $nomeja ?>" class="btn btn-danger" style="padding:8px 8px;margin-bottom: 2px; "><i class="fas fa-trash"></i></a></div>
    <?php if ($i->qty_take_away != 0): ?>
      <p style="color: #223c77;">Dibawa Pulang : <?= $i->qty_take_away?></p>
    <?php endif; ?>
     -->
    <div class="container ">
    <div id="myModalbyr" class="modalbyr">
      <div class="modalbyr-content" style="color: white;background-color: #223c77;">
        <h5>Please Make Payment at the Cashier First.</h5>
        <div class="loading"></div>
      </div>
    </div>
    <input type="hidden" name="cekbayar" value="" id="cekbayar">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Menu/Paket Order</th>
      <th scope="col">Harga</th>
      <th scope="col">Qty</th>
      <th scope="col">Pesan</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($item as $i): ?>
    <tr>
      <input type="hidden" name="" value="<?= $i->sub_paket_so ?>" id="subklik<?= $i->id ?>">
      <?php if ($i->is_paket): ?>
        <th scope="row"><a href="<?= base_url() ?>index.php/Cart/detailmenupaket/<?= $nomeja ?>/<?= $i->description ?>/<?= $cek ?>/<?= $sub ?>#<?= $sub ?>"><p><?= $i->description ?></p></a></th>
        <td><p>Rp <?= number_format($i->unit_price); ?></p></td>
        <td><p style="text-align: left;"><?= $i->qty ?></p></td>
        <td></td>
        <td><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i->id ?>" class="btn" style="padding:7px 7px;background-color: #223c77; "><i class="fas fa-pen" style="color: white"></i></a><a href="<?= base_url() ?>index.php/cart/delete/<?= $i->id ?>/<?= $nomeja ?>/paket/<?= $cek ?>/<?= $i->description ?>/<?= $i->item_code ?>" class="btn btn-danger" style="padding:8px 8px;margin-bottom: 2px; " onclick="hapus<?= $i->id?>('<?= $i->item_code?>')"><i class="fas fa-trash"></i></a></td>
      <?php else: ?>
        <?php if ($i->is_sold_out == 1): ?>
          <th scope="row"><p><s><?= $i->description ?></s><br><a style="color: red;">SOLD OUT</a></p></th>
        <?php else: ?>
          <th scope="row"><p><?= $i->description ?></p></th>
        <?php endif ?>
        <td><p>Rp <?= number_format($i->unit_price); ?></p></td>
        <td><p style="text-align: left;"><?= $i->qty ?></p></td>
        <!-- <?php if ( $i->notesdua): ?>
          <td><p style="text-align: left;"><?= $i->extra_notes ?>,<?= $i->notesdua ?></p></td>
        <?php else: ?>   -->
          <td><p style="text-align: left;"><?= $i->extra_notes ?></p></td>
        <!-- <?php endif ?> -->

        <td>
          <?php if ($i->is_sold_out == 1): ?>
            <a href="<?= base_url() ?>index.php/cart/delete/<?= $i->id ?>/<?= $nomeja ?>/nopaket/<?= $cek ?>/<?= $sub ?>/<?= $i->item_code ?>" class="btn btn-danger" style="padding:8px 8px;margin-bottom: 2px; " onclick="hapus<?= $i->id?>('<?= $i->item_code?>')"><i class="fas fa-trash"></i></a>
          <?php else: ?>
          <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i->id ?>" class="btn" style="padding:7px 7px;background-color: #223c77; "><i class="fas fa-pen" style="color: white"></i></a><a href="<?= base_url() ?>index.php/cart/delete/<?= $i->id ?>/<?= $nomeja ?>/nopaket/<?= $cek ?>/<?= $sub ?>/<?= $i->item_code ?>" class="btn btn-danger" style="padding:8px 8px;margin-bottom: 2px; " onclick="hapus<?= $i->id?>('<?= $i->item_code?>')"><i class="fas fa-trash"></i></a>  
          <?php endif ?>
        </td>
      <?php endif ?>
      
    </tr>
    <input type="hidden" name="nama[]" value="<?= $i->description ?>">
  <input type="hidden" name="qty[]" id="qty<?= $i->id?>" value="<?= $i->qty ?>">
  <input type="hidden" name="cek[]" value="<?= $i->as_take_away ?>">
  <input type="hidden" name="qta[]" value="<?= $i->qty_take_away ?>">
  <input type="hidden" name="harga[]" value="<?= $i->unit_price ?>">
  <input type="hidden" name="is_paket[]" value="<?= $i->is_paket ?>">
  <!-- <?php if ( $i->notesdua): ?>
  <input type="hidden" name="pesandua[]" value="<?= $i->notesdua ?>">
  <input type="hidden" name="pesantiga[]" value="<?= $i->notesdua ?>">
  <?php   endif ?> -->
  <input type="hidden" name="pesan[]" value="<?= $i->extra_notes ?>">
  <input type="hidden" name="no[]" id="item_code<?= $i->id ?>" value="<?= $i->item_code ?>" class="form-control item_code<?= $i->id ?>">
  <input type="hidden" name="need_stock[]" id="need_stock" value="<?= $i->need_stock ?>" class="form-control need_stock">
    <?php endforeach ?>
    <input type="hidden" name="sold" id="sold">
  </tbody>
</table>
  
  </div>
    
  </div>
<?php endif ?>
</div>
<br>
<footer>
  <div class="text-center"><h5>Please Check Your Order <br> Order Has Been Submitted <br> Cannot Be Cancelled</h5></div>
<?php if ($item == NULL): ?>
<div class="container">
<a href="<?= base_url() ?><?= $log ?>" class="btn btn-outline-danger" style="padding-top: 20px;padding-bottom: 20px;padding-left: 40px;padding-right: 40px;display: block;margin-left: auto;margin-right: auto;">Back</a>
</div>
<?php else: ?>
<div class="container text-center">
  <button type="button" class="btn btn-outline-primary" style="padding-top: 20px;padding-bottom: 20px;padding-left: 50px;padding-right: 50px;" data-bs-toggle="modal" data-bs-target="#exampleModal" id="button">
  Order
</button>
<!-- <button type="submit" class="btn btn-outline-primary" style="padding-top: 20px;padding-bottom: 20px;padding-left: 50px;padding-right: 50px;" onclick="order()">
  Order
</button> -->
<a href="<?= base_url() ?><?= $log ?>" class="btn btn-outline-danger" style="padding-top: 20px;padding-bottom: 20px;padding-left: 40px;padding-right: 40px;" id="buttonback">Back</a>
</div>  
<?php endif ?>
<br>  
</footer>
</form>
<br>
<br>
</div>
  </div>
</div>

<div style="margin-top: 100px;"></div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #223c77;color: white;">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Choose Payment Type</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">Sub Total</th>
                    <td></td>
                    <td></td>
                    <?php if ($totalbayar == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($totalbayar->total) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">SC</th>
                    <td></td>
                    <td></td>
                    <?php if ($totalbayar == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($totalbayar->sc) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">PB1</th>
                    <td></td>
                    <td></td>
                    <?php if ($totalbayar == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($totalbayar->ppn) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">Total Payment</th>
                    <td></td>
                    <td></td>
                    <?php if ($totalbayar == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($totalbayar->total + $totalbayar->sc + $totalbayar->ppn) ?></td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    <div class="container text-center">
    <div class="row">
      <div class="col">
        <form action="<?= base_url() ?>index.php/cart/vo/<?= $nomeja ?>/PN/<?= $cek ?>/<?= $sub ?>#<?= $sub ?>" method="POST">
          <?php foreach ($item as $i): ?>
            <input type="hidden" name="nama[]" value="<?= $i->description ?>">
            <input type="hidden" name="qty[]" id="qty<?= $i->id?>" value="<?= $i->qty ?>">
            <input type="hidden" name="cek[]" value="<?= $i->as_take_away ?>">
            <input type="hidden" name="qta[]" value="<?= $i->qty_take_away ?>">
            <input type="hidden" name="harga[]" value="<?= $i->unit_price ?>">
            <input type="hidden" name="is_paket[]" value="<?= $i->is_paket ?>">
            <!-- <?php if ( $i->notesdua): ?>
            <input type="hidden" name="pesandua[]" value="<?= $i->notesdua ?>">
            <input type="hidden" name="pesantiga[]" value="<?= $i->notesdua ?>">
            <?php   endif ?> -->
            <input type="hidden" name="pesan[]" value="<?= $i->extra_notes ?>">
            <input type="hidden" name="no[]" id="item_code<?= $i->id ?>" value="<?= $i->item_code ?>" class="form-control item_code<?= $i->id ?>">
            <input type="hidden" name="need_stock[]" id="need_stock" value="<?= $i->need_stock ?>" class="form-control need_stock">
          <?php endforeach ?>
          <input type="hidden" name="totalbayar" value="<?= $totalbayar->total + $totalbayar->sc + $totalbayar->ppn ?>">
          <div class="center">
            <button type="submit" class="btn btn-outline-primary" style="padding-top: 10px;padding-bottom: 10px;padding-left: 80px;padding-right: 80px;" id="bayarsekarang" onclick="order()">Payment Now</button>
          </div>
        </form>
      </div>
      <div class="col">
        <form action="<?= base_url() ?>index.php/cart/vo/<?= $nomeja ?>/PC/<?= $cek ?>/<?= $sub ?>#<?= $sub ?>" method="POST">
          <?php foreach ($item as $i): ?>
            <input type="hidden" name="nama[]" value="<?= $i->description ?>">
            <input type="hidden" name="qty[]" id="qty<?= $i->id?>" value="<?= $i->qty ?>">
            <input type="hidden" name="cek[]" value="<?= $i->as_take_away ?>">
            <input type="hidden" name="qta[]" value="<?= $i->qty_take_away ?>">
            <input type="hidden" name="harga[]" value="<?= $i->unit_price ?>">
            <input type="hidden" name="is_paket[]" value="<?= $i->is_paket ?>">
            <!-- <?php if ( $i->notesdua): ?>
            <input type="hidden" name="pesandua[]" value="<?= $i->notesdua ?>">
            <input type="hidden" name="pesantiga[]" value="<?= $i->notesdua ?>">
            <?php   endif ?> -->
            <input type="hidden" name="pesan[]" value="<?= $i->extra_notes ?>">
            <input type="hidden" name="no[]" id="item_code<?= $i->id ?>" value="<?= $i->item_code ?>" class="form-control item_code<?= $i->id ?>">
            <input type="hidden" name="need_stock[]" id="need_stock" value="<?= $i->need_stock ?>" class="form-control need_stock">
          <?php endforeach ?>
          <input type="hidden" name="totalbayar" value="<?= $totalbayar->total + $totalbayar->sc + $totalbayar->ppn ?>">
          <div class="center">
            <button type="submit" class="btn btn-outline-primary" id="bayarkasir" style="padding-top: 10px;padding-bottom: 10px;padding-left: 67px;padding-right: 67px;">Pay at the cashier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
        

        
      </div>
    </div>
  </div>
</div>
<?php foreach ($item as $i): ?>
<div class="modal fade" id="exampleModal<?= $i->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #223c77;color: white;">
        <h5 class="modal-title" style="text-align: center;" id="exampleModalLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <form action="<?= base_url() ?>index.php/cart/ubah/<?= $i->id ?>/<?= $nomeja ?>/<?= $cek ?>/<?= $sub ?>" method="post">
      <div class="modal-body">
        
      <h4 style="text-align: center;color: #223c77;"><?= $i->description ?></h4>
      <img src="<?= $i->image_path ?>" alt="Red dot" style="width: 180px;height: 180px;border-radius: 20px; display: block;margin-left: auto;margin-right: auto;" />
      <div class="container text-center">
  <div class="row">
    <div class="col" >
      <button type="button" class="btn minus<?= $i->id ?>" style="padding-left: 30px;padding-right: 30px;background-color: #223c77;"> - </button>
    </div>
    <div class="col">
      <input type="text" name="qty" class="form-control num<?= $i->id ?>" id="num<?= $i->id ?>" value="<?= $i->qty ?>" readonly style="margin-bottom: 5px;text-align: center">
      <input type="hidden" name=" " class="form-control flag<?= $i->id ?>" id="flag<?= $i->id ?>" value="0"  style="margin-bottom: 5px;text-align: center">
    </div>
    <div class="col">
      <button type="button" class="btn plus<?= $i->id ?>" style="padding-left: 30px;padding-right: 30px;background-color: #223c77;">+</button>
    </div>
  </div>
</div>
      <input type="hidden" name="extra_notes" class="form-control" value="<?= $i->extra_notes ?>" placeholder="Masukan Pesan...">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn" style="padding-left: 40px;padding-right: 40px;padding-top: 10px;padding-bottom: 10px;background-color: #223c77;" onclick="klikedit<?= $i->id?>('<?= $i->item_code?>')">Ubah</button>
      </div>
    </div>
    </form>
  </div>
</div>
<?php endforeach ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<?php foreach ($item as $i ): ?>
<script type="text/javascript">
  const plus<?= $i->id ?> = document.querySelector(".plus<?= $i->id ?>"),
  minus<?= $i->id ?> = document.querySelector(".minus<?= $i->id ?>"),
  num<?= $i->id ?> = document.querySelector(".num<?= $i->id ?>");
  flag<?= $i->id ?> = document.querySelector(".flag<?= $i->id ?>");

  let a<?= $i->id ?> = <?= $i->qty ?>;
  let b<?= $i->id ?> = 0; 

  plus<?= $i->id ?>.addEventListener("click", ()=>{
   a<?= $i->id ?>++;
   b<?= $i->id ?>++;
   num<?= $i->id ?>.value = a<?= $i->id ?>;
   flag<?= $i->id ?>.value = b<?= $i->id ?>;
   // localStorage.setItem('<?= $i->item_code ?>',a<?= $i->id ?>);
   console.log(a<?= $i->id ?>); 
  });
  minus<?= $i->id ?>.addEventListener("click", ()=>{
   
   var inputValue = num<?= $i->id ?>.value;
        // console.log(inputValue);
        if (inputValue >= 1) {
          a<?= $i->id ?>--;
          b<?= $i->id ?>--;
   num<?= $i->id ?>.value = a<?= $i->id ?>;
   flag<?= $i->id ?>.value = b<?= $i->id ?>;
   // localStorage.setItem('<?= $i->item_code ?>',a<?= $i->id ?>);
   console.log(a<?= $i->id ?>);
   }  
  });
</script>
  
<?php endforeach ?>
<?php 
  $nomeja = $this->session->userdata('nomeja');
 ?>
 <?php foreach ($item as $i ): ?>
   <script type="text/javascript">
   function hapus<?= $i->id?>(no){
    
    var qty<?= $i->id ?> = document.getElementById("qty<?= $i->id ?>");
    var qa<?= $i->id ?> = parseInt(localStorage.getItem(no));
    // console.log(qty<?= $i->id ?>.value);
      localStorage.setItem(no,qa<?= $i->id ?>-qty<?= $i->id ?>.value);
      localStorage.removeItem('qty'+no);
      localStorage.removeItem('sim');
      localStorage.removeItem('angka'+no);
      var subklik<?= $i->id ?> = $('#subklik<?= $i->id ?>').val();
      var subarr<?= $i->id ?> = subklik<?= $i->id ?>.split(',');
      for (var i = 0; i <subarr<?= $i->id ?>.length ; i++) {
        localStorage.removeItem(subarr<?= $i->id ?>[i]);
      }
      localStorage.setItem(no,0);
   }
   function klikedit<?= $i->id?>(no){
    
    var flag<?= $i->id ?> = document.getElementById("flag<?= $i->id ?>");
    var qa = parseInt(localStorage.getItem(no));
    // console.log(flag<?= $i->id ?>.value);
      localStorage.setItem(no,qa+parseInt(flag<?= $i->id ?>.value));
      
   }
   var sold = document.querySelector("#sold");
   function order() {
    <?php if ($i->is_sold_out == 1): ?>
        sold.value = 1;
        const submitButton = document.querySelector("button[type='submit']");
        submitButton.type = "button";
        Swal.fire({
            title: 'Notification!',
            text: 'There is an item out of stock!',
            icon: 'warning',
            confirmButtonColor: "#223c77",
            confirmButtonText: 'OK'
        });
    <?php else: ?>
        localStorage.clear();
    <?php endif; ?>
}

 </script>

 <?php endforeach ?>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    $(document).ready(function () {
      setInterval(function(){
      $.ajax({
            url: "<?= base_url().'index.php/Cart/get_sold' ?>",
            type: "GET",
            dataType: "json",
            success: function (data) {
                // Handle the data retrieved from the server
                var sold = document.querySelector("#sold");
                sold.value = data;
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    },1000);

      // Get the modal and buttons
      var modalbyr = document.getElementById('myModalbyr');
      var button = document.getElementById('button');
      var buttonback = document.getElementById('buttonback');
      var openModalbyrBtn = document.getElementById('openModalbyrBtn');
      var closeModalbyrBtn = document.getElementById('closeModalbyrBtn');
      var cekbayar = document.getElementById('cekbayar');
      var bayarkasir = document.getElementById('bayarkasir');

      $(bayarkasir).on('click',function(){
          cekbayar.value = "cek";
          localStorage.setItem('cekbayar','cek');
      });
      var cb = localStorage.getItem('cekbayar');
      console.log(cb);

      if (cb) {
        setInterval(function(){
          $.ajax({
              url: "<?= base_url().'index.php/Cart/cekbayar' ?>",
              type: "GET",
              dataType: "json",
              success: function (data) {
                  modalbyr.style.display = 'block';
                  button.style.display = 'none';
                  buttonback.style.display = 'none';
              },
              error: function (xhr, status, error) {
                  modalbyr.style.display = 'none';
                  localStorage.clear();
                  window.location.href = "<?= base_url() ?>index.php/Cart/suksesbayar";
              }
          });

        },1000);
      }
      
      // // Open the modal
      // openModalbyrBtn.onclick = function() {
      //   modalbyr.style.display = 'block';
      // };

      // // Close the modal
      // closeModalbyrBtn.onclick = function() {
      //   modalbyr.style.display = 'none';
      // };
      

      // Close the modal if clicked outside the modal content
      window.onclick = function(event) {
        if (event.target == modal) {
          modalbyr.style.display = 'none';
        }
      };

        
    });
</script>
   
 
<!-- <script type="text/javascript">
  const currentLocation = location.href;
  if (currentLocation == "http://dev.3guru.com:5082/selforderMG/index.php/cart/home/<?= $nomeja ?>/Makanan/Chicken/<?= $no ?>/del") {
    localStorage.removeItem('<?= $no ?>');
  }else if(currentLocation == "http://dev.3guru.com:5082/selforderMG/index.php/cart/home/<?= $nomeja ?>/Minuman/Cold%20Drink/<?= $no ?>/del"){
    localStorage.removeItem('<?= $no ?>');
  }
</script> -->
<?php $this->load->view('template/footer') ?>