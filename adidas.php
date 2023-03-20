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
        <div class="box" style="margin:auto;margin-top:100px;border-top: 2px solid gray">
          <h1 id="adidas" class="src_title">ADIDAS</h1>
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

            $start = 0;  // Starting index
            $count = 0;   // Total number of items
            
            // Proceso adidas
            while (true) {
                $url = "https://www.adidas.mx/api/plp/content-engine?query=calzado-outlet&start=$start";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
                $html = curl_exec($curl);
            
                curl_close($curl);
            
                $data = json_decode($html, true);
                $count = $data['raw']['itemList']['count'];

                if (isset($data['raw']['itemList']['items'])) {
                  $items = $data['raw']['itemList']['items'];
                } else {
                  $items = [];
                }

              foreach($items as $item){
                  $prc = str_replace("%","",$item['salePercentage']);

                  if($prc >= 25){
                    echo "<tr>";
                    echo "<td title='Abrir imagen' onclick='imgZoom(\"" . $item['image']['src'] . "\")'><img src='" . $item['image']['src'] . "' style='cursor:zoom-in;max-width:100px;height:fit-content'></td>";
                    echo "<td>".$item['displayName']."</td>";
                    echo "<td>".$item['altText']."</td>";
                    echo "<td style='text-align:center;color:var(--lgray)'>$<s>".$item['price']."</s></td>";
                    echo "<td style='text-align:center;color:var(--green)'>".$item['salePercentage']."</td>";
                    echo "<td style='text-align:center;'>$".$item['salePrice']."</td>";
                    echo "<td style='text-align:center;min-width:100px'><a target='_blank' href='https://www.adidas.mx".$item['link']."' class='src_btn'>VER PRODUCTO</a></td>";
                    echo "</tr>";
                  }
                  
                }   
                if ($start >= $count) {
                  break;
                }
                $start += 59;
            }

?>

            </tbody>
            <tfoot>
              <tr>
              <th>IMAGEN</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>PRECIO</th>
                <th>DESCUENTO</th>
                <th>TOTAL</th>
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
  <p>Deportes Pepe &copy; <?php echo date('Y'); ?> | Dev by Psycho</p>
</footer>