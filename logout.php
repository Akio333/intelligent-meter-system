<html>
   <head>
      <title>Signing out</title>
   </head>
   <body style="background-image: url('img/blyat.gif');
    background-size: cover;
    background-repeat: no-repeat;">
   </body>
</html>
<?php
   session_start();
   unset($_SESSION["userid"]);
   session_destroy();
   header('Refresh: 5; URL = index.php');
?>
