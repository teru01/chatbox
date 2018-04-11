<?php $this->setPageTitle('title', $user['user_name']); ?>
<h2><?php print $this->escape($user['user_name']); ?></h2>
<?php if (!is_null($following)): ?>
<?php if ($following): ?>
<p>フォロー中のユーザーです</p>
<?php else: ?>
<form action="<?php print $base_url; ?>/follow" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>">
    <input type="hidden" name="follow_user_name" value="<?php print $this->escape($user['user_name']); ?>">
    <input type="submit" value="フォローする">
</form>
<?php endif; ?>
<?php endif; ?>
<div id="statuses">
    <?php foreach ($statuses as $status): ?>
    <?php print $this->render('blog/status', ['status' => $status]); ?>
    <?php endforeach; ?>
</div>