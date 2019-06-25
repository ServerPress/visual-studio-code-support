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

    // Create .vscode folder if it does not already exist
    if (file_exists($cwd . DIRECTORY_SEPARATOR . ".vscode") === FALSE) {
        mkdir($cwd . DIRECTORY_SEPARATOR . ".vscode");
    }

    // Create or merge our launch file
    $file = __DIR__ . DIRECTORY_SEPARATOR . "vscode" . DIRECTORY_SEPARATOR . "launch.json";
    $temp = file_get_contents($file);
    $file = $cwd . DIRECTORY_SEPARATOR . ".vscode" . DIRECTORY_SEPARATOR . "launch.json";
    if (file_exists($file) === TRUE){
        $launch = file_get_contents($file);
        $launch = json_encode(array_merge(json_decode($launch, true),json_decode($temp, true)));
    }else{
        $launch = $temp;
    }
    file_put_contents($file, $launch);

    // Prefix our platform specific vscode files
    if ( PHP_OS === 'Darwin' ){
        $prefix = __DIR__ . DIRECTORY_SEPARATOR . "vscode" . DIRECTORY_SEPARATOR . "mac-";
    }else{
        $prefix = __DIR__ . DIRECTORY_SEPARATOR . "vscode" . DIRECTORY_SEPARATOR . "win-";
    } 
    
    // Create or merge our workspace file
    $file = $prefix . "ds.code-workspace";
    $temp = file_get_contents($file);
    $file = $cwd . DIRECTORY_SEPARATOR . ".vscode" . DIRECTORY_SEPARATOR . "ds.code-workspace";
    if (file_exists($file) === TRUE){
        $work = file_get_contents($file);
        $work = json_encode(array_merge(json_decode($work, true),json_decode($temp, true)));
    }else{
        $work = $temp;
    }
    // Update {{sitePath}} in ds.code-workspace
    $x = str_replace("\\", "\\\\", $cwd);
    $work = str_replace("{{sitePath}}", $x, $work);
    file_put_contents($file, $work);

    // Create or merge our tasks file
    $file = $prefix . "tasks.json";
    $temp = file_get_contents($file);
    $file = $cwd . DIRECTORY_SEPARATOR . ".vscode" . DIRECTORY_SEPARATOR . "tasks.json";
    if (file_exists($file) === TRUE){
        $tasks = file_get_contents($file);
        $tasks = json_encode(array_merge(json_decode($tasks, true),json_decode($temp, true)));
    }else{
        $tasks = $temp;
    }
    // Update {{siteName}} in tasks.json
    function getRightMost( $sSrc, $sSrch ) {
        for ( $i = strlen( $sSrc ); $i >= 0; $i = $i - 1 ) {
            $f = strpos( $sSrc, $sSrch, $i );
            if ( $f !== false ) {
                return substr( $sSrc, $f + strlen( $sSrch ), strlen( $sSrc ) );
            }
        }

        return $sSrc;
    }
    $siteName = getRightMost($cwd, DIRECTORY_SEPARATOR);
    $tasks = str_replace("{{siteName}}", $siteName, $tasks);
    file_put_contents($file, $tasks);

    // Copy over our xdebug.html redirect
    copy(__DIR__ . DIRECTORY_SEPARATOR . "vscode" . DIRECTORY_SEPARATOR . "xdebug.html",
        $cwd . DIRECTORY_SEPARATOR . ".vscode" . DIRECTORY_SEPARATOR . "xdebug.html");
}

