<?php $this->load->view('template/head') ?>
    <style type="text/css">
      .my-popup-class {
        z-index: 10000001;
      }
    @media (max-width: 414px) {
        .md {
       margin-top: 35px;
       top: 10px;
       right: 100px;
       width: 385px;
       height:600px;
       bottom: 0;
       z-index: 9998;
       left: 0;
       overflow: auto;
       overflow-y: auto;
    }
        }
          
        /* Media Query for low resolution  Tablets, Ipads */
        @media (min-width: 397px) {
            .md {
       margin-top: 30px;
       top: 10px;
       right: 100px;
       width: 395px;
       height:610px;
       bottom: 0;
       z-index: 9998;
       left: 0;
       overflow: auto;
       overflow-y: auto;
    }
        }
      @media (min-height: 640px) {
        .md {
       margin-top: 50px;
       top: 10px;
       right: 0px;
       width: 350px;
       height:515px;
       bottom: 0;
       z-index: 9998;
       left: 5px;
       overflow: auto;
       overflow-y: auto;
    }
    .mdl {
       margin-top: 205px;
       top: 10px;
       right: 0px;
       width: 340px;
       height:515px;
       bottom: 0;
       z-index: 9998;
       left: 10px;
       overflow: auto;
       overflow-y: auto;
    }

    #imgmodal{
        width: 150px;height: 100px;border-radius: 20px; display: block;margin-left: auto;margin-right: auto;
    }
    #description{
        color: #223c77;float: left;font-size: 15px;
    }
    /*#product_info{
        color: #223c77;margin-top: 2px;float: left;font-size: 15px;
    }*/
    #harga{
        color: #223c77;margin-top: 2px;float: right;font-size: 15px;
    }
    #option{
      float: left;color: #223c77;font-size: 15px;
    }
    .modalbutton{
      padding-left: 45px;padding-right: 45px;
    }
      }
        @media (min-height: 720px) {
            .md {
       margin-top: 85px;
       top: 10px;
       right: 0px;
       width: 350px;
       height:540px;
       bottom: 0;
       z-index: 9998;
       left: 17px;
       overflow: auto;
       overflow-y: auto;
    }
    .mdl {
       margin-top: 220px;
       top: 10px;
       right: 0px;
       width: 350px;
       height:515px;
       bottom: 0;
       z-index: 9998;
       left: 17px;
       overflow: auto;
       overflow-y: auto;
    }
    #imgmodal{
        width: 170px;height: 120px;border-radius: 20px; display: block;margin-left: auto;margin-right: auto;
    }
    #description{
        color: #223c77;float: left;font-size: 15px;
    }
    /*#product_info{
        color: #223c77;margin-top: 2px;float: left;font-size: 15px;
    }*/
    #harga{
        color: #223c77;margin-top: 2px;float: right;font-size: 15px;
    }
    #option{
      float: left;color: #223c77;font-size: 15px;
    }
        }
          
        /* Media Query for Tablets Ipads portrait mode */
        @media (min-width: 768px) and (max-width: 1024px){
            

        }
          
        /* Media Query for Laptops and Desktops */
        @media (min-width: 1025px) and (max-width: 1280px){
            
        }
        
      .button {
  background-color: white;
  color: #223c77;
  
  padding:16px 30px;
  text-align: center;

  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  transition-duration: 0.4s;
}

.active{
   background-color: lightblue;
  color: black;
  
  padding:16px 30px;
  text-align: center;
  border-radius: 10px;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  transition-duration: 0.4s;
  background-size: 55%;
  background-position-y: 20%;
  background-position-x: 50%;
}

.button:hover {
  /*background-color: #223c77;*/ /* Green */
  border-radius: 10px;
  color: #223c77;
}
.wrapper{
  max-height: 120px;
  /*padding-bottom: 60px;*/
  margin-bottom: 25px;
  display: flex;
  overflow: scroll;
  background-color: white;
  overflow-x: auto;
  white-space: nowrap; 
  margin-top: 10px;
}
.wrapper .item{
  
  text-align: center;
  background-color: #ddd;
  margin-right: 2px;
  display: inline-block; /* Menampilkan elemen "item" dalam satu baris */
    margin-right: 10px;
}
.RAMEN{
   background-image: url("<?= base_url() ?>/assets/icon/ramenset.png");
  background-repeat: no-repeat;
  background-size: 70%;
  background-position-y: 20%;
  background-position-x: 50%;
}
.GYOZA{
   background-image: url("<?= base_url() ?>/assets/icon/gyoza.png");
  background-repeat: no-repeat;
  background-size: 80%;
  background-position-y: 20%;
  background-position-x: 50%;
}

footer{
  text-align: center;
  background-color: white;
  margin-top: 10px;
  border-top-right-radius: 10%;
  border-top-left-radius: 10%;
  /*position: absolute;*/
  bottom: 0;
  width: 100%;
  position: fixed;
  z-index: 200000;
}
.load{
    background: rgba(0,0,0,0.7);
    height: 100vh;
    width: 100%;
    position: fixed;
    z-index: 1000000;
  }

   #loading{
    width: 50px;
    height: 50px;
    border:solid 5px #ccc;
    border-top-color: #223c77;
    border-radius: 100%;

    position: fixed;
    left: 0;
    top: 0;
    right:0;
    bottom: 0;
    margin: auto;
    z-index: 10000001;

    animation: putar 1s linear infinite;
  }

  @keyframes putar{
    from{transform: rotate(0deg);}
    to{transform: rotate(360deg);}
  }
  .sold{
    
    border-radius: 10px;
    position: fixed;
    z-index: 1000;
  }
  .soldtext{
    position:absolute;top: 30%; left:50%;transform:translate(-50%,-50%);text-align:center;color: red;font-weight: bold;font-size: 30px;
  }
    </style>

<div id="loading"></div>
<div id="load"></div>
<div id="loadingkonek"></div>

    <nav style="z-index: 10000;position: fixed;width: 100%;background-color:#223c77">
  <div class="container">
  <div class="row">
    <div class="col-9"><p style="padding-top: 13px;color: white;">Package Menu</p></div>
    <div class="col-1" style="z-index: 10040000;"><a style="text-align: center;margin-top: 6px;" href="<?php echo base_url() ?>index.php/Cart/home/<?= $nomeja ?>/Makanan/" class=""><svg xmlns="http://www.w3.org/2000/svg" width="25" height="23" color="white" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" style="margin-right: 10px;margin-top: 12px;margin-left: 10px;">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg></a></div>
<!-- <div class="col-1"><strong><h3 style="color: white;font-size: 10px;margin-top: 6px;background-color: red;border-radius: 40%;text-align: center;"><b id="cart_count"><?= $cart_count ?></b></h3></strong></div> -->
<div class="col-1"><strong><h3 style="color: white;font-size: 10px;margin-top: 6px;background-color: red;border-radius: 40%;text-align: center;"><b id="total_qty_header"><!-- <?= $total_qty;?> --></b></h3></strong></div>
  </div>
  </div>
  <div style="width: 100%; height: 0px; border: 1px #000 solid;">
</div>
</nav>
<br>

<header style="display: flex;width:100%; position: fixed;z-index: 100000;margin-top: 30px;background-color: white;border-bottom-right-radius: 5%;
  border-bottom-left-radius: 5%;">

<div class="container" style="padding-top: 20px;margin-top:5px;background-color: #223c77;border-radius: 5px 5px 5px 5px;">
  <label style="color: white;">Package Name</label>
  <select name="paket" class="form-control" id="paket"  onchange='paketValue(this.value)'>
    <option value=" " selected="" disabled="">Select Pakcage</option>
    <?php
                $con = mysqli_connect("localhost", "root","", "hachi_daisuki_veteran");
                $result = mysqli_query($con, "select b.sub_category,b.max_qty,a.* from sh_m_item a INNER JOIN sh_m_item_packages b ON a.description = b.package_name group by description");
                $jsArrayPaket = "var prdNamePaket = new Array();\n";
                                
                while ($row = mysqli_fetch_array($result)) {
                echo '<option name="paket"  value="' . $row['description'] . '">' .$row['description']. '</option>';
                  $jsArrayPaket .= "prdNamePaket['" . $row['description'] . "'] = {harga_weekday:'".addslashes($row['harga_weekday'])."',item_code:'".addslashes($row['description'])."',qty:'".addslashes($row['max_qty'])."',description:'".addslashes($row['no'])."'};\n";
                }
            ?>
  </select>
  <label style="color: white;"> Package Price</label>
  <input type="text" name="harga_paket" id="harga_paket" class="form-control" readonly="">
  <!-- <label style="color: white;">Qty Paket <label style="color: red">*</label></label>
  <input type="text" name="qty_paket" id="qty_paket" class="form-control" required=""> -->
  <input type="hidden" id="item_code" class="form-control" readonly="">
  <input type="hidden" name="item_code" id="paket_name" class="form-control" readonly="">
  <input type="hidden" name="qtylimit" id="qtylimit" class="form-control" readonly="">
  <input type="hidden" name="qtyadd" id="qtyadd" class="form-control" readonly="">
  <input type="hidden" name="subklik" id="subklik" class="form-control" readonly="">
  <div class="wrapper" style="background-color: #223c77;">
      <div id="sub"> </div>
  </div>
</div>
</header>

<!-- <?= base_url() ?>orderpaket/addcart/<?= $nomeja ?> -->
<form action="#" method="post"> 
<div class="container text-center" style="margin-top: 140px;">
  <div class="row row-cols-2">
    

</div>
<div id="konten">
  
</div>



<footer>
<div class="container text-center">
<!-- <button type="submit" class="btn btn-outline-success" style="padding-top: 20px;padding-bottom: 20px;padding-left: 50px;padding-right: 50px;">
  Order 
</button> -->
<a href="<?php echo base_url() ?>index.php/Cart/home/<?= $nomeja ?>/Orderpaket/" class="btn btn-outline-primary" style="padding-top: 20px;padding-bottom: 20px;padding-left: 40px;padding-right: 40px;">Cart<i class="fa fa-cart-plus"></i> <b id="total_qty" align="right"><?= $total_qty;?></b></a>
<a href="<?php echo base_url('') ?>index.php/selforder/home/<?= $nomeja ?>" class="btn btn-outline-danger" style="padding-top: 20px;padding-bottom: 20px;padding-left: 40px;padding-right: 40px;">Back</a>
</form>


<br>
</div>
</footer>
<!-- Modal -->

  <script src="<?= base_url();?>/assets/bootstrap/js/jQuery3.5.1.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script type="text/javascript">
  var loading = document.getElementById('loading');
  $(document).ready(function(){
    load = document.querySelector('#load');
    load.classList.add('load');
  });
  setTimeout(berhenti,1000);
  function berhenti() {
    loading.style.display = "none";
   $("#loading").fadeOut();
   $("#load").fadeOut();
  }
  $('#paket').change(function() {
    if ($(this).val() != null) {
        $('#sub_category').prop('hidden', false);
    }else {
        $('#sub_category').prop('hidden', true);
    }
      var item_code = document.getElementById("item_code");
      $.ajax({
          url: '<?php echo base_url("index.php/Orderpaket/getsub"); ?>',
          type: 'POST',
          dataType: "json",
          data: {
              item_code: item_code.value,
          },
          success: function(response) {
              $('#sub').empty();
                for (var i = 0; i < response.length; i++) {
          //         var option = '<div class="item" style="border-radius: 10px;"><a href="#' + response[i].sub_category.replace(/ /g, '_') + '" id="' + response[i].sub_category.replace(/ /g, '_') + '" class="button '+ response[i].sub_category.replace(/ /g, '_') +' test'+ response[i].sub_category.replace(/ /g, '_') +'" style="text-decoration:none;border-radius: 10px;"><label style="margin-top: 60px;margin-bottom: 1px;">' + response[i].sub_category +  '</label></a></div>';
          //     $('#sub').append(option);
          //     $('#' + response[i].sub_category.replace(/ /g, '_')).click(function() {
          //     $('.item a').removeClass('active');
          //     $(this).addClass('active');
          //     var loading = document.getElementById('loading');
          //     loading.style.display = "flex";
          //     $("#loading").fadeIn();
          //     $(".load").fadeIn();
              
          //     var sb = document.getElementById("paket").value;
          //     var h = '<?= base_url() ?>orderpaket/menupaket/' + sb.replace(/ /g, '_') + '/' + response[i].sub_category.replace(/ /g, '_');
          //     // console.log(h);
          //     $('#konten').load(h);
          // });
    (function(index) {
    var elementId = response[index].sub_category.replace(/ /g, '_');
    var option = '<div class="item" style="border-radius: 10px;"><a href="#' + elementId + '" id="' + elementId + '" class="button '+ elementId +' test'+ elementId +'" style="text-decoration:none;border-radius: 10px;"><label style="margin-top: 60px;margin-bottom: 1px;">' + response[index].sub_category + '</label></a></div>';
    
    $('#sub').append(option);
    
    $('#' + elementId).click(function() {
        $('.item a').removeClass('active');
        $(this).addClass('active');
        var loading = document.getElementById('loading');
        var qtylimit = document.getElementById('qtylimit');
        var subklik = document.getElementById('subklik');
        qtylimit.value = response[index].max_qty;
        loading.style.display = "flex";
        $("#loading").fadeIn();
        $(".load").fadeIn();
        
        var sb = document.getElementById("paket").value;
        subklik.value = elementId;
        var h = '<?= base_url() ?>index.php/orderpaket/menupaket/' + sb.replace(/ /g, '_') + '/' + elementId;
        // console.log(h);
        qtyadd = document.querySelector('#qtyadd');
        subklik = document.querySelector('#subklik');
        if (localStorage.getItem(subklik.value)) {
          qtyadd.value = parseInt(localStorage.getItem(subklik.value));
        }else{
          qtyadd.value = 0;
        }
        $('#konten').load(h);
    });
})(i);
 // Memanggil fungsi penutupan dengan nilai i sebagai argumen
}

              // console.log(response);
          },
          error: function(xhr, status, error) {
                            // Aksi yang akan dilakukan jika terjadi kesalahan
              // console.log(xhr.responseText);
          }
      });
  });
</script>

<script type="text/javascript">
        <?php echo $jsArrayPaket; ?>
        function paketValue(id){
          document.getElementById('harga_paket').value = prdNamePaket[id].harga_weekday;
          document.getElementById('item_code').value = prdNamePaket[id].item_code;
          document.getElementById('paket_name').value = prdNamePaket[id].description;
        }
</script>
<?php foreach ($sub as $i ): ?>
<script type="text/javascript">
      $(document).ready(function(){

        var key = "<?= $key ?>";
        if (key != '') {
          $('#konten').load('<?= base_url() ?>index.php/orderpaket/search/1');
        }
         if (window.location.toString() == "<?= base_url() ?>index.php/orderpaket#<?= str_replace(" ","%20", $i['sub_category']) ?>") {
          // console.log('berhasil');
          $('#konten').load('<?= base_url() ?>index.php/orderpaket/menu/<?= str_replace(" ","%20", $i['sub_category']) ?>#<?= str_replace(" ","_", $i['sub_category']) ?>');
         }else if (window.location.toString() == "<?= base_url() ?>index.php/orderpaket/menu/rekomendasi#rekomendasi") {
          $('#konten').load('<?= base_url() ?>orderpaket/menu/rekomendasi#rekomendasi');
         }
          

        
      });
    </script>
<?php endforeach ?>


  <?php $this->load->view('template/footer') ?>
  