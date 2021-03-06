<?php get_header();?>
<?php
$playlists = new WP_Query(array(
    'post_type' => 'playlist',
    'posts_per_page' => 10,
    'post__not_in' => array(get_the_ID()),
    'meta_key' => 'downloads_this_week',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
));


while(have_posts()){
    the_post();?>
    <section class="main" id="single">
        <div class="container">
            <div class="top-info" >
                <div class="bg-img"><img name="<?php echo mdd_get_artist()." - ".mdd_get_title()?>" src="<?php mdd_the_single_back_imgUrl()?>" alt="<?php echo mdd_get_artist()." - ".mdd_get_title()?>"></div>
                <div class="top-single-wrapper">
                <img name="<?php the_title()?>" id="post-thumbnail" src="<?php mdd_the_single_front_imgUrl()?>" alt="<?php the_title()?>">
                <div class="single-info">
                    <div class="author"><?php echo mdd_get_artist()?></div>
                    <div class="title"><?php mdd_the_title()?></div>
                    
                    <?php if(mdd_get_download_num() > 20): ?>
                        <span class="download-count"><span id="download-num"><?php echo mdd_get_download_num()?></span> <img class="download-icon" src="<?php echo get_theme_file_uri('/assets/icons/download.svg')?>" alt="download icon"></span>
                    <?php endif;?>
                    
                    <?php
                        if(is_music_playable()){
                            mdd_the_music_size();
                            mdd_player(array(
                                "previous_post_url"  => mdd_get_previous_post_url(),
                                "next_post_url"  => mdd_get_next_post_url()
                            ));
                        }
                    ?>

                    <?php if(mdd_get_download_audio_url()): ?>
                        <?php if(mdd_is_download_external_link()):?>
                            <a id="download-btn" class="download-btn" data_music="<?php the_ID();?>" data_artist="<?php mdd_the_artist_id()?>"  href="<?php echo mdd_get_download_audio_url()?>"  target="_blank">
                                <p class="download-btn-text">
                                    <strong>Baixar Playlist
                                        <img class="download-icon" src="<?php echo get_theme_file_uri('/assets/icons/download.svg')?>" alt="download icon">
                                    </strong>
                                </p>
                            </a>
                        <?php endif?>

                        <?php if(!mdd_is_download_external_link()):?>
                            <a id="download-btn" class="download-btn" data_music="<?php the_ID();?>" data_artist="<?php mdd_the_artist_id()?>"  href="<?php echo mdd_get_download_audio_url()?>" download="<?php echo mdd_get_download_name()?>">
                                <p class="download-btn-text">
                                    <strong>Baixar Playlist
                                        <img class="download-icon" src="<?php echo get_theme_file_uri('/assets/icons/download.svg')?>" alt="download icon">
                                    </strong>
                                </p>
                            </a>
                        <?php endif;?>
                    <?php endif;?>
                    <?php dynamic_sidebar( 'single-top-sidebar' ); ?>

                </div>
            </div>
        </div>
        <?php 
            mdd_top_musics();
        ?>

<div class="content">
    <p>
        <div class="info info-pt">
            <ul>
                <li>Author: <strong><?php mdd_the_artists();?></strong></li>
                <li>Titulo: <strong><?php mdd_the_title();?></strong></li>
                <li class="categoria">Categoria: <strong><?php the_category()?></strong></li>
                
                <?php if(mdd_get_music_list_num()):?>
                    <li>numero de musicas: <?php mdd_the_music_list_num();?></li>
                <?php endif;?>

                <?php if(mdd_get_year()):?>
                    <li>Ano: <strong><?php echo mdd_get_year()?></strong></li>
                <?php endif;?>
                <?php mdd_the_music_metadeta();?>

            </ul>
            <?php if(mdd_get_download_audio_url()): ?>
                <?php if(mdd_is_download_external_link()):?>
                    <strong class="btn-baixar btn-baixar-pt">
                        <a class="download-btn" data-music="<?php the_ID();?>" href="<?php echo mdd_get_download_audio_url()?>" target="_blank">
                            <?php echo mdd_get_artist()." - ".mdd_get_title()." "?>Download mp3
                        </a> 
                    </strong>
                <?php endif?>

                <?php if(!mdd_is_download_external_link()):?>
                    <strong class="btn-baixar btn-baixar-pt">
                        <a class="download-btn" data-music="<?php the_ID();?>" href="<?php echo mdd_get_download_audio_url()?>" download="<?php echo mdd_get_download_name()?>">
                            <?php echo mdd_get_artist()." - ".mdd_get_title()." "?>Download mp3
                        </a> 
                    </strong>
                    
                <?php endif;?>
            <?php endif;?>
        </div>
    </p>

    <?php 
        mdd_the_music_list();
    ?>
</div>

<?php 
    mdd_the_artist_content();
?>
<div class="Playlists posts-cont">
    <div class="header">
        <?php madoda_scroll_card_header(array(
            'name'  =>  'Playlists',
            'targetScroll'  => 'playlist-wrap',
            'see_more'  =>  array(
                'link'  =>  mdd_get_archiveUrl("playlist")
            )
        ))?>
    </div>
    <div id="playlist-wrap" class="wrapper-card">

        <?php 
            while($playlists->have_posts()){
                $playlists->the_post();
                get_template_part('template-parts/playlist');
            }
            wp_reset_postdata();
        ?>
    </div>

<?php if(get_the_content()):?>
    <div class="wp-content">
        <?php the_content(); ?>
    </div>
<?php endif; ?>
   
    <div class="tags">
        <?php the_tags();?>
    </div> 
</div>

    <div class="wp-comments">
        <?php comments_template(); ?>
    </div>

</section>
<?php
//close while
}
?>

<?php get_footer();?>