<?php
/*
 * Template Name: Blog page
 *
 * @package shift_cv
*/
get_header(); 

$mult = min(2, max(1, get_theme_option("retina_ready")));

$profile_title = get_theme_option('profile_title');
$home = get_site_url();
if (get_theme_option('homepage')=='blog')
	$home .= (my_strpos($home, '?')===false ? '?' : '&') . 'cv=1';
?>
	<section id="profile" class="section profile_section odd first blog_page">
		<a href="<?php echo $home; ?>" id="profile_page_link"><span class="icon-user icon"></span><span class="label"><?php echo $profile_title; ?></span></a>
		<div class="section_header profile_section_header">
			<?php
				// User data
				$user_lastname = get_theme_option('user_lastname');
				$user_firstname = get_theme_option('user_firstname');
				$user_photo = getResizedImageURL(get_theme_option('user_photo'), 117*$mult, 117*$mult);
				$user_position = get_theme_option('user_position');
			?>
			<div id="profile_header">
				<div id="profile_user">
                	<?php if($user_photo) { ?>
					<div id="profile_photo"><img src="<?php echo $user_photo; ?>" alt="<?php echo $user_lastname.' '.$user_firstname; ?>" border="0" /></div>
					<?php } ?>
					<div id="profile_name_area">
						<div id="profile_name">
							<h1 id="profile_title"><span class="firstname"><?php echo $user_firstname; ?></span> <span class="lastname"><?php echo $user_lastname; ?></span></h1>
							<h4 id="profile_position"><?php echo $user_position; ?></h4>
						</div>								
					</div>
				</div>	
			</div>	
		</div>
	</section>	
	<section id="breadcrumbs" class="section breadcrumbs_section even">
		<div class="section_header breadcrumbs_section_header">
			<?php showBreadcrumbs( array('home' => get_theme_option('homepage')!='blog' ? __('Home', 'wpspace') : '', 'truncate_title' => 50, 'show_all_posts'=>true ) ); ?>
		</div>
	</section>	
	<div id="primary" class="content_area">
		<div id="content" class="site_content blog_content" role="main">
		<?php

			if ( is_author() ) {				// -------------- Author page
				get_template_part('template', 'blog_author');
			}

			/* Start the Loop */
			global $wp_query, $more, $post;
			$page_number = get_query_var('paged') ? get_query_var('paged') : 1;
			$wp_query_need_restore = false;
			if ( is_page() || isset($_REQUEST['prt']) || isset($_REQUEST['rsm'])) {
				$args = $wp_query->query_vars;
				$args['post_type'] =  isset($_REQUEST['prt']) ? 'portfolio' : (isset($_REQUEST['rsm']) ? 'resume' : 'post');
				$args['order'] = 'DESC';
				$args['orderby'] = 'date';
				unset($args['p']);
				unset($args['page_id']);
				unset($args['pagename']);
				unset($args['name']);
				$args['posts_per_page'] = get_option('posts_per_page');
				if ($page_number > 1) $args['ignore_sticky_posts'] = 1;
				query_posts( $args );
				$wp_query_need_restore = true;
			}
			$per_page = count($wp_query->posts);
			$post_number = 0;

			$oldmore = $more;
			$more = 0;

			while ( have_posts() ) : 
				
				the_post();
				$post_number++;
				
				$post_id = get_the_ID();
				$post_format = get_post_format();
				$post_format_data = ($post_format ? trim(chop(get_post_meta($post_id, 'custom_post_format', true))) : '');
				$post_link = get_permalink();
				$post_title = getPostTitle();
				$post_descr = getPostDescription();
				$post_content = apply_filters('the_content', get_the_content(__('<span class="readmore">Read more</span>', 'wpspace')));
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));
				$post_comments = get_comments_number();
				$post_protected = post_password_required();
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_video = $post_link_url = '';
				$post_icon = 'icon-pencil';
				$title_level = get_theme_option('title_level')+1;
				if($post_format == 'gallery') {
					$post_icon = 'icon-camera';
				}
				else if($post_format == 'audio') {
					$post_icon = 'icon-music';
				}
				else if($post_format == 'link') {
					$post_icon = 'icon-link';
				}
				else if($post_format == 'video') {
					$post_icon = 'icon-eye-open';
				}
				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a href="' . $post_categories[$i]['link'] . '" class="post_categories '. ($i%2==0 ? 'even' : 'odd') . ($i==0 ? ' first' : '') . ($i==count($post_categories)-1 ? ' last' : '') . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a>';
				}
				
				$post_thumb = getResizedImageTag($post_id, 510*$mult, 250*$mult); //get_ the_post_thumbnail( $post_id, 'blogstream');
				$post_video_thumb = getResizedImageTag($post_id, 510*$mult, 295*$mult); //get_ the_post_thumbnail( $post_id, 'blogstream');
				$post_date = get_the_date();
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;
				
				if (!$post_protected) {
					if ($post_format == 'gallery' && $post_format_data != "") {
						$post_photos = array();
						$photos = explode("\n", $post_format_data);
						foreach ($photos as $ph) {
							if (trim(chop($ph)) != '')
								$post_photos[] = trim(chop($ph));
						}
					} else if ($post_format == 'video' && $post_format_data != "") {
						$urls = explode("\n", $post_format_data);
						$post_video = getVideoPlayerURL($urls[0]);
					} else if ($post_format == 'link') {
						$urls = explode("\n", $post_format_data);
						$post_link_url = trim(chop($urls[0]));
					}
				}
				
				$post_body = '
					<section class="section blog_section ' . ($post_number%2==0 ? 'even' : 'odd') . ($post_number==0? ' first' : '') . ($post_number==$per_page? ' last' : '') . '">
						<div class="section_header blog_section_header '.$post_format.'">
							<h2 class="section_title blog_section_title"><strong><span class="icon '.$post_icon.'"></span><span class="section_name">' . date('M.d', strtotime($post_date)) . '</span></strong></h2>
							';
				if (!$post_protected) {
					$post_body .='
							<div class="post-info">
								<a href="' . $post_author_url . '" class="post_author"><span class="icon-user"></span>'.$post_author.'</a>
								<a href="' . $post_link . '" class="comments_count"><span class="icon-comment"></span>' . $post_comments . '</a>
								' . ($post_categories_str ? '<span class="post_categories"><span class="icon-align-left"></span>' . $post_categories_str . '</span>' : '') . '
							</div>';
				}
				$post_body .= '
						</div>
						<div class="section_body blog_section_body">
							<article id="post_' . $post_id . '" class="' . join(' ', get_post_class('post format-' . ($post_format ? $post_format : 'standard')) ) . '">
								<h'.$title_level.' class="post_title"><a href="'.$post_link.'">' . $post_title . '</a></h'.$title_level.'>';
				if ($post_protected) {
					$post_body .= '
								<div class="text">' . getShortString($post_descr, 160) . '</div>';
				} else {
					if ($post_thumb && !$post_format_data && $post_format != 'quote' && $post_format != 'link') {
						$post_body .= '	
								<div class="pic">
									<a href="' . $post_link . '" class="w_hover img-link img-wrap">' . $post_thumb . '
									<span class="overlay"></span>
									<span class="link-icon"></span>
									</a>
								</div>';
					} else if ($post_format == 'gallery' && isset($post_photos) && count($post_photos) > 0) {
						$post_body .= '
								<div class="slider_container">
									<ul class="slides">';
						foreach ($post_photos as $photo) {
							$post_body .= '<li><a href="'.$post_link.'" class="w_hover"><img src="'.$photo.'" alt=""><span class="overlay"></span></a></li>';
						}
						$post_body .= '						
									</ul>
								</div>
						';
					} else if ($post_format == 'video' && $post_video) {
						$post_body .= '
								<div class="video_container">';
						?>
								<?php 
								if(has_post_thumbnail($post_id)){
									$post_body .= '	<div class="video_thumb"><span class="play_button"></span>'.$post_video_thumb.'</div>';
							
						$post_body .=' 		
								<script>
								jQuery(window).load(function(){
									var frame_code = \'<iframe class="video_frame" src="' . $post_video . '?wmode=opaque&autoplay=1" width="620" height="295" frameborder="0" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowFullScreen="allowFullScreen"></iframe>\';
									jQuery(".video_thumb").click(function(){
										jQuery(this).html(frame_code);
									});	
								});
								</script>
								</div>
						';
						}
						else{
							$post_body .= '<iframe class="video_frame" src="' . $post_video . '?wmode=opaque" width="620" height="295" frameborder="0" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowFullScreen="allowFullScreen"></iframe></div>';
						}
					} else if ($post_format == 'audio' && $post_format_data) {
						$urls = explode("\n", $post_format_data);
						$post_body .= '
								<audio src="'.trim(chop($urls[0])).'" controls="controls" type="audio/mp3" width="100%" height="60"></audio>
						';
					}
				}
				if ($post_format == 'quote') {
				} else if ($post_format == 'audio') {
				} else if ($post_format == 'link') {
					$post_body .='
								<a href="'.$post_link_url.'" class="post_link">
									<span class="link_url">'.$post_link_url.'</span>
								</a>
						';
				} else {
					$post_body .= '<div class="text">' . $post_content . '</div>';
					//$post_body .= '<a href="'.get_permalink().'" class="more-link">Read More<span></span></a>';
				}
				$post_body .= '
							</article>
						</div>
					</section>
				';
				echo $post_body;
			endwhile; 
			
			if (!$post_number) { 
			?>
				<section class="section blog_section">
					<div class="section_header blog_section_header">
					</div>
					<div class="section_body blog_section_body">
						<article class="post">
							<?php if (is_404()) { ?>
								<h3 class="post_title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'wpspace' ); ?></h3>
								<div class="text">
									<?php _e( 'It looks like nothing was found at this location. Please, ', 'wpspace' ); ?>
									<a href="<?php echo get_site_url(); ?>"><?php _e( 'start from our homepage', 'wpspace' ); ?></a>
								</div>
							<?php } else { ?>
								<div class="text">
									<h3 class="post_title"><?php _e( 'Search results:', 'wpspace' ); ?></h3>
									<p class="search_no_results">
										<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
									</p>
								</div>
							<?php } ?>
						</article>
					</div>
				</section>
			<?php
			}
			showPagination();

			$more = $oldmore;

			if ( $wp_query_need_restore ) wp_reset_query();
		?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php 
	wp_reset_postdata();
	get_sidebar();
	get_footer(); 
?>
