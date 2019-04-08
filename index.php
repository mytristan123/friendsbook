<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css" /> 
  </head>
  <body>

  <div class="content">
  
  
<form action="index.php" id="test" method="post">
Name: <input type="text" name="name">
<input type="submit" value="submit">
</form>

<?php


echo "<h1>My best friends : </h1>";

$filename = 'friends.txt';
$friendsB = [];

 /* PRINT THE FRIENDS OF FRIENDS.TXT */
      if(file_exists($filename)) {
        $file = fopen($filename, "r");
        while (!feof($file)) {
          $line = fgets($file);
          if(!empty(trim($line))) {
            array_push($friendsB, $line);
          }
        }
        fclose($file);
      }

      if(isset($_POST['name']) && !empty(trim($_POST['name']))) {
        array_push($friendsB, trim($_POST['name']));
      }
 /* DELETE A FRIEND */
      if (isset($_POST['delete'])) {
        $indexToBeRemoved = $_POST['delete'];
        unset($friendsB[$indexToBeRemoved]);
        $friendsB = array_values($friendsB);
      }
	  
	  
	  /* WRITE THE FRIENDS IN FRIENDS.TXT */
      $file = fopen($filename, "w");
      if(!empty($friendsB)) {
        foreach($friendsB as $name) {
          fwrite($file, $name."\n");
        }
      }
      fclose($file);
?>






<form action="" method="post">
    <ul>
      <?php
$nameFilter = '';
$startingWith = '';
        if(!empty($friendsB)) {
          $counter = 0;
          foreach($friendsB as $name) {
            if(isset($_POST['nameFilter']) && !empty(trim($_POST['nameFilter']))) {
              if(isset($_POST['startingWith']) && $_POST['startingWith'] == 'TRUE') {
                if(substr($name, 0, strlen($_POST['nameFilter'])) == $_POST['nameFilter']) {
                  echo (!empty(trim($name))) ? '<li>'.$name.'  <button type="submit" name="delete" value="'.$counter.'"> Delete </button></li>' : '';
                }
                $startingWith = 'TRUE';
              }
              else {
                if(strstr($name, $_POST['nameFilter'])) {
                  echo (!empty(trim($name))) ? '<li>'.$name.'  <button type="submit" name="delete" value="'.$counter.'"> Delete </button></li>' : '';
                }
              }
              $nameFilter = $_POST['nameFilter'];
            }
            else {
              echo (!empty(trim($name))) ? '<li>'.$name.'  <button type="submit" name="delete" value="'.$counter.'"> Delete </button></li>' : '';
            }
          $counter++;
          }
        }
      ?>

    </ul>
  </form>

  <form action="" method="post">
      <input type="text" name="nameFilter" value="<?=$nameFilter?>">
      <input type="submit" value="Filter List">
      <input type="checkbox" name="startingWith" <?php if ($startingWith=='TRUE') echo "checked";?> value="TRUE"> Only names starting with </input>
  </form>





</div>

</body>
</html>