<?php
get_header();


?>

<div class="wrapper">
	<div class="inner-wrapper">
		<?php include(locate_template('parts/tpl-post-header.php'));?>

		<div class="row">
			<div class="column small-12">
				<?php if ( get_the_author_meta('description')) : ?>
					<?php echo get_avatar(get_the_author_meta('user_email')); ?>
					<h2><?php _e('About'); echo get_the_author() ; ?></h2>
					<?php echo wpautop( get_the_author_meta('description') ); ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<div class="column small-12">
				<h2><?php echo get_the_author_meta('first_name') . __('\'s Recipes'); ?></h2>
			</div>
			<div class="column small-12 spacer">
				<?php /* Column Spacer */ ?> &nbsp;
			</div>
			<div class="column small-12 align-center">
				<?php include(locate_template('parts/tpl-feed-grid.php')); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer(); ?>
