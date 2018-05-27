<?php
$this->setPageTitle('title', 'ユーザーのトップページ'); ?>

<p>投稿する:</p>
<?php echo exec('whoami');?>
<?php echo exec('groups');?>
<form action="<?php print $base_url; ?>/article/post" method="post" class="container">
    <input type="hidden" name="_token" value="<?php print self::escape($_token); ?>">
    <?php if(isset($errors) && count($errors)): ?>
    <?php print $this->render('errors', ['errors' => $errors]); ?>
    <?php endif; ?>
    <textarea name="message" rows="4" cols="70" class="container"><?php print self::escape($message); ?></textarea>
    <p><input class="btn-info" type="submit" value="投稿"></p>
</form>
<hr>
<h2>記事一覧</h2>
<div id="articles" class="container" >
    <?php foreach ((array)$articles as $article): ?>
    <?php print $this->render('blog/article', ['article' => $article, 'reactions' => $reactions]); ?>
    <?php endforeach; ?>
</div>


