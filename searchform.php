<?php
/**
 * search form.
 * wordpress template part
 *
 * @package prolix\template_parts
 */

/**
 * the search form
 */

    ?>
<form action="<?php echo esc_url(home_url('/')); ?>" id="search_form" class="mb-0 mt-0" method="get">
	<div class="input-group">
		<span class="input-group-append">
			<label title="search" for="s" class="btn btn-primary pt-2 pb-2 pl-3 pr-3" style="margin:0">
				<span class="fa fa-search fafw"></span>
			</label>
		</span>
		<input type="text" id="s" name="s" autocomplete="off" placeholder="Search" class="form-control">
		<input type="hidden" value="the_search_text" name="action">
		
		<?php wp_nonce_field('search', 'search'); ?>
	</div>
</form>
