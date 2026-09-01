<?php
/**
 * Blog / search result cards (featured first post + grid + pagination).
 *
 * @package Restwell_Retreats
 *
 * @param array $args {
 *     @type string $empty_message    Shown when the query has no posts.
 *     @type string $empty_blog_url   Optional URL for a “browse the blog” link after empty copy.
 *     @type string $pagination_aria  Aria label for the posts pagination block.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();
$args = wp_parse_args(
	$args,
	array(
		'empty_message'   => __( 'More articles will appear here as the blog grows.', 'restwell-retreats' ),
		'empty_blog_url'  => '',
		'pagination_aria' => __( 'Blog posts navigation', 'restwell-retreats' ),
	)
);

$empty_message   = (string) $args['empty_message'];
$empty_blog_url  = (string) $args['empty_blog_url'];
$pagination_aria = (string) $args['pagination_aria'];
?>
    <section class="section-y band-white">
      <div class="container">
        <?php if ( have_posts() ) : ?>
          <?php
          $card_index = 0;
          $cards      = array();
          while ( have_posts() ) :
            the_post();
            $post_id   = get_the_ID();
            $title     = get_the_title();
            $excerpt   = trim( (string) get_the_excerpt() );
            if ( $excerpt === '' ) {
              $excerpt = wp_trim_words( wp_strip_all_tags( get_the_content( null, false ) ), 24, '…' );
            }
            $category  = function_exists( 'restwell_get_primary_category' ) ? restwell_get_primary_category( $post_id ) : '';
            $read_mins = function_exists( 'restwell_estimate_read_time' ) ? restwell_estimate_read_time( get_post_field( 'post_content', $post_id ) ) : 1;
            $permalink = get_permalink( $post_id );

            if ( 0 === $card_index ) {
              list( $thumb, $thumb_alt ) = restwell_get_post_card_thumb( $post_id, 'large' );
              ?>
        <article class="blog-featured">
          <a class="blog-featured__media" href="<?php echo esc_url( $permalink ); ?>" aria-hidden="true">
            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $thumb_alt ); ?>" width="1000" height="625" loading="lazy" decoding="async" />
            <span class="blog-featured__scrim" aria-hidden="true"></span>
            <?php if ( $category !== '' ) : ?>
              <span class="tag blog-featured__tag"><?php echo esc_html( $category ); ?></span>
            <?php endif; ?>
          </a>
          <div class="blog-featured__overlay">
            <p class="blog-meta blog-meta--overlay"><?php echo esc_html( sprintf( /* translators: %d: minutes */ _n( '%d min read', '%d min read', $read_mins, 'restwell-retreats' ), $read_mins ) ); ?></p>
            <h2><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h2>
            <p class="blog-featured__excerpt"><?php echo esc_html( $excerpt ); ?></p>
          </div>
        </article>
              <?php
            } else {
              $cards[] = array(
                'permalink' => $permalink,
                'title'     => $title,
                'excerpt'   => $excerpt,
                'category'  => $category,
                'read_mins' => $read_mins,
                'post_id'   => $post_id,
              );
            }
            ++$card_index;
          endwhile;
          ?>
          <?php if ( ! empty( $cards ) ) : ?>
        <ul class="card-grid card-grid--2" role="list" data-reveal>
          <?php foreach ( $cards as $card ) : ?>
            <?php list( $thumb, $thumb_alt ) = restwell_get_post_card_thumb( $card['post_id'], 'medium_large' ); ?>
          <li><article class="media-card">
            <a class="media-card__image" href="<?php echo esc_url( $card['permalink'] ); ?>" aria-hidden="true">
              <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $thumb_alt ); ?>" width="640" height="480" loading="lazy" decoding="async" />
              <?php if ( $card['category'] !== '' ) : ?>
                <span class="tag media-card__tag"><?php echo esc_html( $card['category'] ); ?></span>
              <?php endif; ?>
            </a>
            <p class="blog-meta"><?php echo esc_html( sprintf( /* translators: %d: minutes */ _n( '%d min read', '%d min read', $card['read_mins'], 'restwell-retreats' ), $card['read_mins'] ) ); ?></p>
            <h3><a href="<?php echo esc_url( $card['permalink'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a></h3>
            <p><?php echo esc_html( $card['excerpt'] ); ?></p>
          </article></li>
          <?php endforeach; ?>
        </ul>
          <?php endif; ?>
          <?php
          the_posts_pagination(
            array(
              'mid_size'   => 1,
              'prev_text'  => esc_html__( 'Newer posts', 'restwell-retreats' ),
              'next_text'  => esc_html__( 'Older posts', 'restwell-retreats' ),
              'aria_label' => $pagination_aria,
            )
          );
          ?>
        <?php else : ?>
          <p class="lede">
            <?php echo esc_html( $empty_message ); ?>
            <?php if ( $empty_blog_url !== '' ) : ?>
              <a href="<?php echo esc_url( $empty_blog_url ); ?>"><?php esc_html_e( 'Browse the blog', 'restwell-retreats' ); ?></a>
            <?php endif; ?>
          </p>
        <?php endif; ?>
      </div>
    </section>
