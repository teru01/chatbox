<div class="status">
    <div class="status_content">
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($status['user_name']); ?>">
            <?php print $this->escape($status['user_name']); ?>
        </a>
        <?php print $this->escape($status['message']); ?>
    </div>
    <div>
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($status['user_name']); ?>/status/<?php print $this->escape($status['id']); ?>">
            <?php print $this->escape($status['time_stamp']); ?>
        </a>
    </div>
</div>