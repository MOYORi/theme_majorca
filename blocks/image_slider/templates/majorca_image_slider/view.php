<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$navigationTypeText = ($navigationType == 0) ? 'arrows' : 'pages';
$c = Page::getCurrentPage();
if ($c->isEditMode()) {
    //$loc = Localization::getInstance();
    //$loc->pushActiveContext(Localization::CONTEXT_UI);
    ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <i style="font-size:40px; margin-bottom:20px; display:block;" class="fa fa-picture-o" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Image Slider disabled in edit mode.')?>
			<div style="margin-top: 15px; font-size:9px;">
				<i class="fa fa-circle" aria-hidden="true"></i>
				<?php if (count($rows) > 0) { ?>
					<?php foreach (array_slice($rows, 1) as $row) { ?>
						<i class="fa fa-circle-thin" aria-hidden="true"></i>
						<?php }
					}
				?>
			</div>
        </div>
    </div>
    <?php
    //$loc->popActiveContext();
} else {
    ?>
<script>
$(document).ready(function(){
    $(function () {
        $("#ccm-image-slider-<?php echo $bID ?>").responsiveSlides({
            prevText: "",   // String: Text for the "previous" button
            nextText: "",
		<?php if ($navigationType == 0) {?>
		nav:true,
		<?php
		}elseif($navigationType == 1) {?>
		pager: true,
		<?php }
		else{?>
		nav:true,
		pager: true,
		<?php }?>
            <?php if ($timeout) { echo "timeout: $timeout,"; } ?>
            <?php if ($speed) { echo "speed: $speed,"; } ?>
            <?php if ($pause) { echo "pause: true,"; } ?>
            <?php if ($noAnimate) { echo "auto: false,"; } ?>
            <?php if ($maxWidth) { echo "maxwidth: $maxWidth,"; } ?>
        });
    });
});
</script>

<div class="ccm-image-slider-container ccm-block-image-slider-<?php echo $navigationTypeText; ?>" >
    <div class="ccm-image-slider">
        <div class="ccm-image-slider-inner">

        <?php if (count($rows) > 0) {
    	?>
        <ul class="rslides" id="ccm-image-slider-<?php echo $bID ?>">
            <?php foreach ($rows as $row) {
    		?>
                <li class="majorca-image-list">
                <?php if ($row['title']) {
    			?>
                <div class="majorca-image-slider-text">
                    <h2 class="majorca-image-slider-title"><?php echo $row['title'] ?></h2>
                    <?php echo $row['description'] ?>
                </div>
                <?php
				}
    			?>
                <?php if ($row['linkURL']) {
    			?>
                    <a href="<?php echo $row['linkURL'] ?>" class="mega-link-overlay"></a>
                <?php
				}
    			?>
                <?php
                $f = File::getByID($row['fID'])
                ?>
                <?php if (is_object($f)) {
			    $tag = $app->make('html/image', array($f, false))->getTag();
			    if ($row['title']) {
			        $tag->alt($row['title']);
			    } else {
			        $tag->alt(h($f->getTitle()));
			    }
			    echo $tag;
			    ?>
                <?php
				}
				?>
                </li>
            <?php
			}
    		?>
        </ul>
        <?php
} else {
    ?>
        <div class="ccm-image-slider-placeholder">
            <p><?php echo t('No Slides Entered.');
    ?></p>
        </div>
        <?php
}
    ?>
        </div>

    </div>
</div>
<?php
} ?>
