<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package shift_cv
 */

get_header();

$mult = min(2, max(1, get_theme_option("retina_ready")));
?>
	<div id="primary" class="content_area">
		<div id="content" class="site_content" role="main">

			<section id="profile" class="section profile_section first odd">
				<?php
					$blog_page = getTemplatePageId('blog');
					if ($blog_page) { ?>
						<a href="<?php echo get_permalink($blog_page); ?>" id="blog_page_link"><span class="icon-pencil icon"></span><span class="label"><?php echo __('Blog', 'wpspace') ?></span></a>
				<?php 								
					}
				?>
				<div class="section_header profile_section_header opened">
					<?php
						// User data
						$user_lastname = get_theme_option('user_lastname');
						$user_firstname = get_theme_option('user_firstname');
						$user_birthday = get_theme_option('user_birthday');
						$user_photo = getResizedImageURL(get_theme_option('user_photo'), 117*$mult, 117*$mult);
						$user_position = get_theme_option('user_position');
						$user_address = get_theme_option('user_address');
						$user_phone = get_theme_option('user_phone');
						$user_email = get_theme_option('user_email');
						$user_website = get_theme_option('user_website');
						$user_company = get_theme_option('user_company');
						$user_description = get_theme_option('user_description');
						$profile_title = get_theme_option('profile_title');
						$resume_title = get_theme_option('resume_title');
						$portfolio_title = get_theme_option('portfolio_title');
						$contacts_title = get_theme_option('contacts_title');
					?>
					<h2 class="section_title profile_section_title vis"><a href="#"><span class="icon icon-user"></span><span class="section_name"><?php echo $profile_title; ?></span></a><span class="section_icon"></span></h2>
					<div id="profile_header">
                        <div id="profile_user">
                        	<?php if($user_photo) { ?>
                            <div id="profile_photo"><img src="<?php echo $user_photo; ?>" alt="<?php echo $user_lastname.' '.$user_firstname; ?>" /></div>
                            <?php } ?>
                            <div id="profile_name_area">
                                <div id="profile_name">
                                    <h1 id="profile_title"><span class="firstname"><?php echo $user_firstname; ?></span> <span class="lastname"><?php echo $user_lastname; ?></span></h1>
                                    <h4 id="profile_position"><?php echo $user_position; ?></h4>
                                </div>                              
                            </div>
                        </div>                 
						<div id="profile_data">
							<div class="profile_row">
								<span class="th"><?php _e('Name', 'wpspace'); ?>:</span><span class="td"><?php echo $user_lastname.' '.$user_firstname; ?></span>
							</div>
							<div class="profile_row">
								<span class="th"><?php _e('Date of birth', 'wpspace'); ?>:</span><span class="td"><?php echo $user_birthday; ?></span>
							</div>
							<div class="profile_row">
								<span class="th"><?php _e('Address', 'wpspace'); ?>:</span><span class="td"><?php echo $user_address; ?></span>
							</div>
							<div class="profile_row">
								<span class="th"><?php _e('Phone', 'wpspace'); ?>:</span><span class="td"><?php echo $user_phone; ?></span>
							</div>
							<div class="profile_row">
								<span class="th"><?php _e('Email', 'wpspace'); ?>:</span><span class="td"><?php echo $user_email; ?></span>
							</div>
							<div class="profile_row">
								<span class="th"><?php _e('Website', 'wpspace'); ?>:</span><span class="td"><a href="<?php echo $user_website; ?>"><?php echo $user_website; ?></a></span>
							</div>
						</div>
						
					</div>	
				</div>
				<div class="section_body profile_section_body">
					<div class="proile_body">
						<?php echo $user_description; ?>
					</div>			
				</div>
			</section>	


<div id="mainpage_accordion_area">


<?php
	// Get resume posts
	$cats = getTaxonomiesByPostType(array('resume'), array('category_resume'));
	if (count($cats) > 0) {
?>
			<section id="resume" class="section resume_section even">
				<?php
					$home = get_site_url();
					$home .= (my_strpos($home, '?')===false ? '?' : '&') . 'prn=1';
				?>
				<?php if(get_theme_option('resume_buttons')) { ?>
				<div id="resume_buttons">
				<a href="<?php echo $home; ?>" id="resume_link" target="_blank"><span class="label"><?php echo __('Print', 'wpspace'); ?></span><span class="icon-print icon"></span></a>
					<?php if(get_theme_option('resume')) { ?>
				<a href="<?php echo get_theme_option('resume'); ?>" id="resume_link_download" target="_blank"><span class="label"><?php echo __('Download', 'wpspace'); ?></span><span class="icon-download icon"></span></a>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="section_header resume_section_header">
					<h2 class="section_title resume_section_title"><a href="#"><span class="icon icon-align-left"></span><span class="section_name"><?php echo $resume_title; ?></span></a><span class="section_icon"></span></h2>
				</div>
				<div class="section_body resume_section_body">
                	<div class="sidebar resume_sidebar">
						<?php do_action( 'before_sidebar' ); ?>
                        <?php if ( ! dynamic_sidebar( 'sidebar-resume' ) ) { ?>
                        <?php } ?>
                    </div>
                    <div class="wrapper resume_wrapper">
						<?php
                            // Get resume posts
                            global $post;
                            $cat_number = 0;
                            foreach ($cats as $cat) {
                                $cat_number++;
                                $cat_title = $cat['name'];
                                $cat_options = get_option('category_resume_term_'.$cat['term_id']);
                                $cat_color = isset($cat_options['category_resume_color']) && $cat_options['category_resume_color'] ? $cat_options['category_resume_color'] : '#000000' ;
                                $cat_title_color = isset($cat_options['category_title_color']) && $cat_options['category_title_color'] ? $cat_options['category_title_color'] : '#373737' ;
                        ?>
                        <div class="category resume_category resume_category_<?php echo $cat_number; ?><?php echo $cat_number==1 ? ' first' : ''; ?><?php echo $cat_number%2==1 ? ' even' : ' odd'; ?>">
                            <div class="category_header resume_category_header">
                                <h3 class="category_title" style="background: <?php echo $cat_title_color; ?>"><span class="category_title_icon" style="background-color:<?php echo $cat_color; ?>"></span><?php echo $cat_title; ?></h3>
                            </div>
                            <div class="category_body resume_category_body">
                            <?php
                                $args = array(
                                    'post_type' => 'resume',
                                    'post_status' => 'publish',
                                    'post_password' => '',
                                    'posts_per_page' => -1,
                                    'orderby' => 'meta_value',
									'order' => 'desc',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'category_resume',
                                            'terms' => array($cat['slug']),
                                            'field' => 'slug'
                                        )
                                    )
                                );
                                $query = new WP_Query($args); 
                                $post_number = 0;
                                if ($query->have_posts()) {
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        $post_number++;
                                        $post_id = get_the_ID();
                                        $post_link = get_permalink();
                                        $post_date = get_the_date();
                                        $post_title = getPostTitle($post_id, 50, '...');
                                        $post_descr = getPostDescription();
										
									    //$post_content = apply_filters('the_content', get_the_content('', true));
									    //$post_content = str_replace(']]>', ']]&gt;', $post_content);
										$post_content = apply_filters('the_content', get_the_content(__('<span class="readmore">Read more</span>', 'wpspace')));
										$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

                                        $post_custom = get_post_custom($post_id);
                                        $post_position = $post_custom["position"][0];
                                        $post_from = $post_custom["resume_from"][0];
                                        $post_to = $post_custom["resume_to"][0];
                                        
                                ?>
                                <article class="post resume_post resume_post_<?php echo $post_number; ?><?php echo $post_number==1 ? ' first' : ''; ?><?php echo $post_number%2==1 ? ' even' : ' odd'; ?>">
                                    <div class="post_header resume_post_header">
                                    	<?php if($post_from != '' && $post_to != '') { ?>
                                        <div class="resume_period">
                                            <span class="period_from"><?php echo $post_from; ?></span> -
                                            <span class="period_to<?php echo (int)$post_to>0 ? '' : ' period_present'; ?>"><?php echo $post_to; ?></span>								
                                        </div>
                                        <?php } ?>
                                        <h4 class="post_title"><span class="post_title_icon" style="background-color: <?php echo $cat_color; ?>"></span><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h4>
                                        <h5 class="post_subtitle"><?php echo $post_position; ?></h5>
                                    </div>
                                    <div class="post_body resume_post_body">
                                        <?php echo $post_content; ?>
                                    </div>
                                </article>
                                <?php
                                    } // while (have_posts)
                                } // if (have_posts)
                                ?>
                            </div> <!-- .category_body -->
                        </div> <!-- .category -->
                        <?php
                            }
                        ?>
                	</div> <!-- .wrapper -->
				</div> <!-- .section_body -->
			</section> <!-- #resume -->
<?php 
	} // if (count($cats)>0)
?>


<?php
	$args = array(
		'post_type' => 'portfolio',
		'post_status' => 'publish',
		'post_password' => '',
		'posts_per_page' => -1,	//max(3, get_theme_option('portfolio_ppp')),
		'orderby' => 'date',
		'order' => 'desc'
	);
	$query = new WP_Query($args); 
	$post_number = 0;
	$items_output = '';
	$cats_list = array();
	$ppp = max(3, get_theme_option('portfolio_ppp', 1));
	if ($query->have_posts()) {
?>
			<section id="portfolio" class="section portfolio_section odd">
				<div class="section_header portfolio_section_header">
					<h2 class="section_title portfolio_section_title"><a href="#"><span class="icon icon-briefcase"></span><span class="section_name"><?php echo $portfolio_title; ?></span></a><span class="section_icon"></span></h2>
				</div>
				<div class="section_body portfolio_section_body">
				<?php
				while ($query->have_posts()) {
					$query->the_post();
					$post_number++;
					$post_id = get_the_ID();
					$post_link = get_permalink($post_id);
					$post_date = get_the_date();
					$post_title = getPostTitle($post_id, 50, '...');
					$post_text = getPostDescription();
					$post_thumb = getResizedImageTag($post_id, 252*$mult, 174*$mult); //get_ the_post_thumbnail($post_id, 'portfolio');
					$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
					$post_cats_list = getCategoriesByPostId($post_id, array('category_portfolio'));
					$post_cats = '';
					$post_classes = '';
					$post_content = '';
					if(get_theme_option('portfolio_excerpt')) {
						$post_content = getShortString(get_the_excerpt(), 100, '');
					}
                    $post_custom = get_post_custom($post_id);
                    $item_url = isset($post_custom["link_url"][0]) ? $post_custom["link_url"][0] : '';
					$rel = ' rel="prettyPhoto"';
					if($item_url != '') {
						$post_attachment = $item_url;
						if(my_strpos($item_url, 'youtube.com') === false && my_strpos($item_url, 'vimeo.com') === false) {
							$rel = '';
						}
					}
					foreach ($post_cats_list as $cat) {
						$post_cats .= ($post_cats ? ', ' : '') . $cat['name'];
						$post_classes .= ($post_classes ? ' ' : '') . 'category_'.$cat['term_id'];
						$cats_list[$cat['term_id']] = $cat['name'];
					}
					$items_output .= '
						<article class="post portfolio_post portfolio_post_' . $post_number . ($post_number==1 ? ' first' : '') . ($post_number%2==1 ? ' even' : ' odd') . ' ' .$post_classes . '" style="z-index: ' . (999-$post_number) . '">
							<div class="post_pic portfolio_post_pic">
								<a href="' . $post_attachment . '" class="w_hover img-link img-wrap"'.$rel.'>
									<span class="overlay"></span>
									<span class="link-icon"></span>
									' . $post_thumb . '
								</a>
							</div>
							<h4 class="post_title"><a href="' . $post_link . '">' . $post_title . '</a></h4>
							<h5 class="post_subtitle">' . $post_cats . '</h5>';
					if($post_content) {							
					$items_output .='		
						<div class="post_content"><a href="'.$post_link.'">'.$post_content.'<span class="arr">&rarr;</span></a></div>';
					}								
					$items_output .='		
						</article>
						';
				} // while (have_posts)
	
				if ($items_output) {
				?>
                	<div class="portfolio_wrapper">
                        	<?php
							$iso_selector = '';
							if (count($cats_list) > 0) {
								foreach ($cats_list as $slug=>$name) {
									$iso_selector .= '<li><a href="#" data-filter=".category_' . $slug . '">' . $name . '</a></li>';
								}
							}
							wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), '1.5.25', true );
							?>
							<ul id="portfolio_iso_filters">
								<li><a href="#" data-filter="*" class="current">All</a></li>
								<?php echo $iso_selector; ?>
							</ul>
							<script>
								var ppp = <?php echo $ppp; ?>;
							</script>
	                	<div class="portfolio_items">
                        	<?php echo $items_output; ?>
                        </div>
						<div class="portfolio_iso_pages">
							<ul id="portfolio_iso_pages">
							</ul>
							<div id="portfolio_iso_pages_2">
								Page <span id="portfolio_iso_pages_current">1</span> of <span id="portfolio_iso_pages_total"></span>
							</div>
						</div>
                    </div>
<?php
				} // if (items_output)
?>
				</div> <!-- .section_body -->
			</section> <!-- #portfolio -->
<?php
	} // if (have_posts)
?>




			<section id="contact" class="section contact_section even">
				<div class="section_header contact_section_header">
					<h2 class="section_title contact_section_title"><a href="#"><span class="icon icon-envelope-alt"></span><span class="section_name"><?php echo $contacts_title; ?></span></a><span class="section_icon"></span></h2>
				</div>
				<div class="section_body contact_section_body">
					<?php if (get_theme_option('google_map')==1 && trim($user_address)!='') { ?>
                    <div id="googlemap_data">
                    	<?php echo do_shortcode('[googlemap address="' . $user_address . '" height="294"]'); ?>
                    	<div class="add_info">
	                        <div class="profile_row header first">
	                            <?php _e('Contact info', 'wpspace'); ?>
	                        </div>
	                        <div class="profile_row address">
	                            <span class="th"><?php _e('Address', 'wpspace'); ?></span><span class="td"><?php echo $user_address; ?></span>
	                        </div>
	                        <div class="profile_row phone">
	                            <span class="th"><?php _e('Phone', 'wpspace'); ?></span><span class="td"><?php echo $user_phone; ?></span>
	                        </div>
	                        <div class="profile_row email">
	                            <span class="th"><?php _e('Email', 'wpspace'); ?></span><span class="td"><?php echo $user_email; ?></span>
	                        </div>
	                        <div class="profile_row website">
	                            <span class="th"><?php _e('Website', 'wpspace'); ?></span><span class="td"><?php echo $user_website; ?></span>
	                        </div>
                        </div>
                    </div>
					<?php } ?>
					<?php if (get_theme_option('contact_form')==1) { ?>
                	<div class="sidebar contact_sidebar">
						<?php do_action( 'before_sidebar' ); ?>
                        <?php if ( ! dynamic_sidebar( 'sidebar-contact' ) ) { ?>
                        <?php } ?>
                    </div>
					<div class="contact_form">
                    	<div class="contact_form_data">
							<?php echo do_shortcode('[contact_form title="'.__('Let\'s keep in touch', 'wpspace').'"]'); ?>
                        </div>
                    </div>
					<?php } ?>
				</div> <!-- .section_body -->
			</section> <!-- #contact -->


</div> <!-- #mainpage_accordion_area -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php 
	wp_reset_postdata();
	get_footer(); 
?>