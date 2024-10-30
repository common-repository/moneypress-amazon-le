<?php
/****************************************************************************
 ** file: csl_helpers.php
 **
 ** Generic helper functions.  May live in WPCSL-Generic soon.
 ***************************************************************************/

 
/**************************************
 ** function: csl_mpamz_setup_admin_interface
 **
 ** Builds the interface elements used by WPCSL-generic for the admin interface.
 **/
function csl_mpamz_setup_admin_interface() {
    global $MP_amz_plugin;
    
    // Don't have what we need? Leave.
    if (!isset($MP_amz_plugin)) {
        print 'no base class instantiated<br/>';
        return; 
    }

    // Already been here?  Get out.
    if (isset($MP_amz_plugin->settings->sections['How to Use'])) { return; }
    
    //-------------------------
    // How to Use Section
    //-------------------------
    
    $MP_amz_plugin->settings->add_section(
        array(
            'name' => 'How to Use',
            'description' => file_get_contents(MP_AMZ_PLUGINDIR.'/how_to_use.txt')
        )
    );
        

    //-------------------------
    // Amazon Settings Section
    //-------------------------    
    $section    = __('Amazon Settings', MP_AMZ_PREFIX);
    
    $MP_amz_plugin->settings->add_section(
        array(
            'name'        => $section,
            'description' => 'These settings affect how we talk to Amazon.'.
                                '<br/><br/>'
        )
    );
    
    $label      = __('Secret Access Key',MP_AMZ_PREFIX);
    $hint       = __(
        'Your Amazon Secret Access Key.  You will need to ' .
        '<a href="https://affiliate-program.amazon.com/">'.
        'go to Amazon</a> to get your Key.',                
        MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'secret_access_key','text',true,
        $hint
    );

    
    $label      = __('AWS Access Key ID',MP_AMZ_PREFIX);
    $hint       = __(
        'Your Amazon Web Services Access Key ID. '.
        'This is different than the secret key.  You will need to ' .
        '<a href="https://affiliate-program.amazon.com/">'.
        'go to Amazon</a> to get your AWS Access Key.',                
        MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'AWSAccessKeyId','text',true,
        $hint
    );    
    
    $label      = __('Associate Tag',MP_AMZ_PREFIX);
    $hint       = __('Your Amazon Associates site tag.  '.
        'Enter the 10 letter+2-digit associate tag Amazon gave to your '.
        'site so you can earn credit for sales.',MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'AssociateTag', 'text', false, 
        $hint
    );
        
    
    $label      = __('Amazon Site',MP_AMZ_PREFIX);
    $hint       = __('Select the Amazon site to pull data from.',MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'amazon_site', 'list', false, 
        $hint,
        array(
            'United States' =>  'ecs.amazonaws.com',
            'Canada'        =>  'ecs.amazonaws.ca',
            'Denmark'       =>  'ecs.amazonaws.de',
            'France'        =>  'ecs.amazonaws.fr',
            'Japan'         =>  'ecs.amazonaws.jp',
            'United Kingdom'=>  'ecs.amazonaws.co.uk',
            )
    );
    
            
    $label      = __('Default Search Index',MP_AMZ_PREFIX);
    $hint       = __('Which Amazon Search Index do you want to use?',MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'SearchIndex', 'list', false,
        $hint,
        array(
            'All' => 'All',
            'Apparel' => 'Apparel',
            'Automotive' => 'Automotive',
            'Baby' => 'Baby',
            'Beauty' => 'Beauty',
            'Blended' => 'Blended',
            'Books' => 'Books',
            'Classical' => 'Classical',
            'DigitalMusic' => 'DigitalMusic',
            'DVD' => 'DVD',
            'Electronics' => 'Electronics',
            'ForeignBooks' => 'ForeignBooks',
            'GourmetFood' => 'GourmetFood',
            'Grocery' => 'Grocery',
            'HealthPersonalCare' => 'HealthPersonalCare',
            'Hobbies' => 'Hobbies',
            'HomeGarden' => 'HomeGarden',
            'Industrial' => 'Industrial',
            'Jewelry' => 'Jewelry',
            'KindleStore' => 'KindleStore',
            'Kitchen' => 'Kitchen',
            'Magazines' => 'Magazines',
            'Merchants' => 'Merchants',
            'Miscellaneous' => 'Miscellaneous',
            'MP3Downloads' => 'MP3Downloads',
            'Music' => 'Music',
            'MusicalInstruments' => 'MusicalInstruments',
            'MusicTracks' => 'MusicTracks',
            'OfficeProducts' => 'OfficeProducts',
            'OutdoorLiving' => 'OutdoorLiving',
            'PCHardware' => 'PCHardware',
            'PetSupplies' => 'PetSupplies',
            'Photo' => 'Photo',
            'Software' => 'Software',
            'SoftwareVideoGames' => 'SoftwareVideoGames',
            'SportingGoods' => 'SportingGoods',
            'Tools' => 'Tools',
            'Toys' => 'Toys',
            'VHS' => 'VHS',
            'Video' => 'Video',
            'VideoGames' => 'VideoGames',
            'Watches' => 'Watches',
            'Wireless' => 'Wireless',
            'WirelessAccessories' => 'WirelessAccessories'
        )
    );        
    
    $label      = __('Request Timeout',MP_AMZ_PREFIX);
    $hint       = __('How long, in seconds, do we wait to hear back from Amazon. (default:30)',MP_AMZ_PREFIX);
    $MP_amz_plugin->settings->add_item(
        $section,$label, 
        'wait_for', 'text', false, 
        $hint
    );    
    
}

/**************************************
 ** function: csl_mpamz_admin_stylesheet
 **
 ** Add the admin stylesheets to admin pages.
 **/
function csl_mpamz_activate() {
    global $MP_amz_plugin, $wpdb;
        
    // Check Registration
    //
    if(!$MP_amz_plugin->no_license) {    
        if (!$MP_amz_plugin->license->check_license_key()) {
            $MP_amz_plugin->notifications->add_notice(
                2,
                "Your license " . get_option(MP_AMZ_PREFIX . '-license_key') . " could not be validated."
            );        
        }
    }        
}

/**************************************
 ** function: csl_mpamz_admin_stylesheet
 **
 ** Add the admin stylesheets to admin pages.
 **/
function csl_mpamz_admin_stylesheet() {
    if ( file_exists(MP_AMZ_COREDIR.'css/admin.css')) {
        wp_register_style('csl_mpamz_admin_css', MP_AMZ_COREURL .'css/admin.css'); 
        wp_enqueue_style ('csl_mpamz_admin_css');
    }  
}


/**************************************
 ** function: csl_mpamz_user_stylesheet
 **
 ** Add the user stylesheets to user pages.
 **/
function csl_mpamz_user_stylesheet() {
    global $MP_amz_plugin;
    $MP_amz_plugin->themes->assign_user_stylesheet();
}


