@if(have_rows('storage_footer_blocks', 'cpt_sitew'))
<section class="resource-block main-content">
  <div class="columns is-tablet is-mobile is-multiline">
    @while (have_rows('storage_footer_blocks','cpt_sitew'))@php(the_row())
      <div class="column is-one-third-tablet is-full-mobile">
        <div class="title">
          {!! get_sub_field('footer_block_title') !!}
        </div>
        <div class="image">
          <img src="{!! get_sub_field('footer_block_image')['url'] !!}" alt="{!! get_sub_field('footer_block_image')['alt'] !!}">
        </div>
        <div class="block-content">
          {!! get_sub_field('footer_block_content') !!}
          <a class="more" href="{!! get_sub_field('footer_block_link')['url'] !!}" title="{!! get_sub_field('footer_block_link')['title'] !!}">{!! get_sub_field('footer_block_link')['title'] !!}{!! $globalvalue->moreafter !!}</a>
        </div>
      </div>
    @endwhile
  </div>
</section>
@endif
