<?php
$social = rk_get_option('site_social');
if (!empty($social)) :
    echo '<ul class="menu-social">';
    foreach($social as $link) :
        echo '<li>';
            echo '<span class="btn-border">';
                echo '<span>';
                    echo '<a href="' . $link['url'] . '" target="_blank" class="btn-inner flush">';
                        echo '<img src="' . $link['icon'] . '" alt="' . $link['title'] . '" />';
                    echo '</a>';
                echo '</span>';
            echo '</span>';
        echo '</li>';
    endforeach;
    echo '</ul>';
endif;
?>
