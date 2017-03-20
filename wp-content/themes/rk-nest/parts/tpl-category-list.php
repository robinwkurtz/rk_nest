<?php

// Get terms of taxonomy: Exclude uncategorized (id: 1)
$terms = get_terms(array(
    'taxonomy' => $taxonomy,
    'hide_empty' => false
));

// If any terms, continue
if (count($terms) > 0) :

    // Loop over $terms
    foreach($terms as $term) :

        if ($term->parent === 0) :
            echo '<li>';
                echo '<a href="' . get_term_link($term) . '">';
                    echo $term->name;
                echo '</a>';
            echo '</li>';
        endif;

    endforeach;

else :

    // If no terms, display default message ?>

    <ul>
        <li>
            <?php _e('No filters to display', theme_domain()); ?>
        </li>
    </ul>

<?php
endif;

?>
