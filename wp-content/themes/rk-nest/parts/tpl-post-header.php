<div class="row align-center">
    <div class="columns small-12">
        <h1 class="underlined">
            <?php the_title(); ?>
            <?php echo can_edit(get_the_ID()); ?>
        </h1>
        <?php
        if (!is_page()) :
            echo '<p class="text-small">';
                _e('Published on: ', theme_domain());
                echo the_date();

                if (!empty($post_recipes_author) && !empty($author_url)) :
                    echo '&ensp;|&ensp;' . __('Credits to: ', theme_domain()) . '<a href="' . $author_url . '">' . $author_name . '</a>';
                endif;
            echo '</p>';
        endif;
        ?>
        <div class="spacer">&nbsp;</div>
    </div>
</div>
