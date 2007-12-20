<?php
setcookie ("lglogin", "", time() - 10800);
header("Location: ../index.php");
exit();
?>