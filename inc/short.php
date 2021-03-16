<?php

function vsstemmart_excerpt($atts){
    global $post;
    $atribut = shortcode_atts( array(
        'panjang'         => '150',
    ), $atts );
    $count = $atribut['panjang'];
    $html = get_the_content();
    $html = strip_tags($html);
    $html = substr($html, 0, $count);
    $html = substr($html, 0, strripos($html, " "));
    $html = '<p>'.$html.'...</p>';
    return $html;
}
add_shortcode('excerpt', 'vsstemmart_excerpt');

function pencarian() {
    ob_start();
    ?>
    <form action="<?php echo get_home_url(); ?>" class="form-row rounded border" method="get">
        <div class="col-9 col-md-10">
            <input type="text" class="form-control form-control-sm border-0" name="s" id="search" value="<?php the_search_query(); ?>" />
        </div>
        <div class="col-3 col-md-2 text-right px-0">
            <button class="btn btn-sm btn-light"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('pencarian', 'pencarian');

function justg_thumbnail( $atts, $width = 350, $height = 200 ) {
    
    // Handling attributes width & height 
	$attributes = shortcode_atts( array(
		'width'     => $width,
		'height'    => $height,
	), $atts );

	$width      = isset($attributes['width']) ? $attributes['width'] : '';
	$height     = isset($attributes['height']) ? $attributes['height'] : '';
	
	$url        = get_the_post_thumbnail_url(); // Get featured image url
	$imgurl     = aq_resize( $url, $width, $height, true, true, true ); // Resize image
	
	ob_start();
	echo '<a href="'.get_the_permalink().'">';
    	if($url){
            echo '<img class="rounded w-100" src="'.$imgurl.'" alt=""/>';
    	} else {
            echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="background-color: #ececec;width: 100%;height: auto;enable-background:new 0 0 60 60;" xml:space="preserve" width="'.$width.'" height="'.$height.'"><g><g><path d="M55.201,15.5h-8.524l-4-10H17.323l-4,10H12v-5H6v5H4.799C2.152,15.5,0,17.652,0,20.299v29.368   C0,52.332,2.168,54.5,4.833,54.5h50.334c2.665,0,4.833-2.168,4.833-4.833V20.299C60,17.652,57.848,15.5,55.201,15.5z M8,12.5h2v3H8   V12.5z M58,49.667c0,1.563-1.271,2.833-2.833,2.833H4.833C3.271,52.5,2,51.229,2,49.667V20.299C2,18.756,3.256,17.5,4.799,17.5H6h6   h2.677l4-10h22.646l4,10h9.878c1.543,0,2.799,1.256,2.799,2.799V49.667z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M30,14.5c-9.925,0-18,8.075-18,18s8.075,18,18,18s18-8.075,18-18S39.925,14.5,30,14.5z M30,48.5c-8.822,0-16-7.178-16-16   s7.178-16,16-16s16,7.178,16,16S38.822,48.5,30,48.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M30,20.5c-6.617,0-12,5.383-12,12s5.383,12,12,12s12-5.383,12-12S36.617,20.5,30,20.5z M30,42.5c-5.514,0-10-4.486-10-10   s4.486-10,10-10s10,4.486,10,10S35.514,42.5,30,42.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M52,19.5c-2.206,0-4,1.794-4,4s1.794,4,4,4s4-1.794,4-4S54.206,19.5,52,19.5z M52,25.5c-1.103,0-2-0.897-2-2s0.897-2,2-2   s2,0.897,2,2S53.103,25.5,52,25.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/></g></g> </svg>';
        }
    echo '</a>';
	return ob_get_clean();
}
add_shortcode( 'thumbnail', 'justg_thumbnail' );