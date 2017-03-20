<?php
/*
Template Name: Feed: List
*/

get_header();

$id = get_the_ID();
$post_type = get_meta($id, 'template_feed_type');
$post_limit = get_meta($id, 'template_feed_limit');
$has_tax = (empty(get_object_taxonomies($post_type))) ? false : true;
$tax_query = null; // Override within tpl-sidebar-filter if taxonomies are set

?>

<div class="wrapper">
	<div class="inner-wrapper">

		<?php if (!empty(get_the_content())) : ?>
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
			<?php if ($has_tax) : ?>
				<div class="columns small-12 medium-4 large-3">
					<?php include(locate_template('parts/tpl-sidebar-filter.php')); ?>
				</div>
			<?php endif; ?>
			<div class="columns small-12<?php echo ($has_tax) ? ' medium-8 large-9' : ''; ?>">

				<ul class="feed">

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

					// Set post count (On page) & count
					$post_count = $posts->post_count;
					$count = 1;

					if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post();

					// Get post meta
					global $post;
					$post_slug = $post->post_name;
					$post_image_id = get_post_thumbnail_id();
					$post_image_url_array = wp_get_attachment_image_src($post_image_id);
					$post_image_url = $post_image_url_array[0];

					?>

					<li class="list-item item-<?php echo $count; ?>">

						<div class="row">

							<?php if (!empty($post_image_url)) : ?>
								<div class="columns small-12 medium-4">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo $post_image_url; ?>" alt="<?php the_title(); ?>" class="list-item-image" />
									</a>

								</div>
							<?php endif; ?>

							<div class="columns small-12<?php echo (!empty($post_image_url)) ? ' medium-8' : ''; ?>">
								<h2>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
									<?php echo can_edit(get_the_ID()); ?>
								</h2>
								<?php if (get_post_type() === 'post') : ?>
									<span class="text-small">
										<?php _e('Published', theme_domain()); ?> <?php the_date(); ?>
									</span>
								<?php endif; ?>
								<div class="list-item-content content">
									<p>
										<?php the_excerpt(); ?>
									</p>
								</div>

								<?php include(locate_template('parts/tpl-taxonomy-list.php')); ?>

							</div>
						</div>

						<?php
						// If not last post on page, echo <hr/>
						if ($count < $post_count) : echo '<hr/>'; endif; ?>

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
