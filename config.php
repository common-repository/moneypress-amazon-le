<?php

/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('MP_AMZ_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__mpamz') === false) {
        require_once(MP_AMZ_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }

    global $MP_amz_plugin;
   
    $MP_amz_plugin = new wpCSL_plugin__mpamz(
        array(
            'use_obj_defaults'      => true,   
            'cache_obj_name'        => 'mpamzcache',            
            
            'prefix'                => MP_AMZ_PREFIX,
            'css_prefix'            => 'csl_themes',            
            'name'                  => 'MoneyPress : Amazon Edition',
            
            'url'                   => 'http://www.charlestonsw.com/product/moneypress-amazon-pro-pack/',
            'support_url'           => 'http://wordpress.org/support/plugin/moneypress-amazone-le',
            'purchase_url'          => 'http://www.charlestonsw.com/product/moneypress-amazon-pro-pack/',
            
            'basefile'              => MP_AMZ_BASENAME,
            'plugin_path'           => MP_AMZ_PLUGINDIR,
            'plugin_url'            => MP_AMZ_PLUGINURL,
            'cache_path'            => MP_AMZ_PLUGINDIR . 'cache',
            
            'driver_name'           => 'Amazon',
            'driver_type'           => 'Panhandler',
            'driver_args'           => array(
                    'debugging'            => (get_option('mpamz-debugging')==='on'),
                    'secret_access_key'   => get_option(MP_AMZ_PREFIX.'-secret_access_key'),
                    'wait_for'            => get_option(MP_AMZ_PREFIX.'-wait_for'),
                    'AWSAccessKeyId'      => get_option(MP_AMZ_PREFIX.'-AWSAccessKeyId'),
                    'associatetag'        => get_option(MP_AMZ_PREFIX.'-AssociateTag'),
                    'searchindex'         => get_option(MP_AMZ_PREFIX.'-SearchIndex'),
                    ),
            'shortcodes'            => array('mpamz', 'mp-amz','MP-AMZ','mp-amazon'),
            
            'has_packages'          => true,
        )
    );    
    // Setup our optional packages
    //
    add_options_packages_for_mpamz();        

}


/**************************************
 ** function: add_options_packages_for_mpamz
 **
 ** Setup the option package list.
 **/
function add_options_packages_for_mpamz() {
    configure_mpamz_propack();
}


/**************************************
 ** function: configure_mpamz_propack
 **
 ** Configure the Pro Pack.
 **/
function configure_mpamz_propack() {
    global $MP_amz_plugin;
   
    // Setup metadata
    //
    $MP_amz_plugin->license->add_licensed_package(
            array(
                'name'              => 'Pro Pack',
                'help_text'         => 'A variety of enhancements are provided with this package.  ' .
                                       'See the <a href="'.$MP_amz_plugin->purchase_url.'" target="CSA">product page</a> for details.  If you purchased this add-on ' .
                                       'come back to this page to enter the license key to activate the new features.',
                'sku'               => 'MPAMZ',
                'paypal_button_id'  => '8Q3VRGUAHUZGU',
                'paypal_upgrade_button_id' => '8Q3VRGUAHUZGU'
            )
        );
    
    // Enable Features Is Licensed
    //
    if ($MP_amz_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck()) {
             //--------------------------------
             // Enable Themes
             //
             $MP_amz_plugin->themes_enabled = true;
             $MP_amz_plugin->themes->css_dir = MP_AMZ_PLUGINDIR . '/css/';
    }        
}
