<?php
function load_wp_clean_up_lang(){
	$currentLocale = get_locale();
	if(!empty($currentLocale)){
		$moFile = dirname(__FILE__) . "/lang/wp-clean-up-" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('WP-Clean-Up',$moFile);
	}
}
add_filter('init','load_wp_clean_up_lang');

function wp_clean_up_settings_link($action_links,$plugin_file){
	if($plugin_file==plugin_basename(__FILE__)){
		$wcu_settings_link = '<a href="options-general.php?page=' . dirname(plugin_basename(__FILE__)) . '/wp_clean_up_admin.php">' . __("Settings") . '</a>';
		array_unshift($action_links,$wcu_settings_link);
	}
	return $action_links;
}
add_filter('plugin_action_links','wp_clean_up_settings_link',10,2);

if(is_admin()){require_once('wp_clean_up_admin.php');}
?>