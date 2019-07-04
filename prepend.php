<?php

global $ds_runtime;
if ( $ds_runtime->last_ui_event !== false ) {

	// Patch mac xdebug.so
	if ( PHP_OS === 'Darwin' ){
		if ( 'update_server' == $ds_runtime->last_ui_event->action ) {
			copy(__DIR__ . "/vscode/xdebug.so", "/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so");
		}
	}
	
	// Generate .vscode folder and workspace settings
	if ( strpos( "site_created,site_copied,site_moved,site_imported", $ds_runtime->last_ui_event->action ) !== false ) {
		if ( strpos( "site_copied,site_moved", $ds_runtime->last_ui_event->action ) !== false ) {
			$siteName = $ds_runtime->last_ui_event->info[1];
		}else{
			$siteName = $ds_runtime->last_ui_event->info[0];
		}
		if ( isset( $ds_runtime->preferences->sites->{$siteName} ) ) {
			$sitePath = $ds_runtime->preferences->sites->{$siteName}->sitePath;
		
			// Create .vscode folder if it does not already exists
			include_once( __DIR__ . DIRECTORY_SEPARATOR . "vsc-support.php");
			create_vsc_workspace($sitePath);
		}
	}
}
if (!isset($_SERVER['HTTP_USER_AGENT'])) return;

// Add open in visual studio icon to localhost to open/start ds.code-workspace file
$ds_runtime->add_action( 'domain_button_group_after', 'vsc_domain_button_group', 50 );
function vsc_domain_button_group( $domain ){
	echo '<a href="http://localhost/ds-plugins/visual-studio-code-support/vsc-launch.php" data-domain="', $domain, '" style="background-color: #575297;border-color:#575297" class="btn btn-info dds-action vsc">VS Code</a>';
}
$ds_runtime->add_action( 'ds_footer', 'vsc_localhost_scripts' );
function vsc_localhost_scripts() {
	?>
	<script>
		(function($){
			$('.dev-sites .btn-group .vsc').on('click', function(e) {
				e.preventDefault();
				$.post($(this).attr('href'), {
					domain: $(this).data('domain')
				});
			});
		})(jQuery);
	</script>
	<?php
}