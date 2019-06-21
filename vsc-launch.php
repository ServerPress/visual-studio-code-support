<?php
global $ds_runtime;
if ( ! empty( $_REQUEST['domain'] ) ) {
	$cwd = @$ds_runtime->preferences->sites->{ $_REQUEST['domain'] }->sitePath;
	vsc_launch( $cwd . "/.vscode/ds.code-workspace");
}

/**
 * Launch the Visual Studio Code workspace.
 *
 * @param $vsc The current working directory.
 */
function vsc_launch( $vsc ) {
	global $ds_runtime;
	$cmd = $vsc;
	if ( PHP_OS !== 'Darwin' ){
		// Windows
		$cmd = "cmd /C \"start \""  . $cmd . "\"";
	} else{
		// Macintosh
		$cmd = "open \"" . $cmd . "\"";
	}
	exec( $cmd );
}
