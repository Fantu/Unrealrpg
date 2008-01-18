<?php
setcookie ("lglogin", "", time() - 10800);
echo "<script language=\"javascript\">window.location.href='../index.php'</script>";
exit();
?>