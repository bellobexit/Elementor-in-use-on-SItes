<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );


/* Remove Links From Admin-bar */
function remove_admin_bar_links() {
    global $wp_admin_bar, $current_user;

    if ($current_user->ID != 1) {
        $wp_admin_bar->remove_menu('updates');          // Remove the updates link
        $wp_admin_bar->remove_menu('comments');         // Remove the comments link
        $wp_admin_bar->remove_menu('new-content');      // Remove the content link
        $wp_admin_bar->remove_menu('edit');      // Remove the content link
        $wp_admin_bar->remove_menu('elementor_edit_page');      // Remove the content link
        $wp_admin_bar->remove_menu('wp-admin-bar-woolementor');      // Remove woolementor
        $wp_admin_bar->remove_menu('woolementor');      // Remove woolementor
        $wp_admin_bar->remove_menu('customize');      // Remove customizer

        
    }
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );




/* Clean up the admin sidebar navigation */
function remove_admin_menu_items() {
  $remove_menu_items = array(__('Posts'),__('Links'), __('Comments'),__('Tools'),__('Appearance'),__('Templates'),__('Pages'),__('Users'),__('Elementor'),__('Settings'));
  global $menu;
  end ($menu);
  while (prev($menu)){
    $item = explode(' ',$menu[key($menu)][0]);
    if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
      unset($menu[key($menu)]);
    }
  }
  remove_menu_page( 'element_pack_options' );
  remove_menu_page( 'edit.php?post_type=acf-field-group' );
  remove_menu_page( 'elementor' );
  remove_menu_page( 'wphb' );
  remove_menu_page( 'wp-mail-smtp' );
  remove_menu_page( 'woolementor' );
  remove_menu_page( 'edit-tags.php?taxonomy=product_tag&post_type=product' );
  remove_menu_page( 'post_type=product&page=product_attributes' );
  remove_menu_page( 'page=product_attributes' );

}
add_action('admin_menu', 'remove_admin_menu_items', 9999);


/*
* Remove "My Sites" Sub-Menu Options: Dashboard, New Post, Manage Comments and Visit
Site
*/
function remove_mysites_links () {
global $wp_admin_bar;
foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
$menu_id_n = 'blog-' . $blog->userblog_id . '-n'; /* New Post var */
$menu_id_c = 'blog-' . $blog->userblog_id . '-c'; /* Manage Comments var */
$wp_admin_bar->remove_menu($menu_id_n); /*Remove New Post Link */
$wp_admin_bar->remove_menu($menu_id_c); /*Remove Manage Comments Link */
$wp_admin_bar->remove_node('site-name');
}
}
add_action( 'wp_before_admin_bar_render', 'remove_mysites_links' );


/*
* Remove Metaboxes & Widgets
Site
*/
function remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
    remove_meta_box('e-dashboard-overview', 'dashboard', 'normal'); //Removes elementor widget
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status.
    remove_meta_box('wp_mail_smtp_reports_widget_pro', 'dashboard', 'normal'); // Site Health Status.
    remove_meta_box('wc_admin_dashboard_setup', 'dashboard', 'normal'); // woocommerce.
    
}
add_action('admin_init', 'remove_dashboard_meta');


/*
* Remove Metaboxes & Widgets
Site
*/
remove_action('welcome_panel', 'wp_welcome_panel');


/*
* add a group of links under a parent link
*/
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'my-item',
        'title' => '<span class="ab-icon dashicons dashicons-arrow-down-alt2"></span> Edit Your Website',
        'href'  => '#',
        'meta'  => array(
            'title' => __('Edit Your Website'),            
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'my-sub-item',
        'parent' => 'my-item',
        'title' => 'Add/Remove Content',
        'href' => get_home_url( $blog->userblog_id, '/wp-admin/post.php?post=' ) . $front_id = get_option('page_on_front') . '&action=elementor',
        'meta'  => array(
            'title' => __('Add/Remove Content'),
            'class' => 'my_menu_item_class'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'my-second-sub-item',
        'parent' => 'my-item',
        'title' => 'Change Site Colors',
        'href' => get_home_url( $blog->userblog_id, '/wp-admin/post.php?post=' ) . $front_id = get_option('page_on_front') . '&action=elementor#e:run:panel/global/open',
        'meta'  => array(
            'title' => __('Change Site Colors'),
            'class' => 'my_menu_item_class'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'my-third-sub-item',
        'parent' => 'my-item',
        'title' => 'Edit Your Menu',
        'href' => get_home_url( $blog->userblog_id, '/wp-admin/nav-menus.php' ),
        'meta'  => array(
            'title' => __('Edit Your Menu'),
            'class' => 'my_menu_item_class'
        ),
    ));
    
    $admin_bar->add_menu( array(
        'id'    => 'my-fourth-item',
        'title' => '<span class="ab-icon dashicons dashicons-arrow-down-alt2"></span> GUIDES & SUPPORT',
        'href'  => '#',
        'meta'  => array(
            'title' => __('GUIDES & SUPPORT'),
            'class' => 'my_menu_item_class'
        ),
    ));
  
    $admin_bar->add_menu( array(
        'id'    => 'my-fourth-sub-item',
        'parent' => 'my-fourth-item',
        'title' => 'Tutorials',
        'href' => get_home_url( $blog->userblog_id, '/wp-admin/admin.php?page=tutorials' ),
        'meta'  => array(
            'title' => __('Tutorials'),
            'class' => 'my_menu_item_class'
        ),
    ));
  
    $admin_bar->add_menu( array(
        'id'    => 'my-fifth-sub-item',
        'parent' => 'my-fourth-item',
        'title' => 'Contact Support',
        'href' => get_home_url( $blog->userblog_id, '/wp-admin/admin.php?page=contact' ),
        'meta'  => array(
            'title' => __('Tutorials'),
            'class' => 'my_menu_item_class'
        ),
    ));
}


/*
* cleanup profile section 1
*/
function remove_personal_options(){
    echo '<script type="text/javascript">jQuery(document).ready(function($) {
  
$(\'form#your-profile > h2:first\').remove(); // remove the "Personal Options" title
  
$(\'form#your-profile tr.user-rich-editing-wrap\').remove(); // remove the "Visual Editor" field
  
$(\'form#your-profile tr.user-admin-color-wrap\').remove(); // remove the "Admin Color Scheme" field
  
$(\'form#your-profile tr.user-comment-shortcuts-wrap\').remove(); // remove the "Keyboard Shortcuts" field
  
$(\'form#your-profile tr.user-admin-bar-front-wrap\').remove(); // remove the "Toolbar" field
  
$(\'form#your-profile tr.user-language-wrap\').remove(); // remove the "Language" field
  
$(\'form#your-profile tr.user-first-name-wrap\').remove(); // remove the "First Name" field
  
$(\'form#your-profile tr.user-last-name-wrap\').remove(); // remove the "Last Name" field
  
$(\'form#your-profile tr.user-nickname-wrap\').hide(); // Hide the "nickname" field
  
$(\'table.form-table tr.user-display-name-wrap\').remove(); // remove the “Display name publicly as” field
  
$(\'table.form-table tr.user-url-wrap\').remove();// remove the "Website" field in the "Contact Info" section
  
$(\'h2:contains("About Yourself"), h2:contains("About the user")\').remove(); // remove the "About Yourself" and "About the user" titles
  
$(\'form#your-profile tr.user-description-wrap\').remove(); // remove the "Biographical Info" field
  
$(\'form#your-profile tr.user-profile-picture\').remove(); // remove the "Profile Picture" field
  
$(\'table.form-table tr.user-aim-wrap\').remove();// remove the "AIM" field in the "Contact Info" section
 
$(\'table.form-table tr.user-yim-wrap\').remove();// remove the "Yahoo IM" field in the "Contact Info" section
 
$(\'table.form-table tr.user-jabber-wrap\').remove();// remove the "Jabber / Google Talk" field in the "Contact Info" section
 
$(\'h2:contains("Name")\').remove(); // remove the "Name" heading
 
$(\'h2:contains("Contact Info")\').remove(); // remove the "Contact Info" heading
 
});</script>';
  
}

add_action('admin_head','remove_personal_options');

add_filter( 'wp_is_application_passwords_available', '__return_false' );

/*
* Remove additional Capabilities
*/
add_filter('additional_capabilities_display', 'remove_additional_capabilities_func');
function remove_additional_capabilities_func()
{
    return false;
}



wp_register_script( 'wp-color-picker-alpha', $url_to_picker_script . '/wp-color-picker-alpha.min.js', $dependencies, $version, true );

$color_picker_strings = array(
	'clear'            => __( 'Clear', 'textdomain' ),
	'clearAriaLabel'   => __( 'Clear color', 'textdomain' ),
	'defaultString'    => __( 'Default', 'textdomain' ),
	'defaultAriaLabel' => __( 'Select default color', 'textdomain' ),
	'pick'             => __( 'Select Color', 'textdomain' ),
	'defaultLabel'     => __( 'Color value', 'textdomain' ),
);
wp_localize_script( 'wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
wp_enqueue_script( 'wp-color-picker-alpha' );


/*
* Reorder menu
*/
function wpse_custom_menu_order( $menu_ord ) {
    if ( !$menu_ord ) return true;

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'admin.php?page=wu-my-account', // Account
        'upload.php', // Media
        'link-manager.php', // Links
        'profile.php', // Profile
        'edit.php?post_type=page', // Pages
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'separator-last', // Last separator
    );
}
add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );
add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );


/**
 * Add Edit Yor Site to Admin Menu
 */
add_action( 'admin_menu', 'linked_url' );

function linked_url() {
  add_menu_page( 'linked_url', 'EDIT YOUR SITE ®', 'read', 'my_slug', '', 'dashicons-list-view', 1 );
}

add_action( 'admin_menu' , 'linkedurl_function' );
function linkedurl_function() {
  global $menu;
  $menu[1][2] = get_home_url( $blog->userblog_id, '/wp-admin/post.php?post=' ) . $front_id = get_option('page_on_front') . '&action=elementor';
}


/**
 * Add Profile to Admin Menu
 */
add_action('admin_menu', 'profile_menu');

function profile_menu(){
    add_menu_page('profile_menu', 'Profile', 'read', 'profile.php', '', 'dashicons-list-view', 1);
}



/**
 * Single Column Admin Widgets
 */
add_action( 'admin_head-index.php', function()
{
    ?>
<style>
.postbox-container,.postbox-container-1,.postbox-container-2 {
    min-width: 50% !important;
}
.meta-box-sortables.ui-sortable.empty-container { 
    display: none;
}
</style>
    <?php
});



/**
 * Elementor Exit To Dashboard
 */
function my_exit_to_dashboard(){
$url=admin_url();
return $url;
}
add_filter('elementor/document/urls/exit_to_dashboard' , 'my_exit_to_dashboard');


function travel_eye_child_embed() {

  ?>
    
  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/60b8f289de99a4282a1b39bb/1f7976qia';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
  </script>

  <?php
} 

add_action( 'admin_footer', 'travel_eye_child_embed', 20 );




/**
 * Style Admin Appearance Menus
 */
add_action('admin_head', 'admin_menu_styles');

function admin_menu_styles() {
  echo '<style>
    .page-title-action.hide-if-no-customize,.manage-menus,#nav-menu-header,.menu-settings,.nav-tab,.delete-action{
  display: none !important;
}

.nav-tab-wrapper, .wrap h2.nav-tab-wrapper, h1.nav-tab-wrapper {
    border-bottom: 0px solid #c3c4c7 !important;
    padding-top: 5px;
}

.add-post-type-page,.add-post-type-post,.add-category{
  display: none !important;
}

.field-css-classes.description.description-thin,.field-xfn.description.description-thin,.field-description.description.description-wide,.field-title-attribute.field-attr-title.description.description-wide,.field-move.hide-if-no-js.description.description-wide
{
  display: none !important;
}

.menu-item-handle.ui-sortable-handle,.item-type
{
  max-width: 100%;
}

.drag-instructions.post-body-plain{
  width: 95%;
}

.menu-item-settings{
  max-width: 100%;
  }

#submit-customlinkdiv{
 color: white;
 background-color: #ed772e;
 border-bottom: none !important;
 text-shadow: none !important;
}

#menu-management-liquid {
    min-width: 60% !important;
}

@media (min-width: 1281px) { 
#menu-settings-column {
    width: 37% !important;
    margin-right: 3%;
} 
}

@media (min-width: 1025px) and (max-width: 1280px) {
#menu-settings-column {
    width: 32% !important;
    margin-right: 3%;
}
}

#dashboard-widgets .postbox-container .empty-container,.user-syntax-highlighting-wrap{
display: none;
}

  </style>';
}






/*
Removes submenu items from WooCommerce menu
available submenu slugs are:
wc-addons - the Add-ons submenu
wc-status - the System Status submenu
wc-reports - the Reports submenu
edit.php?post_type=shop_order - the Orders submenu
edit.php?post_type=shop_coupon - the Coupons submenu

 */

function wooninja_remove_items() {
 $remove = array( 'wc-status', 'wc-addons', 'wc-reports' );
  foreach ( $remove as $submenu_slug ) {
    if ($current_user->ID != 1) {
    remove_submenu_page( 'woocommerce', $submenu_slug );
   }
  }
}

add_action( 'admin_menu', 'wooninja_remove_items', 99, 0 );


add_filter( 'woocommerce_settings_tabs_array', 'remove_woocommerce_setting_tabs', 200, 1 );
function remove_woocommerce_setting_tabs( $array ) {

    if ($current_user->ID != 1) {
        unset( $array[ 'email' ] );
        unset( $array[ 'account' ] );
        unset( $array[ 'integration' ] );
        unset( $array[ 'advanced' ] );
        echo '<script>jQuery( document ).ready( function($) { $( \'[href="' . admin_url() . '/edit.php?post_type= wc_order_status"]\' ).hide(); } );</script>';
    }
    return $array;
}
add_action( 'admin_init', 'redirect_from_settings_screen' );
function redirect_from_settings_screen() {
    if ($current_user->ID != 1) {
        if( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'wc-settings' && !isset( $_GET['tab'] ) ) {
            wp_redirect( admin_url( '/admin.php?page=wc-settings&tab=shipping' ) );
            exit;
        }
        if( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wc_order_status' ) {
            wp_redirect( admin_url( '/admin.php?page=wc-settings&tab=shipping' ) );
            exit;
        }
    }
}


// Remove WooCommerce Marketing Hub & Analytics Menu from the sidebar - for WooCommerce v4.3+
add_filter( 'woocommerce_admin_features', function( $features ) {
	/**
	 * Filter the list of features and get rid of the features not needed.
	 * 
	 * array_values() are being used to ensure that the filtered array returned by array_filter()
	 * does not preserve the keys of initial $features array. As key preservation is a default feature 
	 * of array_filter().
	 */
	return array_values(
		array_filter( $features, function($feature) {
			return ! in_array( $feature, [ 'marketing', 'analytics', 'analytics-dashboard', 'analytics-dashboard/customizable' ] );
		} ) 
	);
} );


// Rename WooCommerce to Shop
 
add_action( 'admin_menu', 'rename_woocoomerce', 999 );
 
function rename_woocoomerce()
{
    global $menu;
 
    // Pinpoint menu item
    $woo = rename_woocommerce( 'WooCommerce', $menu );
 
    // Validate
    if( !$woo )
        return;
 
    $menu[$woo][0] = 'Shop';
}
 
function rename_woocommerce( $needle, $haystack )
{
    foreach( $haystack as $key => $value )
    {
        $current_key = $key;
        if(
            $needle === $value
            OR (
                is_array( $value )
                && rename_woocommerce( $needle, $value ) !== false
            )
        )
        {
            return $current_key;
        }
    }
    return false;
}



// Disable setup widget in WooCommerce
function disable_woocommerce_setup_remove_dashboard_widgets() {
remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'disable_woocommerce_setup_remove_dashboard_widgets', 40);