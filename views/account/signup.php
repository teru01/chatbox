<?php $this->setPageTitle('title', 'アカウントを作成') ?>
<h2>ユーザーアカウントを作成</h2>
<form action="<?php print $base_url; ?>/account/register" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape($token); ?>">
    <?php if(isset($errors) && count($errors) > 0): ?>
    <?php print $this->render('errors', ['errors' => $errors]); ?>
    <?php endif; ?>
</form>
