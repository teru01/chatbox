<?php $this->setPageTitle('title', $user['user_name']); ?>
<h2><?php print $this->escape($user['user_name']); ?></h2>
<div id="statuses">
    <?php foreach ($statuses as $status): ?>
    <?php print $this->render('blog/status', ['status' => $status]); ?>
    <?php endforeach; ?>
</div>