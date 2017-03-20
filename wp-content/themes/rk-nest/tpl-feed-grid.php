<?php
/*
Template Name: Feed: Grid
*/

get_header();

$id = get_the_ID();
$post_type = get_meta($id, 'template_feed_type');
$post_limit = get_meta($id, 'template_feed_limit');

?>

<div class="wrapper">
	<div class="inner-wrapper">

		<?php

		include(locate_template('parts/tpl-post-header.php'));

		$taxonomies = get_object_taxonomies($post_type);
		foreach($taxonomies as $tax) :
			include(locate_template('parts/tpl-category-menu.php'));
		endforeach;

		if (!empty(get_the_content())) : ?>
			<div class="row">
				<div class="columns small-12">
					<div class="content">
						<?php the_content(); ?>
						<br/>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="columns small-12 align-center">

				<ul class="feed block-grid small-block-grid-1 medium-block-2 large-block-grid-3">

					<?php
					// Set post limit
					if (empty($post_limit)) :
						$post_limit = 24;
					endif;

					// Set post args, pull $post_type from page meta
					$post_args = array(
						'posts_per_page' => $post_limit,
						'post_type' => $post_type,
						'post_status' => 'publish',
						'paged' => $paged,
						'tax_query' => $tax_query
					);

					// Define WP_Query
					$posts = new WP_Query($post_args);

					// Set count
					$count = 1;

					if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post();

					// Get post meta
					global $post;
					$post_image = get_meta(get_the_ID(), 'post_product_featured');

					?>

					<li class="block-item block item-<?php echo $count; ?> align-left">
						<?php echo can_edit(get_the_ID()); ?>
						<a href="<?php the_permalink(); ?>" class="block-link">
							<div class="block-image<?php echo (!empty($post_image)) ? '" style="background-image:url(' . $post_image . ');"' : ' text"'; ?>>
								<div class="block-title block-absolute">
									<?php the_title(); ?>
								</div>
							</div>
						</a>
					</li>

					<?php
					$count++;
					endwhile;

					include(locate_template('parts/tpl-pagination.php'));

					else :

						// If no posts found, check if paramaters are set. FIXME: Limit to only aviable taxonomy paramaters
						if(count($_GET)) :
							_e('Sorry, there are no posts that match your requirements', theme_domain());
						else :
							_e('Sorry, there are no posts to display', theme_domain());
						endif;

					endif;

					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
