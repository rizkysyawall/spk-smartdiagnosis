<?php
//-- database configurations
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$dbname='db_expert';
//-- database connections
$db=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
//-- halt and show error message if connection fail
if ($db->connect_error) {
    die('Connect Error ('.$db->connect_errno.')'.$db->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Starter Template - Materialize</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="red lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a href="#" style="font-size: 45px"> Smart Diagnosis</a>
      <a href="index.php" class="right">Home</a>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <h3 class="center">FORM DIAGNOSA PENYAKIT GINJAL</h3>
      <h6>Isi gejala sedetail mungkin untuk hasil yang lebih akurat</h6>
      <br>
    <form method="post" class="col l12">
      <!-- menampilkan daftar gejala-->
      <?php
      $sqli="SELECT * FROM ds_evidences";
      $result=$db->query($sqli);
      while($row=$result->fetch_object()){
      ?>
    <div class="row">
        <div class="col l4">
          <input type="checkbox" name="evidence[]" id="<?php echo $row->id ?>" value="<?php echo $row->id ?>" <?php echo "".(isset($_POST['evidence'])?(in_array($row->id,$_POST['evidence'])?" checked":""):"")
          ?>/>
          <label for="<?php echo $row->id ?>"><?php echo $row->name ."<br>";?>
        </div>
    </div>

    <?php
      }
    ?>
    <center><input type="submit" value="proses" class="waves-effect waves-light btn red"></center>
    </form>
  </div>
  </div>



  <?php
  //-- Mengambil Nilai Belief Gejala Yang dipilih
  if(isset($_POST['evidence'])){
      if(count($_POST['evidence'])<2){
          echo "Pilih minimal 2 gejala";
      }else{
        $haha= $_POST['evidence'];
        $arrlength = count($haha);?>
        <div class="container">
        <div class="row">
            <div class="card-panel red lighten-1">
              <span class="white-text">Gejala yang anda rasakan:</br></span>

              <?php
              for ($x=0; $x<$arrlength; $x++){
                $sqli= "SELECT name FROM ds_evidences WHERE id=$haha[$x]";
                $result= $db->query($sqli);
                while($row=$result->fetch_object()){
                  echo "<span class='white-text'>-<b>".$row->name."</b></br></span>";
                }
              }?>
          </div>
        </div>
        </div>
        <?php
          $sql = "SELECT GROUP_CONCAT(b.code), a.cf
              FROM ds_rules a
              JOIN ds_problems b ON a.id_problem=b.id
              WHERE a.id_evidence IN(".implode(',',$_POST['evidence']).")
              GROUP BY a.id_evidence";
          $result=$db->query($sql);
          $evidence=array();
          while($row=$result->fetch_row()){
              $evidence[]=$row;
          }
          //--- menentukan environement
          $sql="SELECT GROUP_CONCAT(code) FROM ds_problems";
          $result=$db->query($sql);
          $row=$result->fetch_row();
          $fod=$row[0];

          //--- menentukan nilai densitas

          $densitas_baru=array();
          while(!empty($evidence)){
              $densitas1[0]=array_shift($evidence);
              $densitas1[1]=array($fod,1-$densitas1[0][1]);
              $densitas2=array();
              if(empty($densitas_baru)){
                  $densitas2[0]=array_shift($evidence);
              }else{
                  foreach($densitas_baru as $k=>$r){
                      if($k!="&theta;"){
                          $densitas2[]=array($k,$r);
                      }
                  }
              }
              $theta=1;
              foreach($densitas2 as $d) $theta-=$d[1];
              $densitas2[]=array($fod,$theta);
              $m=count($densitas2);
              $densitas_baru=array();
              for($y=0;$y<$m;$y++){
                  for($x=0;$x<2;$x++){
                      if(!($y==$m-1 && $x==1)){
                          $v=explode(',',$densitas1[$x][0]);
                          $w=explode(',',$densitas2[$y][0]);
                          sort($v);
                          sort($w);
                          $vw=array_intersect($v,$w);
                          if(empty($vw)){
                              $k="&theta;";
                          }else{
                              $k=implode(',',$vw);
                          }
                          if(!isset($densitas_baru[$k])){
                              $densitas_baru[$k]=$densitas1[$x][1]*$densitas2[$y][1];
                          }else{
                              $densitas_baru[$k]+=$densitas1[$x][1]*$densitas2[$y][1];
                          }
                      }
                  }
              }
              foreach($densitas_baru as $k=>$d){
                  if($k!="&theta;"){
                      $densitas_baru[$k]=$d/(1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0));
                  }
              }
          }

          //--- perangkingan

          unset($densitas_baru["&theta;"]);
          arsort($densitas_baru);

          //--- menampilkan hasil akhir

          $codes=array_keys($densitas_baru);
          $final_codes=explode(',',$codes[0]);
          $sql="SELECT GROUP_CONCAT(name)
          FROM ds_problems
          WHERE code IN('".implode("','",$final_codes)."')";
          $result=$db->query($sql);
          $row=$result->fetch_row();?>
          <div class="container">
          <div class="row">
              <div class="card-panel red lighten-1">
                <span class="white-text"><?php echo "Kemungkinan penyakit anda:</br>"; ?></span>
                <span class="black-text"> <?php echo "<b>{$row[0]}</b></br>"; ?></span>
              </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
              <div class="card-panel red lighten-1">
                <span class="white-text"><?php echo "</br>Kepercayaan :"."  ".round($densitas_baru[$codes[0]]*100,2)."%";?></span>
                <span class="black-text"> <?php echo  "</br></br><b>"."INFORMASI: Untuk mengetahui lebih jelas tentang penyakit yang anda derita, silahkan konsultasi lebih lanjut ke dokter atau rumah sakit"."</b>";?></span>
              </div>
            </div>
        </div>

        <?php
           }
         }
        ?>

    <footer class="page-footer red">
      <div class="container">
        <div class="row">
          <div class="col 9 s12">
            <h5 class="white-text">Website Bio</h5>
            <p class="grey-text text-lighten-4">Website ini merupakan implementasi dari kecerdasan tiruan yang semakin berkembang, dan merupakan tugas kuliah kami di universitas budi luhur jakarta.</p>
          </div>

        </div>
      </div>

      <div class="footer-copyright">
        <div class="container">
        Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Muhammad Rizky Syawalludin & Tim</a>
        </div>
      </div>
    </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

</body>
</html>
