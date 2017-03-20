<?php

$post_taxonomies = get_post_taxonomies(get_the_ID());

// Empty array for post's $post_taxonomies -> terms
$post_tax_array = array();

foreach($post_taxonomies as $tax) :
    $tax_label = get_taxonomy($tax)->label;

    // Empty array for taxonomies' terms
    $tax_terms_array = array();
    $tax_terms = get_the_terms(get_the_ID(), $tax);

    // Foreach term, push name into $tax_terms_array
    if (is_array($tax_terms)) :
        foreach($tax_terms as $key => $value) :
            array_push($tax_terms_array, $value->name);
        endforeach;
    endif;

    // Exclude Uncategorized
    $tax_terms_excludes = array('Uncategorized');
    $tax_terms_array = array_diff($tax_terms_array, $tax_terms_excludes);

    // Foreach taxonomy set $key as $tax_lable and $tax_terms_array as $value in $post_tax_array
    if (count($tax_terms_array) > 0) :
        $post_tax_array[$tax_label] = $tax_terms_array;
    endif;
endforeach;

// If any taxonomies, continue
if (count($post_tax_array) > 0) :

    echo '<ul class="condensed">';

        // Foreach $post_tax_array, build strinified list of $value for each $key
        foreach($post_tax_array as $key => $value) :

            $string = '';
            $found = count($value);
            $i = 1;
            foreach($value as $v) :
                $string .= '<a href="' . toggle_query_arg(slugify($key), slugify($v)) . '">' . $v . '</a>';
                if ($found > $i) : $string .= ', '; endif;
                $i++;
            endforeach;

            echo '<li class="text-small"><strong>' . $key . '</strong>: ' . $string . '</li>';
        endforeach;

    echo '</ul>';
endif;
?>
