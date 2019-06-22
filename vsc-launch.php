<?php
global $ds_runtime;
if ( ! empty( $_REQUEST['domain'] ) ) {
	$cwd = @$ds_runtime->preferences->sites->{ $_REQUEST['domain'] }->sitePath;
	vsc_launch( $cwd );
}

/**
 * Launch the Visual Studio Code workspace.
 *
 * @param $vsc The current working directory.
 */
function vsc_launch( $vsc ) {
	global $ds_runtime;
	if ( PHP_OS !== 'Darwin' ){
		// Windows
		$cmd = "cd /D \"" . $vsc . "\\.vscode\"&start ds.code-workspace&";
	} else{
		// Macintosh
		$cmd = "open \"" . $vsc . "/.vscode/ds.code-workspace\"";
	}
	exec( $cmd );
}
