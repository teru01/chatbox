<?php $this->setPageTitle('title', $user['user_name']); ?>
<div class="container">
<h2><?php print self::escape($user['user_name']); ?></h2>
<?php if (!is_null($following)): ?>
<?php if ($following): ?>
<p>フォロー中のユーザーです</p>
<?php else: ?>
<form action="<?php print $base_url; ?>/follow" method="post">
    <input type="hidden" name="_token" value="<?php print self::escape($_token); ?>">
    <input type="hidden" name="followed_user_name" value="<?php print self::escape($user['user_name']); ?>">
    <input type="submit" value="フォローする">
</form>
<?php endif; ?>
<?php endif; ?>
<div id="articles">
    <?php foreach ((array)$articles as $article): ?>
    <?php print $this->render('blog/article', ['article' => $article, 'reactions' => $reactions]); ?>
    <?php endforeach; ?>
</div>
</div>