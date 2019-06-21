<?php
if (!isset($_SERVER['HTTP_USER_AGENT'])) return;

// Generate .vscode folder and workspace settings
global $ds_runtime;
if ( $ds_runtime->last_ui_event !== false ) {
	if ( strpos( "site_created,site_copied,site_moved,site_imported", $ds_runtime->last_ui_event->action ) !== false ) {
		if ( strpos( "site_copied,site_moved", $ds_runtime->last_ui_event->action ) !== false ) {
			$siteName = $ds_runtime->last_ui_event->info[1];
		}else{
			$siteName = $ds_runtime->last_ui_event->info[0];
		}
		if ( isset( $ds_runtime->preferences->sites->{$siteName} ) ) {
			$sitePath = $ds_runtime->preferences->sites->{$siteName}->sitePath;

			// TODO: create .vscode folder if it does not already exists
			
			// TODO: create/replace ds.code-workspace
			// TODO: create/replace launch.json
			// TODO: create/replace tasks.json
			// TODO: create/replace xdebug.html
			
			// Update {{sitePath}} in ds.code-workspace
			// Update {{siteName}} in tasks.json
		}
	}
}

// Add open in visual studio icon to localhost to open/start ds.code-workspace file
$ds_runtime->add_action( 'domain_button_group_after', 'vsc_domain_button_group_after', 90 );
function vsc_domain_button_group_after( $domain )
{
	echo '<a href="http://localhost/ds-plugins/visual-studio-code-support/vsc-launch.php" data-domain="', $domain, '" class="btn btn-info dds-action vsc">Visual Studio Code</a>';
}
