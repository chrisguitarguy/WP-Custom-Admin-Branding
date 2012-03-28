<?php
if( ! class_exists( 'Custom_Admin_Branding' ) ):
/**
 * Custom admin and login branding for WordPress
 *
 * @author Christopher Davis <http://christopherdavis.me>
 * @package Custom_Admin_Branding
 */
class Custom_Admin_Branding
{
    /**
     * Container for this class' arguments
     *
     * @access protected
     */
    protected $args;

    /**
     * Constructor.  Takes an array of args that customize various aspects of
     * the login and admin areas.
     *
     * The args
     *      `login_link` - The link on the login image
     *      `login_image` - URI for the image above the login form
     *      `designer_link` - URI for the login & admin footer credit link
     *      `designer_anchor` - Anchor text for login & admin footer credit link
     *      `favicon_url` - The favicon URI, added to the admin, login, & front end
     *
     * @param array $args See above
     */
    public function __construct( $args=array() )
    {
        $this->args = wp_parse_args(
            $args,
            array(
                'login_url'         => 'http://wordpress.org',
                'login_image'       => false,
                'login_title'       => get_bloginfo( 'site_name' ),
                'designer_url'      => false,
                'designer_anchor'   => false,
                'favicon_url'       => false,
                'remove_wp'         => false
            )
        );

        add_filter( 'login_headerurl', array( &$this, 'login_headerurl' ) );
        add_filter( 'admin_footer_text', array( &$this, 'admin_footer_text' ) );
        add_filter( 'login_headertitle', array( &$this, 'login_headertitle' ) );
        add_action( 'login_head', array( &$this, 'login_head' ) );
        add_action( 'login_footer', array( &$this, 'login_footer' ) );
        add_action( 'admin_head', array( &$this, 'add_favicon' ) );
        add_action( 'wp_head', array( &$this, 'add_favicon' ) );
        add_action( 'admin_bar_menu', array( &$this, 'admin_bar_menu' ) );
    }

    /**
     * Change the `login_headerurl` to whatever was specified in $args
     *
     * @access public
     */
    public function login_headerurl( $url )
    {
        return esc_url( $this->args['login_url'] );
    }

    /**
     * Change `login_headerurl` to what was specified in the $args
     *
     * @access public
     */
    public function login_headertitle( $title )
    {
        return esc_attr( $this->args['login_title'] );
    }

    /**
     * Login header.  Adds the favicon and `login_image` specified in the $args
     *
     * @access public
     */
    public function login_head()
    {
        $this->add_favicon();
        echo "<style type='text/css'>\n";
        if( $this->args['login_image'] )
        {
            printf(
                ".login h1 a { background: url(%s) no-repeat top center; }\n",
                esc_url( $this->args['login_image'] )
            );
        }
        echo '.custom-login-branding { text-align: center; margin-top: 100px }';
        echo "</style>\n";
    }

    /**
     * Adds the favicon specified in the $args
     *
     * @access public
     */
    public function add_favicon()
    {
        if( ! $this->args['favicon_url'] ) return;
        printf(
            "<link rel='shortcut icon' href='%s' />\n",
            esc_url( $this->args['favicon_url'] )
        );
    }

    /**
     * Spit out the designer credits (if present in $args) on the login footer
     *
     * @access public
     */
    public function login_footer()
    {
        if( $link = $this->designer_link() )
        {
            echo "<div class='custom-login-branding'>{$link}</div>\n";
        }
    }

    /**
     * Adds the designer link (`$args['designer_url']` & `args['designer_anchor`])
     * to the admin footer.
     *
     * @access public
     */
    public function admin_footer_text( $text )
    {
        $text_arr = explode( ' &bull; ', $text );
        if( $designer = $this->designer_link() )
        {
            array_unshift( $text_arr, $designer );
        }
        return implode( ' &bull; ', $text_arr );
    }

    /**
     * Maybe removes the "W" logo from the admin menu
     *
     * @access public
     */
    public function admin_bar_menu( $admin_bar )
    {
        if( ! $this->args['remove_wp'] ) return;
        $admin_bar->remove_node( 'wp-logo' );
    }

    /**
     * Make a nice designer credit link
     *
     * @access protected
     */
    protected function designer_link()
    {
        $rv = '';
        if( $this->args['designer_url'] && $this->args['designer_anchor'] )
        {
            $rv = sprintf(
                '<a href="%1$s" title="%2$s" rel="external">%2$s</a>',
                esc_url( $this->args['designer_url'] ),
                esc_attr( $this->args['designer_anchor'] )
            );
        }
        return $rv;
    }
} // end class
endif; // end class_exists
