<?php
require '../bootstrap.php';
require '../BlogApp.php';
$app = new BlogApp(true);
$app->run();