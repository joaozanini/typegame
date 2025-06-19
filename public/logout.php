<?php
session_start();
session_unset();
session_destroy();
header("Location: /typegame/public/index.php");
exit;