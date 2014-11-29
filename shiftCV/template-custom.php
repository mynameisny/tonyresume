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
 * @package cv_theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if (($favicon = get_theme_option('favicon'))) { ?>
            <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $favicon; ?>" />
        <?php
        }
        ?>
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <?php
        // Theme customizer settings
        $theme_custom_settings = array(
            'theme_style' => getValueGPC('theme_style', get_theme_option('theme_style'))
        );
        $theme_custom_settings['theme_style'] = !isset($_GET['prn']) && my_strtolower($theme_custom_settings['theme_style']) == 'dark' ? 'dark' : 'light';
        
        // AJAX Queries setiings
        global $ajax_nonce, $ajax_url;
        $ajax_nonce = wp_create_nonce('ajax_nonce');
        $ajax_url = admin_url('admin-ajax.php');
        ?>
        
        <?php echo get_theme_option('tracking_code'); ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/template/custom.js"></script>
        <style type="text/css">
            /* RESET */
            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, font, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td, figure {
                margin: 0;
                padding: 0;
            }
            article,aside,details,figcaption,figure,
            footer,header,hgroup,menu,nav,section { 
                display:block;
            }
            ul {
                list-style: none;
            }
            table {
                border-collapse: separate;
                border-spacing: 0;
            }   
            img{
                border: none;
            }
            /* DEMO HEADER */
            body{
                overflow-x: hidden;
                overflow-y: scroll;
                font-family: 13px/20px "Droid Sans",Arial,"Helvetica Neue","Lucida Grande",sans-serif;
                color: #444;
                border-top: 3px solid #444;
                background:url(<?php echo get_template_directory_uri(); ?>/images/vcard/texture.jpg) repeat;
                overflow-x:hidden;
                text-shadow: 0 0 1px #909090;
            }
            body p
            {
                font-family: "Microsoft YaHei",微软雅黑;
                text-shadow: 0 0 1px #909090;
            }
            h1.title_name {
                color: #685440;
                font-family: "Trebuchet MS","Myriad Pro",Arial,sans-serif;
                font-size: 3em;
                font-weight: normal;
                line-height: 1em;
                margin: 0;
                padding: 10px 0 0;
                text-align: center;
                background-color:#404853;
            }
            h1.title_name span {
                color: rgba(255, 255, 255, 0.9);
                font-family: normal Georgia,'Times New Roman',Times,serif;
                font-size: 0.9em;
            }
            h1.title_name small {
                color: #8EC63F;
                display: block;
                font-family: normal Verdana,Arial,Helvetica,sans-serif;
                font-size: 0.2em;
                letter-spacing: 0.5em;
                text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
                text-transform: uppercase;
            }
            a{
                color:#FFFFFF;
                text-decoration:none;
            }
            a:hover{
                color:#8EC63F;
                text-decoration:none;
                -webkit-transition: color .25s ease-out;
                -moz-transition: color .25s ease-out;
                -o-transition: color .25s ease-out;
                transition: color .25s ease-out;
            }
            /* DEMO BODY */
            footer {
                width:100%;
                margin: 0 auto;
                padding:20px;
                text-align: center;
                clear: both;
                position:absolute;
                bottom:0;
                /*background:#404853;*/
                background: #282828;
                overflow:hidden;
            }
            footer p { 
                letter-spacing: 1px; 
                color:#8C9198;
                font-size:1em;
                text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            }

            .black_overlay{ 
                display: none; 
                position: absolute; 
                top: 0%; 
                left: 0%; 
                width: 100%; 
                height: 100%; 
                background-color: black; 
                z-index:1001; 
                -moz-opacity: 0.8; 
                opacity:.80; 
                filter: alpha(opacity=88); 
            } 
            .white_content { 
                display: none; 
                /*position: absolute;
                top: 25%; 
                left: 25%; 
                width: 55%; 
                height: 55%; 
                padding: 20px; */
                position: absolute;
                top: 50%; 
                left: 50%; 
                width: 303px;
                height: 303px;
                margin-left:-150px;
                margin-top:-150px; 
                /*border: 10px solid orange; */
                background-color: white; 
                z-index:1002; 
                overflow: auto; 
            }

            /* DEMO STAR */
            body
            {
                background:url(<?php echo get_template_directory_uri(); ?>/images/vcard/texture.jpg) repeat;
                font-size:12px;text-shadow:1px 1px 0 #fff;
            }
            p
            {
                padding:0 0 10px;
            }
            h2
            {
                padding:6px 0 10px 0;font:bold 16px/22px "Myriad Pro",Myriad,Helvetica,Arial,sans-serif;color:#333;
            }
            .left
            {
                float:left;margin:5px 16px 5px 0;box-shadow:1px 1px 3px #C1C1C1;
            }
            .right
            {
                float:right;margin:5px 0 5px 16px;
            }
            #container
            {
                overflow:hidden;
                position:relative;
                width:1000px;
                margin:0 auto;
                padding-bottom:135px;
            }
            #contentWrapper
            {position:relative;overflow:hidden;width:558px;height:278px;margin:140px auto 0;padding:6px;background-color:#fff;border:1px solid #EEEEEE;box-shadow:1px 1px 2px #C1C1C1;}
            #content{position:relative;overflow:hidden;width:558px;height:278px;background: -moz-linear-gradient(top, #ffffff, #efefef);/* Firefox */background: -webkit-linear-gradient(top, #ffffff, #efefef);}
            #scrollWrapper{position:relative;width:9999px;}
            .section{position:relative;float:left;margin-right:50px;width:538px;height:253px;padding:0 10px 25px;}
            #navMain{position:absolute;bottom:0;left:203px;overflow:hidden;z-index:100;clear:both;width:165px;height:20px;padding:10px 0 4px 10px;text-align:center;border-left:1px solid #EEE;border-right:1px solid #EEE;background: -moz-linear-gradient(top, #ffffff, #efefef);/* Firefox */background: -webkit-linear-gradient(top, #ffffff, #efefef);/* Firefox */}
            #navMain li{display:block;float:left;}
            #navMain li a{display:block;float:left;}
            #navMain li img{padding:0 7px;}
            #navMain li a{filter:alpha(opacity=50);-moz-opacity:.50;opacity:.50;}
            #navMain li a.selected,#navMain li a:hover,#navMain li a:focus{filter:alpha(opacity=100);-moz-opacity:1;opacity:1;}
            #home{padding:65px 10px 25px;height:188px;}
            .section p{line-height:2;}.section p a{color:#000000;}
            .section p a:hover{color:#8EC63F;}
            #home h1{position:relative;margin:0;padding: 0px 0 0;font:normal 36px/52px "Myriad Pro",Myriad,Helvetica,Arial,sans-serif;color:#333;text-align:center;}
            #home h2{
                font:normal 16px/18px Helvetica,Arial,sans-serif;
                color:#666666;
                font-family: "Microsoft YaHei",微软雅黑;
                text-shadow: 0 0 1px #909090;
                text-align:center;
            }
            a.vcard{display:block;width:34px;height:34px;position:absolute;top:0;right:110px;}
            a.vcard img{width:34px;height:34px;font-size:12px;line-height:16px;filter:alpha(opacity=50);-moz-opacity:.50;opacity:.50;}
            a.vcard:hover img,a.vcard:focus img{filter:alpha(opacity=100);-moz-opacity:1;opacity:1;}
            #networks ul{overflow:hidden;padding:2px 0 0;}
            #networks li{overflow:hidden;display:block;float:left;width:252px;height:46px;margin:0 14px 0 0;}
            #networks li a{overflow:hidden;display:block;float:left;width:252px;height:36px;padding:0 0 10px;color:#666;}
            #networks img{float:left;margin:0 16px 0 0;}
            #networks strong{display:block;font:bold 14px/20px "Myriad Pro",Myriad,Helvetica,Arial,sans-serif;color:#333;}
            #networks li a:hover,#networks li a:focus{padding-left:2px;width:250px;text-decoration:none;color:#333;}
            #addressDetails{float:left;width:240px;margin:0 20px 0 0;padding:0 0 0 1px;border-right:1px dotted #ccc;}
            #addressDetails h3{padding:6px 0 0 0;font:bold 14px/22px;color:#333;}
            #addressDetails h3 a {color:#333;}
            #contact{background:url(<?php echo get_template_directory_uri(); ?>/images/vcard/feature-cloud.png) no-repeat right bottom;}
        </style>

    </head>

    <body <?php body_class($theme_custom_settings['theme_style']); ?>>
        <!--[if lt IE 8]>
        <?php echo do_shortcode("[infobox style='error']It looks like you're using an old version of Internet Explorer. For the best WordPress experience, please <a href=\"http://microsoft.com\">update your browser</a> or learn how to <a href=\"http://browsehappy.com\">browse happy</a>![/infobox]"); ?>
        <![endif]-->
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
            $weixin_image = get_template_directory_uri() . "/images/vcard/weixin_qrcode_normal.jpg";
            $twitter = get_theme_option("social_links_twitter");
            $facebook = get_theme_option("social_links_facebook");
            $rss = get_theme_option("social_links_rss");
            $tencent_weibo = get_theme_option("social_links_tencentweibo");
            $sina_weibo = get_theme_option("social_links_sinaweibo");
            $tencent_weixin = get_theme_option("social_links_tencentweixin");
            $tencent_qzone = get_theme_option("social_links_tencentqzone");
            $tencent_pengyou = get_theme_option("social_links_tencentpengyou");
            $github = get_theme_option("social_links_github");
        ?>
        <div id="container">
            <div id="contentWrapper">
               <ul id="navMain">
                    <li><a class="selected" href="#home" title="我的微信"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/home.png" alt="Home" height="20" width="25" style="margin-top:1px;" /></a></li>
                    <li><a class="" href="#about" title="关于我"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/about.png" alt="About" height="20" width="25" /></a></li>
                    <li><a class="" href="#networks" title="关注我"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/network.png" alt="Networks" height="20" width="25" /></a></li>
                    <li><a class="" href="#contact" title="联络我"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/contact.png" alt="Contact" height="20" width="25" /></a></li>
                </ul> <!--! end of #Navi -->  
    
                <div id="content">
                  <div id="scrollWrapper">
                    <ul>
                      <li id="home" class="section">
                        <h1>
                            <img src="<?php echo $weixin_image; ?>" style="width:120px;height:120px;" alt="点我，点我！" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" />
                        </h1>
                        <h2>扫描我的微信二维码或者直接搜索账号“蜡笔小强”</h2>
                      </li> <!--! end of #home -->  
                      <li id="about" class="section">
                        <h2>About Me</h2>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/vcard/author.png" alt="Airos Chou" class="left" height="120" width="120">
                        <p>My name is Tony Joseph.<br>85后闷骚程序员，不拖延会死星人。为人正直、不靠谱，我用20几年的时间试图成为我想成为的人，结果我失败了，因为我真心不知道我想成为什么样的人……长我一岁的哥哥姐姐们总是很令我羡慕：或者很成功或者很有想法，因此我一直觉得年龄是决定一个人成熟与否的最关键因素，直到后来我身边那些不靠谱的同龄的玩伴们都默默的成为了家庭里的顶梁柱之后，我才恍然大悟：成长不似刷经验，可靠与年龄无关，与内心相联。</p>
                        <p>低调中还带着点自矜，自以为绝非池中物，就等着文成武德、泽被苍生……惭愧……好歹我已经开始改了！</p>
                      </li> <!--! end of #About Me -->  
                      <li id="networks" class="section">
                        <h2>Follow Me</h2>
                        <ul>
                            <li>
                                <a href="http://3333024.qzone.qq.com" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/qq.png" alt="QQ" height="32" width="32"> <strong>QQ</strong>3333024</a>
                            </li>
                            <li>
                                <a href="<?php echo $rss; ?>" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/rss.png" alt="RSS" height="32" width="32"> <strong>RSS</strong><span><?php if (mb_strlen($rss, 'UTF-8') > 28){echo mb_substr($rss, 0, 28, 'utf-8')."...";}else{echo $rss;} ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $github; ?>" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/github.png" alt="GitHub" height="32" width="32"> <strong>GitHub</strong><?php if (mb_strlen($github, 'UTF-8') > 28){echo mb_substr($github, 0, 28, 'utf-8')."...";}else{echo $github;} ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $facebook; ?>" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/facebook.png" alt="Facebook" height="32" width="32"> <strong>Facebook</strong><?php if (mb_strlen($facebook, 'UTF-8') > 28){echo mb_substr($facebook, 0, 28, 'utf-8')."...";}else{echo $facebook;} ?></a>
                            </li>
                            <li>
                                <a href="http://www.linkedin.com/pub/%E5%B0%BC-%E6%89%98/92/b50/552" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/linkedin.png" alt="LinkedIn" height="32" width="32"> <strong>LinkedIn</strong>http://www.linkedin.com/pub/..</a>
                            </li>
                            <li>
                                <a href="http://www.baidu.com/p/mynameisny" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/baidu.png" alt="Baidu" height="32" width="32"> <strong>Baidu</strong>http://www.baidu.com/p/mynameisny</a>
                            </li>
                            <li>
                                <a href="https://secure.skype.com/portal/overview?skypename=live%3Amynameisny_1" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/skype.png" alt="Skype" height="32" width="32"> <strong>Skype</strong>mynameisny@qq.com</a>
                            </li>
                            <li>
                                <a href="<?php echo $twitter; ?>" class="external"><img src="<?php echo get_template_directory_uri(); ?>/images/vcard/twitter.png" alt="Twitter" height="32" width="32"> <strong>Twitter</strong><?php if (mb_strlen($twitter, 'UTF-8') > 28){echo mb_substr($twitter, 0, 28, 'utf-8')."...";}else{echo $twitter;} ?></a>
                            </li>
                        </ul>
                        <p> You can also find me on <a href="http://code.google.com/u/116603173758864997653/" class="external">Google Code</a> and more.</p>
                      </li> <!--! end of #Follow Me -->  
                      <li id="contact" class="section vcard">
                        <h2>Contact Me</h2>
                        <div id="addressDetails">
                          <h3 class="fn"><a href="http://<?php echo $user_website; ?>" class="url"><span class="given-name"><?php echo $user_firstname; ?></span> <span class="family-name"><?php echo $user_lastname; ?></span></a></h3>
                          <p class="adr"><span class="locality"><?php echo $user_company; ?></span> <span class="region"><?php echo $user_position; ?></span><br>
                          <span class="country-name">China</span></p>
                          <p>
                            <strong>Email:</strong> <a href="mailto:<?php echo $user_email; ?>" class="email"><?php echo $user_email; ?></a>
                          </p>
                        </div>
                      </li> <!--! end of #Contact Me -->  
                    </ul>
                  </div>
                </div>  <!--! end of #content -->  
            </div>      
        </div> <!--! end of #container -->

        <!-- 弹出层 -->
        <div id="light" class="white_content">
            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">
                <img src="<?php echo $weixin_image; ?>" style="width:300px; height:300px;margin-left:2px;" />
            </a>
        </div>

        <!-- 遮罩层 -->
        <div id="fade" class="black_overlay"></div> 

        <footer>
            <p>
                <strong>Welcome! </strong> Check out <a target="_self" href="<?php echo $user_website; ?>"><?php echo $user_website; ?></a>, for more information about me! <span class="follow">And you may also <a target="_blank" href="<?php echo $tencent_weibo; ?>">@me</a> on Tencent Microblog.</span>
            </p>
        </footer>

    </body>
</html>

<?php 
    wp_reset_postdata();
?>