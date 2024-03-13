<?php $this->load->view('template/head') ?>
<style type="text/css">
  .full-width {
            width: 100%;

        }

  #btn_kiri_order {
              margin-bottom: 10px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 5px;
              padding-bottom: 5px;
            }
            #btn_kiri_memanggil {
              margin-bottom: 10px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 5px;
              padding-bottom: 5px;
            }
            #btn_kanan_awal {
              margin-bottom: 20px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 5px;
              padding-bottom: 5px;
            }
            #btn_kanan_bill {
              margin-bottom: 10px;
              padding-left: 48px;
              padding-right: 48px;
              padding-top: 5px;
              padding-bottom: 5px;
            }
  @media (min-width: 412px){
            #btn_kiri_order {
              margin-bottom: 10px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            #btn_kiri_memanggil {
              margin-bottom: 10px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 30px;
              padding-bottom: 30px;
            }
            #btn_kanan_awal {
              margin-bottom: 20px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            #btn_kanan_bill {
              margin-bottom: 10px;
              padding-left: 48px;
              padding-right: 48px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            
        }
        @media (min-width: 720px){
            #btn_kiri_order {
              margin-bottom: 10px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            #btn_kiri_memanggil {
              margin-bottom: 10px;
              padding-left: 52px;
              padding-right: 52px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            #btn_kanan_awal {
              margin-bottom: 20px;
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            #btn_kanan_bill {
              margin-bottom: 10px;
              padding-left: 48px;
              padding-right: 48px;
              padding-top: 20px;
              padding-bottom: 20px;
            }
            
        }
  @media (min-width: 768px) and (max-width: 1024px){
            #btn_kiri_order {
              margin-bottom: 10px;
              padding-left: 67px;
              padding-right: 67px;
              padding-top: 40px;
              padding-bottom: 40px;
            }
            #btn_kiri_memanggil {
              margin-bottom: 10px;
              padding-left: 50px;
              padding-right: 50px;
              padding-top: 45px;
              padding-bottom: 45px;
            }
            #btn_kanan_awal {
              margin-bottom: 10px;
              padding-left: 50px;
              padding-right: 50px;
              padding-top: 45px;
              padding-bottom: 45px;
            }
            #btn_kanan_bill {
              margin-bottom: 10px;
              padding-left: 86px;
              padding-right: 86px;
              padding-top: 40px;
              padding-bottom: 40px;
            }
            
        }
        @media (min-width: 1025px) and (max-width: 1280px){
          #btn_kiri_order {
              margin-bottom: 10px;
              padding-left: 67px;
              padding-right: 67px;
              padding-top: 40px;
              padding-bottom: 40px;
            }
            #btn_kiri_memanggil {
              margin-bottom: 10px;
              padding-left: 50px;
              padding-right: 50px;
              padding-top: 45px;
              padding-bottom: 45px;
            }
            #btn_kanan_awal {
              margin-bottom: 10px;
              padding-left: 50px;
              padding-right: 50px;
              padding-top: 45px;
              padding-bottom: 45px;
            }
            #btn_kanan_bill {
              margin-bottom: 10px;
              padding-left: 86px;
              padding-right: 86px;
              padding-top: 40px;
              padding-bottom: 40px;
            }
        }
        footer{
  text-align: center;
  background-color: white;
  margin-top: 10px;
  /*position: absolute;*/
  bottom: 0;
  width: 100%;
  position: fixed;
  z-index: 200000;
}
 </style>
 <div id="loadingkonek"></div>
    <nav style="background-color: #223c77;color: white;">
  <div class="container">
    <p style="text-align: center;padding-top: 13px;color: white;">Bill Preview</p>
  </div>
  <div style="width: 100%; height: 0px; border: 1px #000 solid;margin-bottom: 5px;">
</div>
</nav>
<div class="container">
  <table class="table">
  <tbody>
    <tr>
      <th scope="row">Customer Name</th>
      <td> </td>
      <td> </td>
      <td><?= $this->session->userdata('username') ?></td>
    </tr>
    <tr>
      <th scope="row">Table No</th>
      <td> </td>
      <td> </td>
      <td><?= $nomeja ?></td>
    </tr>
    <tr>
      <th scope="row">Actual Pax</th>
      <td> </td>
      <td> </td>
      <td><?php if ( $order_bill == NULL ): ?>
      -
      <?php else: ?>
      <?= $order_bill->totalpax_actual ?> / <?= $order_bill->totalpax_reservasi ?> 
      <?php endif ?></td>
    </tr>
    <tr>
      <th scope="row">Transaction No</th>
      <td> </td>
      <td> </td>
      <td><?= $notrans ?></td>
    </tr>
    <tr>
      <th scope="row">Package Type</th>
      <td> </td>
      <td> </td>
      <td>Alacarte</td>
    </tr>
  </tbody>
</table>
</div>
<div class="container " style="margin-bottom: 200px;">
  <?php foreach ($order as $o ): ?>
    <div class="dropdown full-width" id="dropdown1">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #223c77;color: white;width: 100%;">
        <?php if ($o->cekdata == 1): ?>
          First Payment
        <?php else: ?>
          Payment <?= $o->cekdata ?>
        <?php endif ?>
    </button>

    <div class="table-container" style="display: none;">
        <table class="table" style="border:2px solid #223c77;">
            <thead style="background-color: #223c77;color: white;">
                <tr>
                    <th scope="col">Order Menu </th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $transorder = $this->Item_model->getOrderCustomerLine($notrans,$o->cekdata,$nomeja)->result();
                $bill = $this->Item_model->bill($cabang,$notrans,$o->cekdata);
                foreach ($transorder as $i): ?>
                    <tr>
                        <th scope="row"><?= $i->description ?></th>
                        <td><?= $i->qty ?></td>
                        <?php if ($i->unit_price == 0): ?>
                            <td>Free</td>
                            <td>Free</td>
                        <?php else: ?>
                            <?php
                            $dis =  $i->unit_price * ($i->disc/100);
                            $diskon = ($i->unit_price * $i->disc)/100;
                            $tl = $i->unit_price - $diskon;
                            $tqty = $tl * $i->qty;
                            $up = $i->unit_price - $dis;
                            ?>
                            <td>Rp <br> <?= number_format($i->unit_price) ?></td>
                            <td>Rp <br> <?= number_format($tqty) ?></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="container" style="margin-bottom: 10px;">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">Sub Total</th>
                    <td></td>
                    <td></td>
                    <?php if ($bill == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($bill->total) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">SC</th>
                    <td></td>
                    <td></td>
                    <?php if ($bill == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($bill->sc) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">PB1</th>
                    <td></td>
                    <td></td>
                    <?php if ($bill == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($bill->ppn) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="row">Total Payment</th>
                    <td></td>
                    <td></td>
                    <?php if ($bill == NULL): ?>
                        <td>Rp 0</td>
                    <?php else: ?>
                        <td>Rp <?= number_format($bill->total + $bill->sc + $bill->ppn) ?></td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
  <?php endforeach ?>
  

</div>




 
  <!-- <div id="payment">
    <form action="<?= base_url() ?>index.php/Bayar/submit" method="POST">
        <?php if ($order_bill == NULL): ?>
          <input type="hidden" id="amount" name="amount" value="0">
          <?php else: ?>
          <input type="hidden" id="amount" name="amount" value="<?= $order_bill->total + $order_bill->sc + $order_bill->ppn ?>">
          <?php endif;?>
      <button type="submit" style="float: right;" class="btn btn-outline-primary">Payment Now</button>
    </form>-->
  </div> 
</div>

<br>

<footer>
<div class="container text-center">
  <div class="row">
    <div class="col">
      <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-primary" id="btn_kiri_order">Add More Order</a>
      <a href="<?php echo base_url() ?>index.php/Kasir_waitress/memanggil/<?= $nomeja ?>" class="btn btn-outline-primary" id="btn_kiri_memanggil">Call Waitress</a>
    </div>
    
    <div class="col">
      <!-- <a href="<?php echo base_url() ?>Kasir_waitress/meminta/<?= $nomeja ?>" class="btn btn-outline-primary" id="btn_kanan_bill">Meminta Bill</a> -->
      <a href="<?= base_url() ?>index.php/selforder/home/<?= $nomeja ?>" class="btn btn-outline-primary" id="btn_kanan_awal" >Back to Main Page</a>
      
    </div>
  </div>
</div>
</footer>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="text-align: center;color: #223c77;" id="exampleModalLabel">Add Orders</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container text-center">
  <div class="row">
    <div class="col">
      <a href="<?= base_url() ?>index.php/ordermakanan/menu/Makanan/RAMEN#RAMEN"  style="padding-right: 48px;padding-left: 48px;"class="btn btn-outline-primary" id="btn_kiri_order">Add Food Order</a>
      
    </div>
    
    <div class="col">
      <a href="<?= base_url() ?>index.php/orderminuman/menu/Minuman/DRINKS#DRINKS" class="btn btn-outline-primary"  id="btn_kanan_bill">Add Drink Order</a>
      
      
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('template/footer') ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    // Fungsi untuk menutup semua dropdown kecuali yang diklik
    function closeOtherDropdowns(clickedDropdownId) {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach((dropdown) => {
            const dropdownId = dropdown.getAttribute('id');
            if (dropdownId !== clickedDropdownId) {
                const tableContainer = dropdown.querySelector('.table-container');
                tableContainer.style.display = 'none';
            }
        });
    }

    // Menambahkan event listener untuk setiap dropdown button
    const dropdownButtons = document.querySelectorAll('.dropdown .dropdown-toggle');
    dropdownButtons.forEach((button) => {
        button.addEventListener('click', function (event) {
            event.stopPropagation(); // Menghentikan event propagation agar tidak mencapai document
            const dropdownId = this.closest('.dropdown').getAttribute('id');
            const tableContainer = this.nextElementSibling;

            // Menutup dropdown yang lain
            closeOtherDropdowns(dropdownId);

            // Menampilkan atau menyembunyikan dropdown yang diklik
            if (tableContainer.style.display === 'none') {
                tableContainer.style.display = 'block';
            } else {
                tableContainer.style.display = 'none';
            }
        });
    });

    // Menutup dropdown saat klik di luar dropdown
    document.addEventListener('click', function () {
        closeOtherDropdowns(null);
    });
</script>

<!-- <script type="text/javascript">
  var amount = document.getElementById("amount");
  var payment = document.getElementById("payment");

  if (amount.value > 0) {
    payment.style.display = "block";
  } else {
    payment.style.display = "none"; 
  }
</script> -->

    