<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="wrapper">
		<div class="inner-wrapper">
			<?php include(locate_template('parts/tpl-post-header.php')); ?>
			<div class="row content">
				<div class="columns small-12">
					<?php
					the_content();
					?>
				</div>
			</div>
		</div>
	</div>
<?php
endwhile;
else:
	get_template_part('404');
endif;
get_footer();
