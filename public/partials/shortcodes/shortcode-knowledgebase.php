<div id="rhd_knowledgebase">
    <?php foreach ($products as $product): ?>
      <div class="product_documents">
        <h4><?php echo $product->name; ?></h4>
        <ul class="documents_list">
        <?php foreach ($product->documents as $document): ?>
          <li><a href="<?php echo get_permalink($document->ID); ?>"><?php echo $document->post_title; ?></a></li>
        <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
</div>
