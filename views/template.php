<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        <?php if(isset($title)): print $this->escape($title) . ' - '; endif; ?>
        Weblog
    </title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div id="header">
    <h1><a href="<?php print $base_url; ?>/">--Weblog--</a></h1>
</div>
<div id="nav">
    <p>
        <?php if($session->isAuthenticated()): ?>
        <a href="<?php print $base_url; ?>/">
            トップページ
        </a>
        <a href="<?php print $base_url; ?>/account">
            アカウント
        </a>
        <?php else: ?>
        <a href="<?php print $base_url; ?>/account/signin">
            サインイン
        </a>
        <a href="<?php print $base_url; ?>/account/signup">
            アカウントを作成
        </a>
        <?php endif; ?>
    </p>
</div>

<div id="main">
    <?php print $_content; ?>
</div>
</body>
</html>
