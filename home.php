<?php
  $username = "Mona";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  if($hournow < 8){
	  $partofday = "naptime";
  }//enne kuut
  if($hournow >= 8 and $hournow <= 16){
	  $partofday = "naptime läbi, mine kooli või tee miskit kasulikku";
  }
  if($hournow >= 23){
    $partofday = "kell päris palju, peaksid end magama sättima";
  }
  if($hournow > 16 and $hournow <= 19){
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

  
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title><?php echo $username; ?></title>

</head>
<body>
  <h1>Mona</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Käesolev leht on loodud <?php echo $username; ?> poolt 2020 aastal veeboiprogrammeerimise kursuse sügissemestril <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Kui sul endal kalendrit või kella mingil põhjusel ei ole, siis siit näed väga täpselt lehe avamishetke ---> <?php echo $fulltimenow; ?></p>
  <p><?php echo "Hetkel on " .$partofday ."."; ?></p>
  <p><?php echo "Sügissemestriga on sellised lood, et " .$partofsemester ."."; ?></p>
  <p><?php echo "Semestrist on läbitud " .$semesterdone ."."; ?></p>
</body>
</html>