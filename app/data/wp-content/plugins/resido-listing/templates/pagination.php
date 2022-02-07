<div class="tt-pagination">
  <?php
	global $wp_query;
	echo paginate_links(array(
		'base' 		=> @add_query_arg('paged', '%#%'),
		'format' 	=> '?paged=%#%',
		'mid-size' 	=> 1,
		'add_args'  => false,
		'current' 	=> (get_query_var('paged')) ? get_query_var('paged') : 1,
		'total' 	=> ($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1,
		'prev_text' => '&larr;',
		'next_text' => '&rarr;',
		'type'      => 'list',
		'end_size'  => 3,
	));
	?>

</div>