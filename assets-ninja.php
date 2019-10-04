<?php

/*
Plugin Name: AssetsNinja
Plugin URI: https://learnwith.yusuf.com
Description: Assets Management In Depth
Version: 1.0
Author: yusuf
Author URI: https://www.facebook.com/
License: GPLv2 or later
Text Domain: assetsninja
Domain Path: /languages/
*/ 
/**
 * 
 */

//contant hisebe define or assets loading

define('ASN_ASSETS_DIR',plugin_dir_url(__FILE__)."assets/");
define('ASN_ASSETS_PUBLIC_DIR',plugin_dir_url(__FILE__)."assets/public");
define('ASN_ASSETS_ADMIN_DIR',plugin_dir_url(__FILE__)."assets/admin");
define('ASN_VERSION',time());


 //OOP STYLE 
class AssetsNinjas{

	private $version;

	function __construct(){
 
		$this->version = time();  
		
		add_action('plugins_loaded',array($this,'load_textdomain'));
		 add_action('wp_enqueue_scripts',array($this,'load_front_assets'));
		
		//addmin er jonno 10.4
		add_action('admin_enqueue_scripts',array($this,'load_admin_assets'));

		//inline style
		add_shortcode('bgmedia',array($this,'asn_bgmedia_shortcode'));
	}

	//addmin assets 10.4

	function load_admin_assets($screen){
		$_screen = get_current_screen();
		if ('edit.php' == $screen && 'page' == $_screen->post_type){ 
		wp_enqueue_script('asn-admin-js',ASN_ASSETS_ADMIN_DIR."/js/admin.js",array('jquery'),$this->version,true);

		}
	} 

	//time use call Cash busting


	function load_front_assets(){
		wp_enqueue_style('asn-main-css',ASN_ASSETS_PUBLIC_DIR."/css/main.css",null,$this->version);
		//inline style
$attachment_image_src = wp_get_attachment_image_src(502,'medium');
		$img = <<<EOD
		#bgmedia{
		background-image:url($attachment_image_src[0])
	}


EOD;

		wp_add_inline_style('asn-main-css', $img );

		/*wp_enqueue_script('asn-main-js',ASN_ASSETS_PUBLIC_DIR."/js/main.js",array('jquery','asn-another-js'),$this->version,true);*/

		//another.js main.js er upor depent

		/*wp_enqueue_script('asn-another-js',ASN_ASSETS_PUBLIC_DIR."/js/another.js",array('jquery','asn-more-js'),$this->version,true);*/

		//more js another er upor depent

		/*wp_enqueue_script('asn-more-js',ASN_ASSETS_PUBLIC_DIR."/js/more.js",array('jquery'),$this->version,true);*/



		//enqueue r simply method

		$js_files =array(
			'asn-main-js'=>array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/main.js",'dep'=>array('jquery','asn-another-js')),
			'asn-another-js'=>array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/another.js",'dep'=>array('jquery','asn-more-js')),
			'asn-more-js'=>array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/more.js",'dep'=>array('jquery')),


		);

		foreach($js_files as $hendle=>$fileinfo){
			wp_enqueue_script($hendle,$fileinfo['path'],$fileinfo['dep'],$this->version,true);
		}
	


		$data = array(
			'name'=>'yusuf',
			'url'=>'https://www.facebook.com'

		);


		$moredata = array(
			'name'=>'Fahad',
			'url'=>'https://www.facebook.com/ami'

		);

		$translated_strings = array(

			'greetings'=>__('Hello Wold','assetsninja')
		); 

		wp_localize_script('asn-more-js','sitedata',$data);
		wp_localize_script('asn-more-js','moredata',$moredata);
		wp_localize_script('asn-more-js','translations',$translated_strings);
		//inline cssdiye more js a hello add
		$data = <<<EOD
		alert('Hello Form Inline Script');
EOD;  
		wp_add_inline_script('asn-more-js',$data);

	}


	function load_textdomain(){
		load_plugin_textdomain('assetsninja',false,plugin_dir_url(__FILE__)."/languages");
	}

	function asn_bgmedia_shortcode($attributes){
		
		$shortcode_output = <<<EOD

<div id="bgmedia"></div>
 
EOD;	
		return $shortcode_output;

	}



}
new AssetsNinjas();  