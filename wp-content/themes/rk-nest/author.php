<?php
get_header();

$author = get_user_by('slug', get_query_var('author_name'));

if (!empty($author)) : ?>
	<div class="wrapper content">
		<div class="inner-wrapper">
			<div class="row">
				<div class="columns small-12">
					<h1 class="underlined">
						<?php echo $author->display_name; ?>
						<?php echo can_edit($author); ?>
					</h1>
				</div>
			</div>
		</div>
	</div>
<?php
else:
	get_template_part('404');
endif;
get_footer();
