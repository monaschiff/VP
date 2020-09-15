<?php
  //var_dump($_POST);
  require("../../../config.php");
  $database = "if20_mona_sch_1";
  //kui on idee sisestatud ja nupule vajutatud, salvestame selle andmebaasi
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //valmistan ette sql käsu
  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES (?)");
  echo $conn->error;
  //seome käsuga päris andmed
  //i-integer, d-decimal, s-string
  $stmt->bind_param("s", $_POST["ideainput"]);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  }
  
  
  //loen lehele olemasolevad mõtted
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  echo $conn->error;
  //seome tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  $ideahtml = "";
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }

  $username = "Mona";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  if($hournow < 8){
    $partofday = "naptime";
  }
  if($hournow > 8 and $hournow < 16){
    $partofday = "naptime läbi, mine kooli või tee miskit kasulikku";
  }
  if($hournow > 23){
    $partofday = "kell päris palju, peaksid end magama sättima";
  }
  if($hournow > 16 and $hournow < 19){
    $partofday = "koduste ülesannete aeg";
  }
  if($hournow > 19 and $hournow < 23){
    $partofday = "puhkamisaeg, oled olnud tubli";
  }
  
  //vaatame semestri kulgemist
  $semesterstart = new DateTime ("2020-8-31");
  $semesterend = new DateTime ("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new DateTime("now");
   $semesternow = $semesterstart->diff($today);
  $semesternowdays = $semesternow->format("%r%a");
  $partofsemester = "see on hetkel toimumas";
  if($semesternowdays < 0){
    $partofsemester = "see pole veel alanudki, pead veits ootama";
  }
  if($semesternowdays > $semesterdurationdays){
    $partofsemester = "see on läbi juba, pead järgmist ootama jääma";
  }
  $semesterpart = ($semesternowdays / $semesterdurationdays) * 100;
  $semesterdone = "$semesterpart %";
  if($semesterpart <= 0){
    $semesterdone = "0%";
  }
  if($semesterpart >= 100){
    $semesterdone = "100%, tubli töö";
  }
  
  //annan ette lubatud pildivormingute loendi
  $picfiletypes = ["image/jpeg", "image/png"];
  //loeme piltide kataloogi sisu ja näitame pilte
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  //var_dump($allfiles);
  $picfiles = [];
  //$picfiles = $allfiles, 2);
  foreach($allfiles as $thing){
	  //echo "../vp_pics/" .$thing;
	  $fileinfo = getImagesize("../vp_pics/" .$thing);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true){
		  array_push($picfiles, $thing);
	  }
  }
  //paneme kõik pildid ekraanile
  $piccount = count($picfiles);
  $imghtml = "";
  for($i = 0; $i < $piccount; $i ++){
	  $imghtml .= '<img src ="../vp_pics/' .$picfiles[$i] .'" ';
	  $imghtml .= 'alt="Tallinna Ülikool">';
  }
 ?>
 
 <!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title><?php echo $username; ?></title>

</head>
<body>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1>Mona</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Käesolev leht on loodud <?php echo $username; ?> poolt 2020 aastal veeboiprogrammeerimise kursuse sügissemestril <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Kui sul endal kalendrit või kella mingil põhjusel ei ole, siis siit näed väga täpselt lehe avamishetke ---> <?php echo $fulltimenow; ?></p>
  <p><?php echo "Hetkel on " .$partofday ."."; ?></p>
  <p><?php echo "Sügissemestriga on sellised lood, et " .$partofsemester ."."; ?></p>
  <p><?php echo "Semestrist on läbitud " .$semesterdone ."."; ?></p>
  <hr>
  <?php echo $imghtml; ?>
  <hr>
  <form method="POST">
    <label>Sisesta oma pähe tulnud mõte!</label>
	<input type="text" name="ideainput" placeholder="Kirjuta siia oma mõte">
	<input type="submit" name="ideasubmit" value="Saada mõte ära!">
  </form>
  <hr>
  <?php echo $ideahtml; ?>
  
</body>
</html>