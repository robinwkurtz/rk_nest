<img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?> - <?php _e('Featured Image', theme_domain()); ?>"/>
<?php
$count = 2;
foreach($post_gallery as $image) : ?>
    <img src="<?php echo $image; ?>" alt="<?php the_title(); ?> - <?php echo __('Gallery Image', theme_domain()) . ' ' . $count; ?> "/>
<?php
    $count++;
endforeach;
