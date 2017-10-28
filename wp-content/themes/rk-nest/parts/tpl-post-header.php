<?php $author = get_user_by('slug', get_query_var('author_name')); ?>
<div class="row align-center">
    <div class="columns small-12">
        <h1 class="underlined">
            <?php
            if ($author) :
                echo $author->display_name;
            elseif (is_archive()) :
                post_type_archive_title();
            else :
                the_title();
            endif;
            ?>
            <?php echo can_edit(get_the_ID()); ?>
        </h1>
        <?php
        if (is_single()) :
            echo '<p class="text-small">';
                _e('Published on: ', theme_domain());
                echo the_date();
                if (!empty($author_name)) : 
                    echo '&ensp;|&ensp;' . __('Credits to: ', theme_domain());
                    echo (!empty($author_url)) ? '<a href="' . $author_url . '">' . $author_name . '</a>' : $author_name;
                endif;
            echo '</p>';
        endif;
        ?>
        <div class="spacer">&nbsp;</div>
    </div>
</div>
