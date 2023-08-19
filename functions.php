<?php defined( 'App' ) or die( 'BoidCMS' );
/**
 *
 * Minimalist Elegance for Your Blog
 *
 * @package Theme_Noir
 * @author Shuaib Yusuf Shuaib
 * @version 1.0.0
 */

global $App;
$App->set_action( 'render', 'noir_activate' );
$App->set_action( 'change_theme', 'noir_deactivate' );
$App->set_action( 'admin_end', 'noir_admin_script' );
$App->set_action( 'tpl', 'noir_custom_template' );
$App->set_action( 'noir', 'noir_text_filter' );
$App->set_action( 'admin', 'noir_admin' );

/**
 * Initialize Noir
 * @return void
 */
function noir_activate(): void {
  global $App;
  if ( 'noir' === $App->get( 'theme' ) ) {
    if ( ! $App->get( 'noir' ) ) {
      
      $config = array();
      $config[ 'per' ] = 5;
      $config[ 'excerpt' ] = 300;
      $config[ 'seperator' ] = '–';
      $config[ 'attribution' ] = true;
      
      // Menu item 1
      $config[ 'menu' ] = array();
      $config[ 'menu' ][0] = array();
      $config[ 'menu' ][0][ 'text' ] = 'Home';
      $config[ 'menu' ][0][ 'link' ] = $App->url();
      
      // Menu item 2
      $config[ 'menu' ][1] = array();
      $config[ 'menu' ][1][ 'text' ] = 'About';
      $config[ 'menu' ][1][ 'link' ] = $App->url( 'about' );
      
      // Menu item 3
      $config[ 'menu' ][2] = array();
      $config[ 'menu' ][2][ 'text' ] = 'Contact';
      $config[ 'menu' ][2][ 'link' ] = $App->url( 'contact' );
      
      // Text filter
      $config[ 'text' ] = array();
      $config[ 'text' ][ 'by' ] = '';
      $config[ 'text' ][ 'blog' ] = '';
      $config[ 'text' ][ 'read-more' ] = '';
      $config[ 'text' ][ 'site-title' ] = '';
      $config[ 'text' ][ 'recent-posts' ] = '';
      $config[ 'text' ][ 'no-recent-posts' ] = '';
      $config[ 'text' ][ 'proudly-powered-by' ] = '';
      
      // Author information
      $config[ 'author' ] = array();
      $config[ 'author' ][ 'name' ] = 'John Doe';
      $config[ 'author' ][ 'link' ] = $App->url( 'about' );
      
      $App->set( $config, 'noir' );
    }
  }
}

/**
 * Deactivate and free database space
 * @param string $theme
 * @return void
 */
function noir_deactivate( string $theme ): void {
  global $App;
  if ( 'noir' !== $theme ) {
    $App->unset( 'noir' );
  }
}

/**
 * Custom template
 * @return string
 */
function noir_custom_template(): string {
  return ',post.php,';
}

/**
 * Text filtering
 * @param mixed $text
 * @param string $index
 * @return mixed
 */
function noir_text_filter( mixed $text, string $index ): mixed {
  if ( ! is_string( $text ) ) return $text;
  $filter = ( noir_config( 'text', false )[ $index ] ?? $text );
  return ( empty( trim( $filter ) ) ? $text : $filter );
}

/**
 * Noir configurations
 * @param string $index
 * @param bool $esc
 * @return mixed
 */
function noir_config( string $index, bool $esc = true ): mixed {
  global $App;
  $conf = ( $App->get( 'noir' )[ $index ] ?? null );
  return ( $esc ? $App->esc( $conf ) : $conf );
}

/**
 * Site configurations
 * @param string $index
 * @param bool $esc
 * @return mixed
 */
function noir_site_config( string $index, bool $esc = true ): mixed {
  global $App;
  $conf = $App->get( $index );
  return ( $esc ? $App->esc( $conf ) : $conf );
}

/**
 * Page data
 * @param string $index
 * @param bool $esc
 * @return mixed
 */
function noir_page_data( string $index, bool $esc = true, ?string $slug = null ): mixed {
  global $App;
  $value = $App->page( $index, $slug );
  return ( $esc ? $App->esc( $value ) : $value );
}

/**
 * Blog title
 * @return string
 */
function noir_blog_title(): string {
  global $App;
  $site = noir_site_config( 'title' );
  $seperator = ( ' ' . noir_config( 'seperator' ) . ' ' );
  $custom_title = $App->get_filter( '', 'noir', 'blog' );
  $custom_title = ( ! empty( trim( $custom_title ) ) ? $custom_title : false );
  return sprintf( '%s%s', $custom_title ? $custom_title . $seperator : '', $site );
}

/**
 * Current page title
 * @return string
 */
function noir_page_title(): string {
  $title  = noir_page_data( 'title' );
  $title .= ' ' . noir_config( 'seperator' );
  $title .= ' ' . noir_site_config( 'title' );
  return $title;
}

/**
 * Current page description
 * @return string
 */
function noir_page_description(): string {
  $descr = noir_page_data( 'descr' );
  return ( empty( $descr ) ? noir_post_excerpt() : $descr );
}

/**
 * Current pagination page
 * @return int
 */
function noir_pagination_page(): int {
  $page = ( $_GET[ 'page' ] ?? 1 );
  $page = intval( is_array( $page ) ? 1 : $page );
  $page = ( $page > noir_pagination_total() ? 1 : $page );
  $page = ( $page < 1 ? 1 : $page );
  return $page;
}

/**
 * Total pagination pages
 * @return int
 */
function noir_pagination_total(): float {
  global $App;
  $pages = $App->data()[ 'pages' ];
  foreach ( $pages as $slug => $page ) {
    if ( 'post' !== $page[ 'type' ] || ! $page[ 'pub' ] ) {
      unset( $pages[ $slug ] );
    }
  }
  $count = count( $pages );
  $limit = noir_config( 'per', false );
  return ceil( $count / $limit );
}

/**
 * Published posts
 * @return array
 */
function noir_published_posts(): array {
  global $App;
  $posts = array();
  $pages = $App->data()[ 'pages' ];
  $pages = array_reverse( $pages, true );
  $pages = $App->get_filter( $pages, 'recent_posts' );
  foreach ( $pages as $slug => $page ) {
    if ( 'post' === $page[ 'type' ] && $page[ 'pub' ] ) {
      $posts[ $slug ] = $page;
    }
  }
  return $posts;
}

/**
 * Recent posts
 * @return array
 */
function noir_recent_posts(): array {
  global $App;
  $posts = noir_published_posts();
  $pagination = noir_pagination_page();
  $per_page = noir_config( 'per', false );
  $offset = ( ( $pagination - 1 ) * $per_page );
  return array_slice( $posts, $offset, $per_page, true );
}

/**
 * Post excerpt
 * @param ?string $post
 * @return string
 */
function noir_post_excerpt( ?string $post = null ): string {
  global $App;
  $post ??= $App->page;
  $max = noir_config( 'excerpt', false );
  $content = $App->page( 'content', $post );
  $excerpt = str_replace( '<', ' <', $content ?? '' );
  $excerpt = substr( strip_tags( $excerpt, [ 'strong' ] ), 0, $max );
  $excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ), ' .' );
  return ltrim( $excerpt . '...', '.' );
}

/**
 * Menu builder script
 * @return string
 */
function noir_admin_script(): string {
  global $App, $page;
  if ( 'noir' !== $page ) return '';
  $script = $App->theme( 'js/admin.js', false );
  return sprintf( '<script src="%s"></script>', $script );
}

/**
 * Admin setting
 * @return void
 */
function noir_admin(): void {
  global $App, $layout, $page;
  switch ( $page ) {
    case 'noir':
      $layout[ 'title' ] = 'Noir';
      $layout[ 'content' ] = '
      <form action="' . $App->admin_url( '?page=noir', true ) . '" method="post">
        <fieldset id="menu" class="ss-fieldset ss-list ss-mb-7 ss-mobile ss-w-6 ss-mx-auto">
          <legend class="ss-legend ss-h3">Menu</legend>
          <p><button type="button" class="ss-btn ss-success" onclick="document.querySelector(\'#menu\').innerHTML+=createMenu()">Add Item</button></p>';
      foreach ( noir_config( 'menu', false ) as $i => $item ) {
        $layout[ 'content' ] .= '
        <li id="item_' . $i . '">
          <label class="ss-label">Menu Item: ' . $i . '</label>
          <input type="text" name="menu[' . $i . '][text]" value="' . $App->esc( $item[ 'text' ] ) . '" class="ss-input" required>
          <p class="ss-small ss-mb-5">The text that will be displayed on the menu item in the navigation menu.</p>
          <input type="text" name="menu[' . $i . '][link]" value="' . $App->esc( $item[ 'link' ] ) . '" class="ss-input" required>
          <p class="ss-small ss-mb-5">The URL that the menu item will link to when clicked.</p>
          <div class="ss-btn-group ss-mb-2">
            <button type="button" class="ss-btn ss-info" onclick="moveMenuUp(this.parentNode)">Up</button>
            <button type="button" class="ss-btn ss-info" onclick="moveMenuDown(this.parentNode)">Down</button>
            <button type="button" class="ss-btn ss-error" onclick="if(confirm(\'Are you sure you want to remove this item?\'))this.parentNode.parentNode.remove()">Remove</button>
          </div>
        </li>';
      }
      $layout[ 'content' ] .= '
        </fieldset>
        <fieldset id="author" class="ss-fieldset ss-mb-7 ss-mobile ss-w-6 ss-mx-auto">
          <legend class="ss-legend ss-h3">Author</legend>
          <label for="author_name" class="ss-label">Name <span class="ss-red">*</span></label>
          <input type="text" id="author_name" name="author[name]" value="' . $App->esc( noir_config( 'author', false )[ 'name' ] ) . '" class="ss-input" required>
          <p class="ss-small ss-mb-5">The public name of the site author.</p>
          <label for="author_link" class="ss-label">Link <span class="ss-red">*</span></label>
          <input type="text" id="author_link" name="author[link]" value="' . $App->esc( noir_config( 'author', false )[ 'link' ] ) . '" class="ss-input" required>
          <p class="ss-small ss-mb-5">This is the author\'s specific link, for example, the <b>About Me</b> or <b>Contact Me</b> page.</p>
        </fieldset>
        <fieldset id="text" class="ss-fieldset ss-mb-7 ss-mobile ss-w-6 ss-mx-auto">
          <legend class="ss-legend ss-h3">Text Filter</legend>
          <label for="site_title" class="ss-label">Custom Site Title</label>
          <input type="text" id="site_title" name="text[site-title]" value="' . $App->esc( noir_config( 'text', false )[ 'site-title' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows you to replace the site title in the header with custom text or HTML. It can be useful when the title is too long, or you simply want to display different text in its place.</p>
          <label for="text_blog" class="ss-label">Custom Blog Page Title</label>
          <input type="text" id="text_blog" name="text[blog]" value="' . $App->esc( noir_config( 'text', false )[ 'blog' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows for a custom text to be added to the blog title format, which will be displayed alongside the site title.</p>
          <label for="recent_posts" class="ss-label">Custom "Recent Posts" Text</label>
          <input type="text" id="recent_posts" name="text[recent-posts]" value="' . $App->esc( noir_config( 'text', false )[ 'recent-posts' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows you to customize the text that appears in place of the default "Recent Posts" text on the blog page.</p>
          <label for="no_recent_posts" class="ss-label">Custom "No recent posts!" Text</label>
          <input type="text" id="no_recent_posts" name="text[no-recent-posts]" value="' . $App->esc( noir_config( 'text', false )[ 'no-recent-posts' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows you to customize the text that appears in place of the default "No recent posts!" text on the blog page.</p>
          <label for="by" class="ss-label">Custom "By" Text</label>
          <input type="text" id="by" name="text[by]" value="' . $App->esc( noir_config( 'text', false )[ 'by' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows you to set a custom text to replace the default "By" text that is displayed in the posts list and in the "post.php" custom template.</p>
          <label for="read_more" class="ss-label">Custom "Read More" Text</label>
          <input type="text" id="read_more" name="text[read-more]" value="' . $App->esc( noir_config( 'text', false )[ 'read-more' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This field allows you to replace the default "Read more &rarr;" text that appears on the blog\'s post list.</p>
          <label for="proudly_powered_by" class="ss-label">Custom "Proudly Powered By" Text</label>
          <input type="text" id="proudly_powered_by" name="text[proudly-powered-by]" value="' . $App->esc( noir_config( 'text', false )[ 'proudly-powered-by' ] ) . '" class="ss-input">
          <p class="ss-small ss-mb-5">This is the text that replaces the default "Proudly powered by" text in the footer of every page.</p>
        </fieldset>
        <label for="per" class="ss-label">Posts Per Page <span class="ss-red">*</span></label>
        <input type="number" id="per" name="per" value="' . noir_config( 'per' ) . '" min="1" class="ss-input ss-mobile ss-w-6 ss-auto" required>
        <p class="ss-small ss-mb-5">The maximum number of posts to display on a single page.<br>This determines how many posts visitors will see at once before they need to navigate to the next page.</p>
        <label for="excerpt" class="ss-label">Excerpt Character Limit <span class="ss-red">*</span></label>
        <input type="number" id="excerpt" name="excerpt" value="' . noir_config( 'excerpt' ) . '" min="1" class="ss-input ss-mobile ss-w-6 ss-auto" required>
        <p class="ss-small ss-mb-5">The maximum number of characters used to generate post excerpts.</p>
        <label for="seperator" class="ss-label">Title Seperator <span class="ss-red">*</span></label>
        <input type="text" id="seperator" name="seperator" value="' . noir_config( 'seperator' ) . '" class="ss-input ss-mobile ss-w-6 ss-auto" required>
        <p class="ss-small ss-mb-5">Character to use as a title separator in the "&lt;title&gt;" tag.</p>
        <label for="attr" class="ss-label">BoidCMS Attribution (Powered By Text)</label>
        <select id="attr" name="attr" class="ss-select ss-mobile ss-w-6 ss-auto">
          <option value="true"' . ( noir_config( 'attribution', false ) ? ' selected' : '' ) . '>Yes</option>
          <option value="false"' . ( noir_config( 'attribution', false ) ? '' : ' selected' ) . '>No</option>
        </select>
        <p class="ss-small ss-mb-5">Display "<a href="#proudly_powered_by">Proudly powered by</a>" text which indicates that your site is built using BoidCMS.<br>This text will be displayed in the footer of every page.</p>
        <input type="hidden" name="token" value="' . $App->token() . '">
        <input type="submit" name="save" value="Save" class="ss-btn ss-mobile ss-w-5">
      </form>';
      if ( isset( $_POST[ 'save' ] ) ) {
        $App->auth();
        $conf = array();
        $conf[ 'menu' ] = array_values( $_POST[ 'menu' ] ?? array() );
        $conf[ 'author' ] = ( $_POST[ 'author' ] ?? array() );
        $conf[ 'text' ] = ( $_POST[ 'text' ] ?? array() );
        $conf[ 'per' ] = intval( $_POST[ 'per' ] ?? 5 );
        $conf[ 'excerpt' ] = intval( $_POST[ 'excerpt' ] ?? 300 );
        $conf[ 'seperator' ] = trim( $_POST[ 'seperator' ] ?? '–' );
        $conf[ 'attribution' ] = filter_input( INPUT_POST, 'attr', FILTER_VALIDATE_BOOL );
        if ( $App->set( $conf, 'noir' ) ) {
          $App->alert( 'Settings saved successfully.', 'success' );
          $App->go( $App->admin_url( '?page=noir' ) );
        }
        $App->alert( 'Failed to save settings, please try again.', 'error' );
        $App->go( $App->admin_url( '?page=noir' ) );
      }
      require_once $App->root( 'app/layout.php' );
      break;
  }
}
?>
