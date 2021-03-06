<?php $this->setPageTitle('title', 'アカウントを作成') ?>
<h1 class="page_title">ユーザーアカウントを作成</h1>
<div class="container">
<form action="<?php print $base_url; ?>/account/register" method="post">
    <input type="hidden" name="_token" value="<?php print self::escape($_token); ?>">
    <?php if(isset($errors) && count($errors) > 0): ?>
    <?php print $this->render('errors', ['errors' => $errors]); ?>
    <?php endif; ?>
    <?php print $this->render('account/inputs',
        [
            'user_name' => $user_name,
            'password'  => $password,
        ]); ?>
    <p><input class="btn-info" type="submit" value="登録"></p>
</form>
</div>
