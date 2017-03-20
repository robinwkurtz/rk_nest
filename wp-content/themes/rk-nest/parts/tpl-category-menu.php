<?php

// Empty Array for Taxonomy Slugs
$tax_slugs = array();

// Empty Array for Tax_Query
if (!isset($tax_query)) :
    $tax_query = array();
endif;

// Get Taxonomies' name -> slugify
$tax_label = slugify(get_taxonomy($tax)->label);

// Push taxonomy slug into $tax_slugs for clear functionality
array_push($tax_slugs, $tax_label);

// If a taxonomy parameter is set, push it into $tax_query to apply to post loop
if (isset($_GET[$tax_label])) :
    array_push(
        $tax_query,
        array(
            'taxonomy' => $tax,
            'field'    => 'slug',
            'terms'    => $_GET[$tax_label]
        )
    );
endif;

// Get terms of taxonomy: Exclude uncategorized (id: 1)
$terms = get_terms(array(
    'taxonomy' => $tax,
    'hide_empty' => false,
    'exclude' => '1',
    'parent' => '0'
));


// If any terms, continue
if (count($terms) > 0) :

    echo '<div class="row">';
    echo '<div class="columns small-12">';

    // Opening tag for second level list + accordion
    echo '<ul class="category-menu">';

        $zindex = count($terms);

        // Loop over $terms
        foreach($terms as $term) :

            // Get child terms
            $child_terms = get_terms(array(
                'taxonomy' => $tax,
                'hide_empty' => false,
                'parent' => $term->term_id
            ));

            $child_terms_array = array();
            foreach($child_terms as $key => $value) :

                $child_terms_array[$key] = $value->slug;
            endforeach;

            $active = (active_query_arg($tax_label, $term->slug) || active_query_arg($tax_label, $child_terms_array)) ? ' active' : '';

            echo '<li style="z-index: ' . $zindex . '">';
                echo '<a href="' . toggle_query_arg($tax_label, $term->slug) . '" class="' . $active . '">';
                    echo $term->name;
                echo '</a>';

                if ($child_terms > 0) :
                    echo '<ul>';
                    foreach($child_terms as $term) :

                        $active = (active_query_arg($tax_label, $term->slug)) ? ' active' : '';

                        echo '<li>';
                            echo '<a href="' . toggle_query_arg($tax_label, $term->slug) . '" class="' . $active . '">';
                                echo $term->name;
                            echo '</a>';
                        echo '</li>';
                    endforeach;
                    echo '</ul>';
                endif;

            echo '</li>';

            $zindex--;

        endforeach;

    // Closing second level list
    echo '</ul>';

    echo '</div>';
    echo '<div class="spacer">&nbsp;</div>';
    echo '</div>';

endif;

// echo '<br/><a href="' . remove_query_arg($tax_slugs) . '" class="btn">Clear</a>';
