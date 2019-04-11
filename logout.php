<html>
   <head>
      <title>Logging Out...................</title>
   </head>
   <body background="img/blyat1.jpg">
   </body>
</html>
<?php
   session_start();
   unset($_SESSION["userid"]);
   session_destroy();
   header('Refresh: 2; URL = index.php');
?>
