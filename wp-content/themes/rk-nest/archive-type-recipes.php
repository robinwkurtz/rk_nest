<?php
get_header();
?>

<div class="wrapper">
	<div class="inner-wrapper">
		<?php
		include(locate_template('parts/tpl-post-header.php'));

		$taxonomies = get_object_taxonomies($post_type);
		foreach($taxonomies as $tax) :
			include(locate_template('parts/tpl-category-menu.php'));
		endforeach;

		if (!empty($content)) : ?>
			<div class="row">
				<div class="columns small-12">
					<div class="content">
						<?php echo $content; ?>
						<br/>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="columns small-12 align-center">
				<?php include(locate_template('parts/tpl-feed-grid.php')); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
