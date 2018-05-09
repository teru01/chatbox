<div class="article">
    <div class="article_content">
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($article['user_name']); ?>">
            <?php print $this->escape($article['user_name']); ?>
        </a>
        <?php print $this->escape($article['message']); ?>
    </div>
    <div>
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($article['user_name']); ?>/article/<?php print $this->escape($article['id']); ?>">
            <?php print $this->escape($article['time_stamp']); ?>
        </a>
    </div>
</div>