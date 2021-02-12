@if(have_rows('media_center'))
<section class="media-center stories main-content">
  <div class="columns is-multiline">
    @php
      if (isset($_GET['fancybox'])) {
        $vidid = $_GET['id'];
        echo '
        <script>
          jQuery(window).load(function () {
            //alert("a.vidlink-'.$vidid.'");
            jQuery("a.vidlink-'.$vidid.'").click();
          });
        </script>';
      }
    @endphp
    @php
    $vidid = '0';
    @endphp
    @while (have_rows('media_center'))@php(the_row())
      <div class="column is-4 is-story">
        @php
          $video = get_sub_field('media_link'); //Embed Code
          $video_url = get_sub_field('media_link', FALSE, FALSE); //URL
          $video_thumb_url = get_video_thumbnail_uri($video_url);
          echo '<a class="vidlink-'.$vidid++.'" data-fancybox="" href="'.$video_url.'">';
          echo '<div class="video-block">';
          echo '<icon class="icon-play-btn"></icon>';
          echo '<img class="video-link"  src="'.$video_thumb_url.'">';
          echo '</div>';
          echo '</a>';
        @endphp
        <div class="article-title"><a data-fancybox="" href="{!! get_sub_field('media_link') !!}">{!! get_sub_field('media_title') !!}</a></div>
      </div>
    @endwhile
  </div>
</section>
@endif
