<?php

if ($posts->found_posts > $post_limit) :
    $big = 999999999; // Need an unlikely integer
    $args = array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $posts->max_num_pages,
        'prev_text' => __('Previous', theme_domain()),
        'next_text' => __('Next', theme_domain()),
        'show_all' => true,
    ); ?>
    <hr/>
    <div class="pagination">
        <?php echo paginate_links($args); ?>
    </div>
    <?php
endif;

?>
