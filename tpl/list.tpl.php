<div class="wrap">
    <h1><?php echo $title?></h1>
    <form name="lulav" action="<?php echo $action; ?>" method="post" autocomplete="off">

        <div id="titlediv">
            <div id="titlewrap">
                <label class="screen-reader-text" id="title-prompt-text" for="title">Enter marker title here</label>
                <input type="text" name="marker_title" value="" id="title" spellcheck="true" autocomplete="off">
            </div>
        </div>

        <!-- <div id="postdivrich" class="postarea wp-editor-expand">
            <?php //wp_editor(); ?>
        </div> -->

        <?php submit_button( 'Submit', 'primary', 'add' ); ?>

    </form>

</div>
