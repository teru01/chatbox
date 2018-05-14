<div class="article">
    <div class="article_content">
        <p>
            <a href="<?php print $base_url; ?>/user/<?php print $this->escape($article['user_name']); ?>">
                <?php print $this->escape($article['user_name']); ?>
            </a>
        </p>
        <?php print $this->escape($article['message']); ?>
    </div>
    <div>
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($article['user_name']); ?>/article/<?php print $this->escape($article['id']); ?>">
            <?php print $this->escape($article['time_stamp']); ?>
        </a>
        <?php foreach($reactions as $key => $r_id): ?>
            <a href="<?php print $base_url; ?>/article/<?php print $this->escape($article['id']); ?>/<?php print $r_id; ?>" class="reaction_icons">
                <img src="<?php print("/images/reaction_icons/".$key.".png"); ?>">
            </a>
            <div class="reaction_counter">
                <?php print $this->escape($article["reaction"][$r_id]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>