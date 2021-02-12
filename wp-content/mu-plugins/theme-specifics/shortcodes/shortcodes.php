<?php
function our_staff_shortcode() {
	$emailIcon = get_field('email_icon', 'cpt_sitew');
	$phoneIcon = get_field('phone_icon', 'cpt_sitew');

	if( have_rows('departments')){
		echo '
		<section class="our-team ourstaff main-content">
			<div class="columns is-multiline">
		';
		while ( have_rows('departments') ) : the_row();
			$departmentName = get_sub_field('department_name');

			echo '<div class="column is-12"><h3>'.$departmentName.'</h3></div>';

			$post_objects = get_sub_field('profiles');
			if( $post_objects ){
				foreach( $post_objects as $post_object):
					setup_postdata($post);
					echo '<div class="column is-3 team-member">';
					//
					$showPhoto 				= get_field('photo', $post_object->ID);
					$teamMemberPhoto 	= get_field('staff_image', $post_object->ID);
					$teamMemberName 	= get_field('staff_name', $post_object->ID);
					$teamMemberTitle 	= get_field('staff_title', $post_object->ID);
					$teamMemberEmail 	= get_field('staff_email', $post_object->ID);
					$staffPhone 			= get_field('staff_phone', $post_object->ID);
					$teamPhoneExt 		= get_field('staff_phone_extension', $post_object->ID);
					$moreBefore				= get_field('more_link_before', 'cpt_sitew');
					$bioContent 			= get_post_field('post_content', $post_object->ID);


					if($bioContent != ''){
						$rowCount = 0;
						$rowCount++;

						$teamMemberName2 	= str_replace(' ', '', $teamMemberName);
						$cleanedName = preg_replace('/[^A-Za-z0-9\-]/', '', $teamMemberName2);

						if($rowCount == '1'){
							if($showPhoto != 'no'){
								//bio
								echo '<a data-fancybox="" data-animation-duration="500" data-src="#bio-'.$cleanedName.'" href="javascript:;">';
								if($teamMemberPhoto){
									echo '
										<img class="placehold-img" src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberName.'">
									';
								} else {
									echo '
										<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
									';
								}
							}
							if($teamMemberName){
								echo '
									<div class="name">'.$teamMemberName.'</div>
								';
							}
							if($teamMemberTitle){
								echo '
									<div class="title">'.$teamMemberTitle.'</div>
								';
							}

							if($teamMemberEmail){
								echo '
									<div class="email">'.$emailIcon.$teamMemberEmail.'</div>
								';
							}

							if($staffPhone == 'york'){
								$phone 				= get_field('york_phone', 'cpt_sitew');
								$phoneNo			= $phoneIcon.$phone;
							}

							if($staffPhone == 'hanover'){
								$phone 				= get_field('hanover_phone', 'cpt_sitew');
								$phoneNo			= $phoneIcon.$phone;
							}

							if($staffPhone == 'none'){
								$phone 				= '';
								$phoneNo			= $phone;
							}

							if($teamPhoneExt != ''){
								$extension = ' ext/'.$teamPhoneExt;
							} else {
								$extension = '';
							}
							echo '
								<div class="phone">'.$phoneNo.$extension.'</div>
							';

							if($showPhoto != 'no'){
								echo '
									</a>
									<div style="display: none;" id="bio-'.$cleanedName.'" class="animated-modal text-center p-5 fancybox-content main-content">
									';
									if($teamMemberPhoto != ''){
										echo '<div class="profile-photo"><img src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberPhoto['alt'].'"></div>';
									} else {
										echo '<div class="profile-photo"><img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Profile Image Unavailable"></div>';
									}


								echo '<div class="name">'.$teamMemberName.'</div>';
								echo '<div class="title">'.$teamMemberTitle.'</div>';
								if($teamMemberEmail){
									echo '
										<div class="email"><a href="mailto:'.$teamMemberEmail.'">'.$emailIcon.$teamMemberEmail.'</a></div>
									';
								}
								echo '<div class="phone">'.$phoneNo.$extension.'</div>';
								// if($teamMemberEmail){
								// 	echo '
								// 		<div class="email"><a href="mailto:'.teamMemberEmail.'">'.$emailIcon.$teamMemberEmail.'</a></div>
								// 	';
								// }
								//
								// echo '
								// 	<div class="phone">'.$phoneIcon.$phone.$ext.'</div>
								// ';
								echo '<hr class="large-border">';

								echo '
								<div class="question">
									<p>'.$bioContent.'</p>
								</div>
								';
								echo '</div>';
							}
						}
					} else {
						if($showPhoto != 'no'){
							if($teamMemberPhoto){
								echo '<img src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberPhoto['alt'].'">
								';
							} else {
								echo '
									<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
								';
							}
						}
						if($teamMemberName){
							echo '<div class="name">'.$teamMemberName.'</div>';
						}
						if($teamMemberTitle){
							echo '<div class="title">'.$teamMemberTitle.'</div>';
						}
					}
					//
					echo '</div>';
				endforeach;
			}
			//
			//
			//

			// echo '</div>';
			echo '<hr class="dotted">';
		endwhile;
		echo '
			</div>
		</section>
		';
	}
}
add_shortcode( 'ourstaff', 'our_staff_shortcode' );



function ourteam_shortcode() {
	if( have_rows('people')){
		echo '
		<section class="our-team ourstaff main-content">
			<div class="columns is-multiline">
		';
		while ( have_rows('people') ) : the_row();

					setup_postdata($post);
					echo '<div class="column is-3 team-member">';
					//
					$showPhoto 				= get_sub_field('bio_photo');
					$teamMemberPhoto 	= get_sub_field('bio_photo');
					$teamMemberName 	= get_sub_field('bio_name');
					$teamMemberTitle 	= get_sub_field('bio_title');
					$moreBefore				= get_field('more_link_before', 'cpt_sitew');
					$bioContent 			= get_sub_field('bio_content');

					if($bioContent != ''){
						$rowCount = 0;
						$rowCount++;

						$teamMemberName2 	= str_replace(' ', '', $teamMemberName);
						$cleanedName = preg_replace('/[^A-Za-z0-9\-]/', '', $teamMemberName2);

						if($rowCount == '1'){
							if($showPhoto != 'no'){
								//bio
								echo '<a data-fancybox="" data-animation-duration="500" data-src="#bio-'.$cleanedName.'" href="javascript:;">';
								if($teamMemberPhoto){
									echo '
										<img class="placehold-img" src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberName.'">
									';
								} else {
									echo '
										<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
									';
								}
							}
							if($teamMemberName){
								echo '
									<div class="name">'.$teamMemberName.'</div>
								';
							}
							if($teamMemberTitle){
								echo '
									<div class="title">'.$teamMemberTitle.'</div>
								';
							}

							if($showPhoto != 'no'){
								echo '
									</a>
									<div style="display: none;" id="bio-'.$cleanedName.'" class="animated-modal text-center p-5 fancybox-content main-content">
									';
									if($teamMemberPhoto != ''){
										echo '<div class="profile-photo"><img src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberPhoto['alt'].'"></div>';
									} else {
										echo '<div class="profile-photo"><img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Profile Image Unavailable"></div>';
									}


								echo '
									<div class="name">'.$teamMemberName.'</div>
									<div class="title">'.$teamMemberTitle.'</div>
									<hr class="large-border">
								';

								echo '
								<div class="question">
									<p>'.$bioContent.'</p>
								</div>
								';
								echo '</div>';
							}
						}
					} else {
						if($showPhoto != 'no'){
							if($teamMemberPhoto){
								echo '<img src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberPhoto['alt'].'">
								';
							} else {
								echo '
									<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
								';
							}
						}
						if($teamMemberName){
							echo '<div class="name">'.$teamMemberName.'</div>';
						}
						if($teamMemberTitle){
							echo '<div class="title">'.$teamMemberTitle.'</div>';
						}
					}
					//
					echo '</div>';
			//
			//
			//

			// echo '</div>';
		endwhile;
		echo '
			</div>
		</section>
		';
	}
}
add_shortcode( 'ourteam', 'ourteam_shortcode' );


function blogPosts_shortcode(){
	$paged = (get_query_var("paged")) ? get_query_var("paged") : 1;
	query_posts($query_string."cat=news&posts_per_page=10&paged=".$paged);
	$count = $wp_query->found_posts;

	$published_posts = wp_count_posts()->publish;
	$posts_per_page = get_option('posts_per_page');
	$page_number_max = ceil($published_posts / $posts_per_page);
	$blogPlaceholder = get_field('blog_small_placeholder','cpt_sitew');
	if (have_posts()){

		echo '
		<section class="double-block">
		  <div class="columns is-multiline">';
		    while ( have_posts() ) : the_post();

				$pdate = get_the_date();
				$title = get_the_title();
				$permalink = get_the_permalink();
				$excerpt = get_the_excerpt();
				$author = get_the_author();
				$authorurl = get_the_author_link();
				$cover_image = get_field('cropped_cover_image');
				//$cover_imageALT = get_field('cropped_cover_image');

		      echo '<div class="column is-4 is-full-mobile"><a href="'.$permalink.'">';
					if ($cover_image != '') {
	          echo '<img src="'.$cover_image.'" alt="'.$title.'">';
	        } else {
	          echo '<img src="'.$blogPlaceholder.'" alt="'.$title.'">';
	        }
		      echo '</a></div>';

		      echo '
		      <div class="column is-8 is-full-mobile">
		        <div class="content no-spacing">
		          <h3><a href="'.$permalink.'">'.$title.'</a></h3>';

							echo '
							<section class="post-information">
							  <div class="cont">
							    <time class="updated">'.$pdate.'</time>
							  </div>
							  <div class="cont">
							    <p class="byline author vcard">
							      By  '.$author.'
							    </p>
							  </div>
							</section>';

							echo '
		          <p>'.$excerpt.'</p>
							<div class="single-links">
		            <div>
		              <a class="more-link before-icon" href="'.$permalink.'" title="'.$title.'">Continue Reading<icon class="icon-arr-r"></icon></a>
		            </div>
		          </div>
		        </div>
		      </div>
					<hr class="thin-grey">';
		    endwhile;
		echo '
		  </div>
		</section>
		<hr class="cb">
		<div class="columns">
			<div class="column is-12">
				'.enollo_pagination().'
			</div>
		</div>';
	}

	wp_reset_query();
}
add_shortcode( 'blogposts', 'blogposts_shortcode' );



function newsfeed_shortcode(){
	$post_id = get_the_ID();

	query_posts(array(
		'category_name' 	=> 'news',
		'showposts' 			=> 4,
		'post_status' 		=> 'publish',
		'post__not_in' 		=> array($post_id),
		'orderby'         => 'date',
		'order'           => 'DESC',
	));

	while ( have_posts() ) : the_post();
		$title 				= get_the_title();
		$permalink 		= get_the_permalink();
		$date 				= get_the_date();
		$cover_image 	= get_field('cropped_cover_image');

		echo '<div class="column is-3-desktop is-6-tablet is-12-mobile"><a href="'.$permalink.'" title="'.$title.'"><div class="img">';
		if ($cover_image != '') {
      echo '<img src="'.$cover_image.'" alt="'.$title.'">';
    } else {
      echo '<img src="'.$blogPlaceholder.'" alt="'.$title.'">';
    }
    echo '</div>';
		echo '<div class="article-title">'.$title.'</div>';
		echo '<div class="article-date">'.$date.'</div>';
    echo '</a></div>';

	endwhile;
	//}
	wp_reset_query();
}
add_shortcode( 'newsfeed', 'newsfeed_shortcode' );


function recentdonorstories_shortcode(){
	//get current post id
	$post_id = get_the_ID();
	//
	query_posts(array(
		'post_type' 	=> 'donor-stories',
		'showposts' 	=> 3,
		'post_status' => 'publish',
		'post__not_in' => array($post_id)
  ));

  while ( have_posts() ) : the_post();
		$title 					= get_the_title();
		$permalink 			= get_the_permalink();
		$donorNames 		= get_field('donor_names');
		$donorSubtitle 	= get_field('donor_subtitle');
		$donorImage 		= get_field('donor_image');

		echo '
		<div class="column is-4 is-story">
      <div class="columns">
        <div class="column is-5">
					<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
          	<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
					</a>
        </div>
        <div class="column is-7">
          <a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
            <div class="article-title">
            	'.$donorNames.':
            </div>
            <div class="article-subtitle">
              '.$donorSubtitle.'
            </div>
          </a>
        </div>
      </div>
    </div>
		';
	endwhile;

	wp_reset_query();
}
add_shortcode( 'recentdonorstories', 'recentdonorstories_shortcode' );



function donorsmallblock_shortcode(){
	//start count
	$queryCount = 0;
	//
	query_posts(array(
		'post_type' 	=> 'donor-stories',
		'showposts' 	=> 3,
		'post_status' => 'publish',
  ));

  while ( have_posts() ) : the_post();
		$queryCount++;
		$title 					= get_the_title();
		$permalink 			= get_the_permalink();
		$donorNames 		= get_field('donor_names');
		$donorSubtitle 	= get_field('donor_subtitle');
		$donorImage 		= get_field('donor_image');
		$donorExcerpt		= get_field('donor_excerpt_content');

		if($queryCount == '1'){
			echo '
			<div class="columns is-multiline">
				<div class="column is-7 is-12-phone no-padding-left">
					<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
						<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
					</a>
				</div>
				<div class="column is-5 is-12-phone is-paddingless">
					<div class="article-title">
						'.$donorNames.'
					</div>
					<p>'.$donorExcerpt.'</p>
					<a class="more" href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">Meet '.$donorNames.'<icon class="icon-arr-r"></icon></a>
				</div>
			</div>
			';
		}

		if($queryCount == '2'){
			echo '
			<div class="columns dual-stories">
				<div class="column is-6 is-paddingless">
					<div class="columns is-multiline">
						<div class="column is-7 is-hidden-mobile no-padding-left">
							<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
								<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
							</a>
						</div>
						<div class="column is-5 is-hidden-mobile is-paddingless">
							<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
								<div class="article-title">
									'.$donorNames.':
								</div>
								<div class="article-subtitle">
									'.$donorSubtitle.'
								</div>
							</a>
						</div>
					</div>
				</div>
			';
		}

		if($queryCount == '3'){
			echo '
			<div class="column is-6 is-paddingless">
				<div class="columns is-multiline">
					<div class="column is-7 is-hidden-mobile">
						<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
							<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
						</a>
					</div>
					<div class="column is-5 is-hidden-mobile is-paddingless">
						<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
							<div class="article-title">
								'.$donorNames.':
							</div>
							<div class="article-subtitle">
								'.$donorSubtitle.'
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
			';
		}
	endwhile;
	wp_reset_query();
}
add_shortcode( 'donorsmallblock', 'donorsmallblock_shortcode' );



function donorspage_shortcode(){
	//start count
	$queryCount = 0;
	//
	query_posts(array(
		'post_type' 	=> 'donor-stories',
		'showposts' 	=> -1,
		'post_status' => 'publish',
  ));

  while ( have_posts() ) : the_post();
		$queryCount++;
		$title 					= get_the_title();
		$permalink 			= get_the_permalink();
		$donorNames 		= get_field('donor_names');
		$donorSubtitle 	= get_field('donor_subtitle');
		$donorImage 		= get_field('donor_image');
		$donorExcerpt		= get_field('donor_excerpt_content');

		if($queryCount == '1'){
			echo '
			<div class="columns">
				<div class="column is-5">
					<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
						<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
					</a>
				</div>
				<div class="column is-7">
					<h3><a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">'.$donorNames.' '.$donorSubtitle.'</a></h3>
					<p>'.$donorExcerpt.'</p>
					<div class="button-block">
						<a class="more Styled" href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">Meet '.$donorNames.'<icon class="icon-arr-r"></icon></a>
					</div>
				</div>
			</div>
			';
			echo '<div class="stories"><div class="columns is-multiline">';
		}


		if($queryCount != '1'){
			echo '
			<div class="column is-4 is-story">
				<a href="'.$permalink.'" title="'.$donorNames.' - '.$donorSubtitle.'">
					<div class="image">
							<img src="'.$donorImage['url'].'" alt="'.$donorNames.' - '.$donorSubtitle.'">
						</a>
					</div>
					<div class="article-title">
						'.$donorNames.':
					</div>
					<div class="article-subtitle">
						'.$donorSubtitle.'
					</div>
				</a>
			</div>
			';
		}
	endwhile;
	echo '</div></div>';
	wp_reset_query();
}
add_shortcode( 'donorspage', 'donorspage_shortcode' );






function bottombar_shortcode() {
	$post_objects = get_field('staff_members');
	if( $post_objects ){
		foreach( $post_objects as $post_object):
			setup_postdata($post);
			echo '<div class="column is-4"><div class="team-member">';

			//
			$teamMemberPhoto 	= get_field('staff_image', $post_object->ID);
			$teamMemberName 	= get_field('staff_name', $post_object->ID);
			$teamMemberTitle 	= get_field('staff_title', $post_object->ID);
			$moreBefore				= get_field('more_link_before', 'cpt_sitew');

			//bio
			if($teamMemberPhoto){
				echo '
				<div class="circled-img">
					<img class="placehold-img" src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberName.'">
				</div>
				';
			} else {
				echo '
				<div class="circled-img">
					<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
				</div>
				';
			}
			if($teamMemberName){
				echo '
					<div class="name">'.$teamMemberName.'</div>
				';
			}
			if($teamMemberTitle){
				echo '
					<div class="title">'.$teamMemberTitle.'</div>
				';
			}

			echo '<ul class="contact-info">';
			if(get_field('staff_phone', $post_object->ID) == 'york'){
				$phone_icon = get_field('phone_icon', 'cpt_sitew');
				$york = get_field('york_phone', 'cpt_sitew');

				echo '<li>'.$phone_icon.' '.$york .'</li>';
			} else {
				$phone_icon = get_field('phone_icon', 'cpt_sitew');
				$hanover = get_field('hanover_phone', 'cpt_sitew');

				echo '<li>'.$phone_icon.' '.$hanover .'</li>';
			}

			if(get_field('staff_email', $post_object->ID)){
				$mail_icon = get_field('email_icon', 'cpt_sitew');
				$email = get_field('staff_email', $post_object->ID);

				echo '<li><a href="mailto:'.$email.'">'.$mail_icon.' '.$email.'</a></li>';
			}
			echo '</ul>';
			//
			echo '</div></div>';
		endforeach;
	}
}
add_shortcode( 'bottombar', 'bottombar_shortcode' );

function assistancebarblock_shortcode() {
	$post_object = get_field('assistance_block');
	if( $post_object ){
		$post = $post_object;
		setup_postdata( $post );
			$sidebarText 	= get_field('sidebar_text', $post_object->ID);
			$sidebarIcon 	= get_field('sidebar_icon', $post_object->ID);
			$sidebar_link = get_field('sidebar_link', $post_object->ID);

			if($sidebar_link == 'yes'){
				$pageLink = get_field('page_link', $post_object->ID);
				echo '
					<div class="sidebutton is-hidden-touch">
						<a href="'.$pageLink.'" title="'.$sidebarText.'">'.$sidebarIcon.''.$sidebarText.'</a>
					</div>
				';
			} else {
				echo '
					<div class="sidebutton is-hidden-touch emb-btn">
						<a href="#learnmore" title="'.$sidebarText.'">'.$sidebarIcon.''.$sidebarText.'</a>
					</div>
				';
			}

		wp_reset_postdata();
	}
}
add_shortcode( 'assistancebarblock', 'assistancebarblock_shortcode' );

function assistancebar_shortcode() {
	$post_object = get_field('assistance_block');
	if( $post_object ){
		$post = $post_object;
		setup_postdata( $post );
			$blockTitle 	= get_field('bottom_block_title', $post_object->ID);
			$blockContent = get_field('bottom_block_content', $post_object->ID);
			$blockURL			= get_field('bottom_block_link', $post_object->ID);
			$moreAfter		= get_field('more_link_after', 'cpt_sitew');

			echo '
			<section class="impact" id="learnmore">
			  <div class="columns is-multiline">
			    <div class="column is-9">
			      <div class="impact-title">
						'.$blockTitle.'
						</div>
						'.$blockContent.'
					</div>
					<div class="column is-3">
			      <a class="Styled" href="'.$blockURL['url'].'" title="'.$blockURL['title'].'">'.$blockURL['title'].$moreAfter.'</a>
			    </div>
					';

					$post_objects = get_field('staff_members', $post_object->ID);
					if( $post_objects ){
						echo '
						<div class="column is-12 associated-users is-paddingless">
				      <div class="columns">';
						foreach( $post_objects as $post_object):
							setup_postdata($post);
							echo '<div class="column is-4"><div class="team-member">';

							//
							$teamMemberPhoto 	= get_field('staff_image', $post_object->ID);
							$teamMemberName 	= get_field('staff_name', $post_object->ID);
							$teamMemberTitle 	= get_field('staff_title', $post_object->ID);
							$moreBefore				= get_field('more_link_before', 'cpt_sitew');

							//bio
							if($teamMemberPhoto){
								echo '
								<div class="circled-img">
									<img class="placehold-img" src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberName.'">
								</div>
								';
							} else {
								echo '
								<div class="circled-img">
									<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
								</div>
								';
							}
							echo '<div class="block-cont">';
							if($teamMemberName){
								echo '
									<div class="name">'.$teamMemberName.'</div>
								';
							}
							if($teamMemberTitle){
								echo '
									<div class="title">'.$teamMemberTitle.'</div>
								';
							}

							echo '<ul class="contact-info">';
							if(get_field('staff_phone', $post_object->ID) == 'york'){
								$phone_icon = get_field('phone_icon', 'cpt_sitew');
								$york = get_field('york_phone', 'cpt_sitew');

								echo '<li>'.$phone_icon.' '.$york .'</li>';
							} else {
								$phone_icon = get_field('phone_icon', 'cpt_sitew');
								$hanover = get_field('hanover_phone', 'cpt_sitew');

								echo '<li>'.$phone_icon.' '.$hanover .'</li>';
							}

							if(get_field('staff_email', $post_object->ID)){
								$mail_icon = get_field('email_icon', 'cpt_sitew');
								$email = get_field('staff_email', $post_object->ID);

								echo '<li><a href="mailto:'.$email.'">'.$mail_icon.' '.$email.'</a></li>';
							}
							echo '</ul></div>';
							//
							echo '</div></div>';
						endforeach;
						echo '
							<div>
						</div>
						';
					}

			echo '
			      </div>
			    </div>
				</div>
			</section>
			';
		wp_reset_postdata();
	}
}
add_shortcode( 'assistancebar', 'assistancebar_shortcode' );



function relatedarticles_shortcode() {
	$selectStories = get_field('select_stories');
	if($selectStories){
		global $post;
		$post_slug	 	= $post->post_name;
		$post_title 	= get_the_title();
		$moreAfter		= get_field('more_link_after', 'cpt_sitew');
		echo '<section class="related-articles"><div class="recent-articles columns is-multiline"><div class="column is-9"><h3>More About '.$post_title.'</h3></div><div class="column is-3"><a class="more fr" href="/category/'.$post_slug.'">View Related Articles'.$moreAfter.'</a></div>';
			foreach( $selectStories as $post_object){
				//setup_postdata($post);
				$title 						= get_the_title($post_object->ID);
				$permalink 				= get_the_permalink($post_object->ID);
				$date 						= get_the_date($post_object->ID);
				$cover_image 			= get_field('cropped_cover_image', $post_object->ID);
				$blogPlaceholder 	= get_field('cropped_cover_image', 'options');
				$page_image				= get_field('page_image', $post_object->ID);
				$staff_image			= get_field('staff_footer_image', $post_object->ID);
				$staff_name				= get_field('staff_name', $post_object->ID);
				$staff_title			= get_field('staff_title', $post_object->ID);
				$externalLink			= get_field('external_link', $post_object->ID);
				$externalImg			= get_field('external_link_image', $post_object->ID);

				echo '<div class="column is-3">';
				if($externalLink != ''){
					echo '<a href="'.$externalLink['url'].'" title="'.$externalLink['title'].'" target="'.$externalLink['target'].'">';
				} else {
					echo '<a href="'.$permalink.'">';
				}
				if ($cover_image != '') {
					echo '<div class="img"><img src="'.$cover_image.'" alt="'.$title.'"></div>';
				} elseif($page_image) {
					echo '<div class="img"><img src="'.$page_image['url'].'" alt="'.$title.'"></div>';
				} elseif($staff_image) {
					echo '<div class="img"><img src="'.$staff_image['url'].'" alt="'.$title.'"></div>';
				}	elseif($externalImg) {
					echo '<div class="img"><img src="'.$externalImg['url'].'" alt="'.$externalLink['title'].'"></div>';
				} else {
					echo '<div class="img"><img src="'.$blogPlaceholder.'" alt="'.$title.'"></div>';
				}
				echo '<div class="article-title">';
				if($staff_name != ''){
					echo 'Meet ' . $staff_name .', '.$staff_title;
				} else {
					echo $title;
				}
				echo '</div>';
				//echo '<div class="article-date">'.$date.'</div>';
				echo '</a></div>';
			}
		echo '</div></section>';
	}
}
add_shortcode( 'relatedarticles', 'relatedarticles_shortcode' );



function contentjump_shortcode() {
	echo '
		<div class="screen-reader-text">
			<div class="skip-navigation">
				<a href="#jumptocontent" title="Jump to Main Content">Jump to Main Content</a>
			</div>
		</div>
	';
}
add_shortcode( 'contentjump', 'contentjump_shortcode' );



function initiatives_shortcode() {
	if( have_rows('our_initiatives') ):
		echo '<section class="related-articles"><div class="recent-articles columns is-multiline">';
		while ( have_rows('our_initiatives') ) : the_row();
			$initiativeTitle 		= get_sub_field('initiative_title');
			$initiativePhoto 		= get_sub_field('initiative_photo');
			$initiativeContent 	= get_sub_field('initiative_content');
			$initiativeLink 		= get_sub_field('initiative_link');

			echo '
			<div class="column is-12">
				<h3>'.$initiativeTitle.'</h3>';
				if($initiativePhoto != ''){
					echo '<img src="'.$initiativePhoto.'" class="alignright">';
				}
			echo '
				'.$initiativeContent.'
				<a class="link Styled" href="'.$initiativeLink['url'].'">'.$initiativeLink['title'].'</a>
			</div>
			';

		endwhile;
		echo '</div></section>';
	endif;
}
add_shortcode( 'initiatives', 'initiatives_shortcode' );



function resources_shortcode() {
	if( have_rows('applicant_resources') ){
			echo '
			<section class="fund-list main-content resource-content">
			  <div class="columns is-multiline">
			';
	    while ( have_rows('applicant_resources') ) : the_row();
	        if( have_rows('resource_section') ){
		        //sections
		        while ( have_rows('resource_section') ) : the_row();
		        	$sectionTitle = get_sub_field('resource_section_title');
		        	echo '<div class="column is-12"><div class="resource-section-title"><h4>'.$sectionTitle.'</h4></div></div>';
		        	if( have_rows('associated_resources') ){
								//section resources
								echo '
								<div class="column is-12">
						      <ul class="funds resource-list">';
								while ( have_rows('associated_resources') ) : the_row();
									$resourceTitle 			= get_sub_field('resource_title');
									$resourceContent 		= get_sub_field('resource_content');
									$videoCheck					= get_sub_field('is_this_a_video');
									$videoURL						= get_sub_field('video_url');
									$resourceImage			= get_sub_field('resource_image');
									$imageLink					= get_sub_field('image_link');
									$resourceLink				= get_sub_field('resource_link');
									$simpleResourceImg	= get_sub_field('simple_resource_image');
									$blogPlaceholder 		= get_field('blog_placeholder', 'cpt_sitew');

									if( get_sub_field('full_block') == 'yes' ){
										if($videoCheck == 'yes'){
											echo '
											<li class="full-block">';
												if($videoCheck == 'yes'){
													echo '<strong>'.$resourceTitle.'</strong>
													<hr class="cb">';
													//video
													$video = get_sub_field('video_url'); //Embed Code
								          $video_url = get_sub_field('video_url', FALSE, FALSE); //URL
								          $video_thumb_url = get_video_thumbnail_uri($video_url);
								          echo '<a data-fancybox="" href="'.$video_url.'">';
								          echo '<div class="video-block alignright">';
								          echo '<icon class="icon-play-btn"></icon>';
								          echo '<img class="video-link"  src="'.$video_thumb_url.'">';
								          echo '</div>';
								          echo '</a>';

													echo $resourceContent;

												} else {
													echo '
														<strong><div>'.$resourceTitle.'</div></strong>
														<hr class="cb">
														'.$resourceContent.'
													';
												}
											echo '
											</li>
											';
										} else {
											echo '
											<li class="small-block">
												<a href="'.$resourceLink['url'].'" title="'.$resourceTitle.'" target="_blank">';
												if($resourceImage != ''){
													echo '
													<div class="resource-image">
														<img src="'.$resourceImage['url'].'" alt="'.$resourceTitle.'" class="resource-image">
													</div>
													';
												} else {
													echo '
													<div class="resource-image">
														<img src="'.$blogPlaceholder.'" alt="'.$blogPlaceholder.'" class="resource-image">
													</div>
													';
												}

												echo '
													<hr class="cb">
													<div>'.$resourceTitle.'</div>
												</a>
											</li>
											';
										}
									} elseif( get_sub_field('full_block') == 'staff' ){
										//staff
										$post_object = get_sub_field('staff');
										if( $post_object ):
											$post = $post_object;
											setup_postdata( $post );
										    echo '
												<section class="our-team ourstaff main-content">
													<div class="columns is-multiline is-mobile">
												';
													$title = get_the_title($post);
													echo '<div class="column is-12-mobile is-3-tablet is-3-desktop is-3-widescreen team-member">';
													//
													$showPhoto 				= get_field('photo', $post);
													$teamMemberPhoto 	= get_field('staff_image', $post);
													$teamMemberName 	= get_field('staff_name', $post);
													$teamMemberTitle 	= get_field('staff_title', $post);
													$teamMemberEmail 	= get_field('staff_email', $post);
													$moreBefore				= get_field('more_link_before', 'cpt_sitew');
													$bioContent 			= get_post_field('post_content', $post);

														$rowCount = 0;
														$rowCount++;

														$teamMemberName2 	= str_replace(' ', '', $teamMemberName);
														$cleanedName = preg_replace('/[^A-Za-z0-9\-]/', '', $teamMemberName2);

														if($rowCount == '1'){
															if($showPhoto != 'no'){
																//bio
																if($teamMemberPhoto){
																	echo '
																		<img class="placehold-img" src="'.$teamMemberPhoto['url'].'" alt="'.$teamMemberName.'">
																	';
																} else {
																	echo '
																		<img src="'.get_template_directory_uri().'/assets/images/profile-unavailable.jpg" alt="Image Unavailable">
																	';
																}
															}
															if($teamMemberName){
																echo '
																	<div class="name">'.$teamMemberName.'</div>
																';
															}
															if($teamMemberTitle){
																echo '
																	<div class="title">'.$teamMemberTitle.'</div>
																';
															}
															if($teamMemberEmail){
																echo '
																	<div class="email"><a href="mailto:'.$teamMemberEmail.'" title="Email '.$teamMemberName.'">'.$teamMemberEmail.'</a></div>
																';
															}
													}
													//
													echo '</div>';

													//content
													$resourceTitle 			= get_sub_field('resource_title');
													$resourceContent 		= get_sub_field('resource_content');
													echo '<div class="column is-12-mobile is-9-tablet is-9-desktop is-9-widescreen resource-content">';
													if($resourceTitle != ''){
														echo '<strong>'.$resourceTitle.'</strong>';
													}
													echo $resourceContent;
													echo '</div>';
										    echo '
													</div>
												</section>
												';
										    wp_reset_postdata();
										endif;
									}	else {
										echo '
										<li class="small-block">
											<a href="'.$resourceLink['url'].'" title="'.$resourceTitle.'" target="_blank">';
											if($simpleResourceImg != ''){
												echo '
												<div class="resource-image">
													<img src="'.$simpleResourceImg.'" alt="'.$resourceTitle.'" class="resource-image">
												</div>
												';
											} else {
												echo '
												<div class="resource-image">
													<img src="'.$blogPlaceholder.'" alt="'.$blogPlaceholder.'" class="resource-image">
												</div>
												';
											}
											echo '
												<hr class="cb">
												<div>'.$resourceTitle.'</div>
											</a>
										</li>
										';
									}
								endwhile;
								echo '</ul></div>';
							}
		        endwhile;
		    }
	    endwhile;
			echo '</div></section>';
	}
}
add_shortcode( 'resources', 'resources_shortcode' );

?>
