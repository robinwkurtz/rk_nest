<?php
/*
Template Name: Feed: Accordion
*/

get_header();

$id = get_the_ID();
$post_type = get_meta($id, 'template_feed_type');
$post_limit = intval(get_meta($id, 'template_feed_limit'));

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

			<div class="columns small-12 medium-4 large-3">
				<?php include(locate_template('parts/tpl-sidebar-filter.php')); ?>
			</div>

			<div class="columns spacer">
				&nbsp;<?php /* Column Spacer */ ?>
			</div>

			<div class="columns small-12 medium-8 large-9">

				<ul id="accordion" class="feed accordion-wrap">

					<?php
					// Set post limit
					if (empty($post_limit)) :
						$post_limit = 12;
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

					// Build up list item ?>

						<li class="accordion">
							<?php echo can_edit(get_the_ID(), true); ?>
							<a href="#" class="js-accordion-select accordion-link" id='title-<?php echo $count; ?>' data-show='#accordion-<?php echo $count; ?>'>
								<div class="btn-plus">&nbsp;</div>
								<?php the_title(); ?>
							</a>
							<div id="accordion-<?php echo $count; ?>" class="accordion-content js-toggle-show" style="display: none;">
								<?php the_content() ?>
							</div>
							<?php
							// If not last post on page, echo <hr/>
							if ($count < $post_count) : echo '<hr/>'; endif; ?>
						</li>

						<?php
						// Increment count for accordion tags
						$count++;
					endwhile;

						include(locate_template('parts/tpl-pagination.php'));

					endif;
					?>
				</ul>

			</div>
		</div>
	</div>
</div>

<?php
get_footer();
