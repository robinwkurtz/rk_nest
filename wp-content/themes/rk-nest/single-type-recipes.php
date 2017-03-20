<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();

$post_recipes_author = get_meta(get_the_ID(), 'post_recipes_author');
if (!empty($post_recipes_author)) :
	$author = get_userdata($post_recipes_author);
	$author_name = (!empty($author->display_name)) ? $author->display_name : $author->user_login;
	$author_url = get_author_posts_url($post_recipes_author);
endif;
$post_recipes_featured = get_meta(get_the_ID(), 'post_recipes_featured');
$post_recipes_ingredients = get_meta(get_the_ID(), 'post_recipes_ingredients');
$post_recipes_method = get_meta(get_the_ID(), 'post_recipes_method');

?>
	<div class="wrapper content">
		<div class="inner-wrapper">
			<?php include(locate_template('parts/tpl-post-header.php')); ?>
			<div class="row content wide-gutters">
                <?php
                if (!empty($post_recipes_ingredients)) : ?>
    				<div class="columns small-12 large-5">
                        <div class="js-checklist checklist shadowed-box align-left">
                            <h2>
                                <?php _e('Ingredients', theme_domain()); ?>
                            </h2>
                            <br/>
                            <?php echo apply_filters('the_content', $post_recipes_ingredients); ?>
                        </div>
						<br/>

						<a href="javascript:window.print()" class="btn"><?php _e('Print', theme_domain()); ?></a>

						<?php
						$share_title = rawurlencode(str_replace('&#039;', '', wp_title('&raquo;', false)));
						$share_space = '%20';
						 ?>

						<ul class="social-links inline-list">
							<li>
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
									<?php include(locate_template('parts/svg-facebook.php')); ?>
								</a>
							</li>
							<li>
								<a target="_blank" href="https://twitter.com/intent/tweet?status=<?php echo $share_title . $share_space . '@' . $share_space . get_the_permalink(); ?>">
									<?php include(locate_template('parts/svg-twitter.php')); ?>
								</a>
							</li>
							<li>
								<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo $share_title; ?>&summary=&source=<?php the_permalink(); ?>">
									<?php include(locate_template('parts/svg-linkedin.php')); ?>
								</a>
							</li>
							<li>
								<a href="mailto:?subject=<?php echo $share_title; ?>&body=<?php the_permalink(); ?>" class="mail">
									<?php include(locate_template('parts/svg-email.php')); ?>
								</a>
							</li>
						</ul>

    				</div>
                    <div class="columns small-12 hide-for-large-up">
                        &nbsp; <? /* Column Spacer */ ?>
                    </div>
                <?php
                endif;
                if (!empty($post_recipes_method)) : ?>
                    <div class="columns small-12 large-7">
                        <h2>
                            <?php _e('Method', theme_domain()); ?>
                        </h2>
                        <?php echo apply_filters('the_content', $post_recipes_method); ?>
    				</div>
                <?php
                endif;
                ?>
			</div>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				echo '<div class="row wide-gutters">';
					echo '<div class="spacer">&nbsp;</div>';
					echo '<div class="columns small-12">';
						comments_template();
					echo '</div>';
				echo '</div>';
			endif;
			?>

		</div>
	</div>
<?php
endwhile;
else:
	get_template_part('404');
endif;
get_footer();
