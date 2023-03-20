<?php 
//set_time_limit(1000);
/*register_shutdown_function(function() {
  echo "<script>alert('The time limit has been exceeded.');</script>";
});
*/
?>
<!DOCTYPE html>
<head>
  <title>Scrapping Nike - Adidas</title>
  <!-- GENERAL -->
  <meta charset="UTF-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="Psycho">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- STYLES -->
  <link rel="stylesheet" href="assets/css/main_style.css?v=<?php echo rand(); ?>">
  <link rel="stylesheet" href="assets/css/mobile_style.css">
  <link rel="stylesheet" href="assets/css/tablet_style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slides-style.css">
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
  <!-- JS -->
  <script src="assets/js/main_script.js?v=<?php echo rand(); ?>"></script>
  <!-- DATATABLE -->
  <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <link rel='stylesheet' href='https://cdn.datatables.net/1.12.1/css/dataTables.jqueryui.min.css'>

</head>
<body>
  <!-- LOADER -->
  <iframe class="loader" src="loading.html" frameborder="0"></iframe>
    <nav id="nav">
        <div class="cont_nav">
            <div>
                <!--<img src="assets/img/dpp.png" alt="" class="nav_logo">-->
            </div>
            <div style="float:right">
                <!--<a class="btn_nb" onclick="scrollToId('nike')">NIKE</a>
                <a class="btn_nb" onclick="scrollToId('adidas')">ADIDAS</a>-->
                <a class="btn_nb" href="index.php" >NIKE</a>
                <a class="btn_nb" href="adidas.php">ADIDAS</a>
            </div>
        </div>
    </nav>
    <section class="content" style="display:block">
        <div class="box" style="margin:auto;margin-top:100px">
          <h1 id="nike" class="src_title">NIKE</h1>
          <table id="tablagral" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>IMAGEN</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>PRECIO</th>
                <th>DESCUENTO</th>
                <th>TOTAL</th>
                <th></th>
              </tr>
            </thead>
            <tbody>      
              
            <?php
              $count = 60;
              $anchor = 0;
              $country = 'mx';
              $country_language = 'es-419';

              $urlp = "https://api.nike.com/cic/browse/v2?queryid=products&anonymousId=BBE480E26DAA83E45BDF5C1D37092E51&country=mx&endpoint=%2Fproduct_feed%2Frollup_threads%2Fv2%3Ffilter%3Dmarketplace(MX)%26filter%3Dlanguage(es-419)%26filter%3DemployeePrice(true)%26filter%3DattributeIds(16633190-45e5-4830-a068-232ac7aea82c%2C5b21a62a-0503-400c-8336-3ccfbff2a684)%26anchor%3D24%26consumerChannelId%3Dd9a5bc42-4b9c-4976-858a-f159cf99c647%26count%3D24&language=es-419&localizedRangeStr=%7BlowestPrice%7D%20%E2%80%94%20%7BhighestPrice%7D";
              $html_prods = file_get_contents($urlp);
              $out_prods = json_decode($html_prods, true);
              $total_prods = $out_prods['data']['products']['pages']['totalResources'];

              for($anchor; $anchor < $total_prods; $anchor+=60){
                $url = "https://api.nike.com/cic/browse/v2?queryid=products&anonymousId=BBE480E26DAA83E45BDF5C1D37092E51&country=mx&endpoint=%2Fproduct_feed%2Frollup_threads%2Fv2%3Ffilter%3Dmarketplace(MX)%26filter%3Dlanguage(es-419)%26filter%3DemployeePrice(true)%26filter%3DattributeIds(16633190-45e5-4830-a068-232ac7aea82c%2C5b21a62a-0503-400c-8336-3ccfbff2a684)%26anchor%3D$anchor%26consumerChannelId%3Dd9a5bc42-4b9c-4976-858a-f159cf99c647%26count%3D$count&language=es-419&localizedRangeStr=%7BlowestPrice%7D%20%E2%80%94%20%7BhighestPrice%7D";

                $html = file_get_contents($url);
                $output = json_decode($html, true);

                foreach ($output['data']['products']['products'] as $item) {
                  $total = $item['price']['fullPrice'];
                  $current = $item['price']['currentPrice'];
                
                  $discount = ($total - $current) / $total;
                  $discount = floor($discount * 100);
                
                  if($discount >= 25 && $item['inStock'] == true){
                    echo "<tr>";
                    echo "<td title='Abrir imagen' onclick ='imgZoom(\"" . $item['images']['squarishURL'] . "\")' style='cursor:zoom-in;margin:auto;text-align:center'><img src=\"".$item['images']['squarishURL']."\" width='100' /></td>";
                    echo "<td>".$item['title']."</td>";
                    echo "<td>".$item['subtitle']."</td>";
                    echo "<td style='color:var(--lgray);text-align:center'><s>".$total."</s></td>";
                    echo "<td style='color:var(--green);text-align:center'>".$discount."%</td>";
                    echo "<td>$".$item['price']['currentPrice']."</td>";
                    $link = str_replace("{countryLang}","",$item['url']);
                    echo "<td style='text-align:center;min-width:100px'><a target='_blank' href='https://www.nike.com/mx".$link."' class='src_btn'>VER PRODUCTO</a></td>";
                    echo "</tr>";
                  }
                }
              }
            ?>      
            </tbody>
            <tfoot>
              <tr>
                <th>IMAGEN</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>DESCUENTO</th>
                <th>PRECIO</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
        
</section>

<div id="bgImg" onclick="closeImg()"></div>
<button id="closeBtn" onclick="closeImg()" value="Cerrar">Cerrar</button>
<div id="imgContainer"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script>
<script src='https://code.jquery.com/jquery-3.5.1.js'></script>
<script src='https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.12.1/js/dataTables.jqueryui.min.js'></script>
<script>
$(document).ready(function() {
            $('table.display').DataTable(
            {language: {
                "url":"//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            },
            dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'print'
            ]
            ,
            "paging": true,
            "autoWidth": true,
            }
            );
            }); 

function imgZoom(src){
  document.getElementById('bgImg').style.display = 'block';
  document.getElementById('closeBtn').style.display = 'block';
  document.getElementById('imgContainer').style.display = 'block';

  var div = document.getElementById("imgContainer");
  var img = document.createElement("img");

  document.getElementById("imgContainer").appendChild(img);
  img.src = src;
  img.id = "imgTemp";
}
document.querySelector("bgImg").addEventListener("click", imgClose());
function closeImg(){
  document.getElementById('bgImg').style.display = 'none';
  document.getElementById('closeBtn').style.display = 'none';
  document.getElementById('imgContainer').style.display = 'none';

  var img = document.getElementById("imgTemp");
  var parent = img.parentNode;
  parent.removeChild(img);
}

</script>

</body>
<footer>
  <p>Todos los derechos reservados a sus respectivos dueños.</p>
  <p>&copy; <?php echo date('Y'); ?> | Dev by Psycho</p>
</footer>