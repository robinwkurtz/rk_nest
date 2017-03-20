<?php
/*
Template Name: Feed: Gallery (Lightsaber Images)
*/

get_header();

$id = get_the_ID();
$post_type = 'type-products';
$post_limit = get_meta($id, 'template_feed_limit');

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

				<ul class="feed block-grid small-block-grid-1 medium-block-grid-2 large-block-grid-3">

					<?php
					// Set post limit
					if (empty($post_limit)) :
						$post_limit = 48;
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
					$post_slug = $post->post_name;
					$post_image = get_meta(get_the_ID(), 'post_product_featured');
					$post_desc = get_meta(get_the_ID(), 'post_product_desc');
					$post_extdesc = get_meta(get_the_ID(), 'post_product_extdesc');
					$post_gallery = get_meta(get_the_ID(), 'post_product_gallery');
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
							foreach($tax_terms as $term) :
								array_push($tax_terms_array, $term->name);
							endforeach;
						endif;

						// Foreach taxonomy set $key as $tax_lable and $tax_terms_array as $value in $post_tax_array
						$post_tax_array[$tax_label] = $tax_terms_array;
					endforeach;

					?>

					<?php if (!empty($post_image)) : ?>
						<li class="block-item product">
							<img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?> - <?php _e('Featured Image', theme_domain()); ?>"/>
						</li>
					<?php endif;

					if (!empty($post_gallery)) : ?>
						<li class="block-item product">
							<?php foreach($post_gallery as $image) : ?>
							    <img src="<?php echo $image; ?>" alt="<?php the_title(); ?> - <?php echo __('Gallery Image', theme_domain()); ?>"/>
							<?php endforeach; ?>
						</li>
					<?php endif; ?>

					<?php
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
