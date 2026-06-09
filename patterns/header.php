<?php
/**
 * Title: Header
 * Slug: divonex/header
 * Categories: divonex
 * Description: A normal header with a logo and navigation menu.
 *
 * @since Divonex 1.0
 */

?>
<!-- wp:group {"tagName":"header","metadata":{"name":"header"},"align":"full","style":{"spacing":{"padding":{"top":"20px","bottom":"20px"}}},"backgroundColor":"oxford","layout":{"type":"constrained"}} -->
<header class="wp-block-group alignfull has-oxford-background-color has-background" style="padding-top:20px;padding-bottom:20px">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">
			<!-- wp:site-logo {"width":32,"style":{"layout":{"selfStretch":"fit","flexSize":null}}} /-->
			<!-- wp:site-title {"style":{"elements":{"link":{"color":{"text":"var:preset|color|off-white"}}}},"textColor":"off-white","fontSize":"divo-medium"} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:divonex/navigation {"colors":{"text":"#FFFEF8","bg":"","textHover":"#FFFEF8","bgHover":""}} /-->
	</div>
	<!-- /wp:group -->
</header>
<!-- /wp:group -->