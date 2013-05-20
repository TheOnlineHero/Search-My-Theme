<?php
/*
Plugin Name: Search My Theme
Plugin URI: http://wordpress.org/extend/plugins/search-my-theme/
Description: A wordpress plugin that lets you search for text within your templates.

Installation:

1) Install WordPress 3.5.1 or higher

2) Download the latest from:

http://wordpress.org/extend/plugins/search-my-theme

3) Login to WordPress admin, click on Plugins / Add New / Upload, then upload the zip file you just downloaded.

4) Activate the plugin.

Version: 1.0
Author: TheOnlineHero - Tom Skroza
License: GPL2
*/

add_action('admin_menu', 'register_search_my_theme_page');
function register_search_my_theme_page() {
  add_menu_page('Search My Theme', 'Search My Theme', 'manage_options', 'search-my-theme/search-my-theme.php', 'search_my_theme_page');
}

function search_my_theme_page() {
	if ($_POST["search_text"] != "") {
		$search_text = str_replace('\"', "\"", $_POST["search_text"]);
		$search_text = str_replace("\'", '\'', $search_text);
		search_my_theme_search_text(get_template_directory(), $search_text);
		
	}
	?>
	<form action="" method="post">
		<p><label for="search_text">Search</label> <input type="text" name="search_text" id="search_text" value="<?php echo($_POST['search_text']); ?>" /></p>
		<p><input type="submit" name="action" value="Search" /></p>
	</form>
	<?php
}

function search_my_theme_search_text($src, $search_text) { 
    $dir = opendir($src); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
              search_my_theme_search_text($src . '/' . $file, $search_text);
            } else {
            	$content = file_get_contents($src . '/' . $file);
							if (@preg_match("/".$search_text."/", $content)) {
								echo($src . '/' . $file);
	            	echo("<br/>");
							}
            }
        }   
    }
    closedir($dir); 
}

?>