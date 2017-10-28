<ul class="feed block-grid small-block-grid-1 medium-block-2 large-block-grid-3">
	<?php
	// Set post limit
	if (empty($post_limit)) :
		$post_limit = 24;
	endif;

	// Get author
	$author = get_user_by('slug', get_query_var('author_name'));

	// Set post args, pull $post_type from page meta
	$post_args = array(
		'posts_per_page' => $post_limit,
		'post_type' => $post_type,
		'post_status' => 'publish',
		'paged' => $paged,
		'author' => (!empty($author)) ? $author->ID : null,
		'tax_query' => (!empty($tax_query)) ? $tax_query : null
	);

	// Define WP_Query
	$posts = new WP_Query($post_args);

	// Set count
	$count = 1;

	if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post();

	// Get post meta
	global $post;
	$post_slug = $post->post_name;

	$post_image_id = get_post_thumbnail_id();
	$post_image_url_array = wp_get_attachment_image_src($post_image_id, 'large');
	$post_image_url = $post_image_url_array[0];

	?>

	<li class="block-item block item-<?php echo $count; ?> align-left">
		<?php echo can_edit(get_the_ID()); ?>
		<a href="<?php the_permalink(); ?>" class="block-link">
			<div <?php echo (!empty($post_image_url)) ? 'class="block-image" style="background-image:url(' . $post_image_url . ');"' : 'class="block-text"'; ?>>
				<div class="block-title">
					<div>
						<?php the_title(); ?>
					</div>
				</div>
			</div>
		</a>
	</li>

	<?php
	$count++;
	endwhile;

	include(locate_template('parts/tpl-pagination.php'));

	else :

		// If no posts found, check if paramaters are set. FIXME: Limit to only available taxonomy paramaters
		if(count($_GET)) :
			_e('Sorry, there are no posts that match your requirements', theme_domain());
		else :
			_e('Sorry, there are no posts to display', theme_domain());
		endif;

	endif;

	?>
</ul>
