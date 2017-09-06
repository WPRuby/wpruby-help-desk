<ul id="rhd_templates_tags_list">
<?php foreach ($this->tags as $tag => $label): ?>
	<li><a href="#"><?php echo sprintf('{%s}', $tag); ?></a></li>
<?php endforeach; ?>
</ul>
<br>
<br>
<br>
<br>