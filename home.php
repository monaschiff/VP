<?php
  $username = "Mona";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  if($hournow < 6){
	  $partofday = "naptime";
  }//enne kuut
  if($hournow >= 8 and $hournow <= 18){
	  $partofday = "naptime läbi, mine kooli või tee miskit kasulikku";
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
  <p><?php echo "Hetkel on " .$partofday ."."; ?>
  </p>
</body>
</html>