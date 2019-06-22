<?php
/*
Plugin Name: Visual Studio Code Support
Plugin URI: http://serverpress.com/plugins/visual-studio-code
Description: Enables automatic Visual Studio Code workspace creation for integrated Xdebug, WP-CLI, browser launching, and code editing.
Author: Stephen Carnam
Version: 1.0.0
Author URI: http://steveorevo.com/
*/

/**
 * Create Visual Studio Code workspace directory. This function is invoked on
 * site create, copy, move, import, and if it doesn't exist when the user
 * clicks the VS Code button on localhost.
 *
 * @param $cwd The current working directory.
 */
function create_vsc_workspace($cwd) {

    // TODO: create .vscode folder if it does not already exists
    
    // TODO: create/replace ds.code-workspace
    // TODO: create/replace launch.json
    // TODO: create/replace tasks.json
    // TODO: create/replace xdebug.html
    
    // Update {{sitePath}} in ds.code-workspace
    // Update {{siteName}} in tasks.json
}