<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap ayvpp-wrap">
	
	<h2>Automatic Video Posts Duplicate Post Removal</h2>

	<form id="WP_ayvpp_dups_form" method="post">
		<hr />
		<h3>Remove dupliate posts</h3>
		<p>The following button will delete all duplicate videos, imported and stored, from the database and all WordPress posts associated with the videos.</p>
		<p><b>THIS MAY TAKE SOME TIME.</b></p>
		<input type="submit" value="Cleanup" name="submit" class="button-primary action" />
		
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('WP_ayvpp_nonce');?>" />
		<input type="hidden" name="_wp_http_referer" value="<?php wp_get_referer(); ?>" />
	</form>
	
</div>