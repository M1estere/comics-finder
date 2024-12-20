<?php
/**
 * Title: single
 * Slug: alleyoop/single
 * Categories: hidden
 * Inserter: no
 */
?>

<!-- wp:template-part {"slug":"header-with-cover","area":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"10vh","bottom":"10vh"}}},"layout":{"type":"default"}} -->
<main class="wp-block-group" style="margin-top:10vh;margin-bottom:10vh"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:group {"style":{"spacing":{"padding":{"right":"2.5%"},"blockGap":"5vh"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:2.5%"><!-- wp:post-content {"layout":{"type":"constrained","justifyContent":"center"}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--60);margin-bottom:0px"><!-- wp:group {"style":{"spacing":{"blockGap":"0.5rem","padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"border":{"top":{"color":"var:preset|color|secondary","width":"1px"},"bottom":{"color":"var:preset|color|contrast","width":"1px"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--secondary);border-top-width:1px;border-bottom-color:var(--wp--preset--color--contrast);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
  <!-- wp:post-terms {"term":"post_tag","prefix":"Tags: "} /-->

  <!-- wp:post-terms {"term":"category","prefix":"Categories: "} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"style":{"spacing":{"blockGap":"5vh"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group">
<?php
  $author_name = get_post_meta(get_the_ID(), '_news_author', true);
  if ($author_name) {
        echo 'Автор' . '<br/>' . $author_name;
  }
?>

<!-- wp:post-author-biography /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%"} -->
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px"><!-- wp:template-part {"slug":"footer","tagName":"footer"} /--></div>
<!-- /wp:group -->
