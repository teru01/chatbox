<?php
$this->setPageTitle('title', $status['user_name']);
print $this->render('blog/status', ['status' => $status]);

