<ul class="error_list">
    <?php foreach ($errors as $error): ?>
    <li><?php print $this->escape($error); ?></li>
    <?php endforeach; ?>
</ul>