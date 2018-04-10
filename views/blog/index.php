<?php
$this->setPageTitle('title', 'ユーザーのトップページ'); ?>
<form action="<?php print $base_url; ?>/status/post" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>">
    <?php if(isset($errors) && count($errors)): ?>
    <?php print $this->render('errors', ['errors' => $errors]); ?>
    <?endif; ?>
    <p>投稿する記事を入力:</p>
    <textarea name="message" rows="4" cols="70">
        <?php print $this->escape($message); ?>
    </textarea>
    <p><input type="submit" value="投稿"></p>
</form>
<hr>
<h2>記事一覧</h2>
<div id="statuses">
    <?php foreach ($statuses as $status): ?>
    <?php print $this->render('blog/status', ['status' => $status]); ?>
    <?php endforeach; ?>
</div>
