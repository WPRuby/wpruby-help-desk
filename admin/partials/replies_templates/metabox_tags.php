<table class="widefat fixed" >
    <thead>
    <tr>
        <th style="width:25%;">Tag</th>
        <th>Label</th>
    </tr>
    </thead>
	<?php foreach ($this->tags as $tag => $label): ?>
    <tr>
        <td><a class="rhd_template_tag" href="#" data-value="<?php echo sprintf('{%s}', $tag); ?>"><?php echo sprintf('{%s}', $tag); ?></a></td>
        <td><?php echo $label; ?></td>
    </tr>
	<?php endforeach; ?>
</table>