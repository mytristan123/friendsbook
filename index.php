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
if (isset($_POST['name'])) {
 $name = $_POST['name'];
}

 /* PRINT THE FRIENDS OF FRIENDS.TXT */
$filename = 'friends.txt';
if ( (file_exists($filename)) && (is_readable($filename)) ){ 
   $content = file($filename); 
   foreach ($content as $line) {
	echo ("<li>" . $line . "</li>");
   }   
} 
else 
{ 
   echo 'The file '.$filename.'  do not exist or is not created'; 
} 


 /* WRITE THE FRIENDS IN FRIENDS.TXT */
$file = fopen( $filename, "a+" );
if( !feof($file) ) {

  /* TEST IF $NAME IS EMPTY OR NOT */
 if (isset($name)){
 echo "<li><b>$name</b></li>";
 fwrite( $file, "$name\n" );
 }
 fclose( $file );
}
echo "<br />";
?>




<?php
define('friends', 'friends.txt'); 
?>
<form method="POST">
    <input type="text" name="mot" value=""/>
    <input type="submit" value="Filter List" name="submit"/>
</form>
 
<?php
 if (isset($_POST['submit'])) {
    $resultats =array();
    @ $fp = fopen(friends, 'r') or die('Impossible to open "' . friends . '"  !');
    while (!feof($fp)) {
        $ligne = fgets($fp, 1024);
        if (preg_match('|\b' . preg_quote($_POST['mot']) . '\b|i', $ligne)) {
            $resultats[] = $ligne;
        }
    }
    fclose($fp);
    $nb = count($resultats);
    if ($nb > 0) {
        echo '<ul>';
        foreach ($resultats as $v) {
            echo "<li>$v</li>";
        }
        echo '</ul>';
    } else {
        die("Name not present");
    }
}
?>







</div>

</body>
</html>