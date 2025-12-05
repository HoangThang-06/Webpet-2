<?php
session_start();
session_unset();
session_destroy();
header("Location: /Webpet-2/app/View/user/index.php");
exit();
?>