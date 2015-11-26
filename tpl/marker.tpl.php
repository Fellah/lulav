<div class="wrap">
    <h1><?php echo $title?></h1>
    <form name="lulav" action="" method="post" enctype="multipart/form-data" autocomplete="off">

        <div id="titlediv">
            <div id="titlewrap">
                <label class="screen-reader-text" id="title-prompt-text" for="title">Enter marker title here</label>
                <input type="text" name="title" value="" id="title" spellcheck="true" autocomplete="off">
            </div>
        </div>

	    <div class="postbox">
	        <label for="lat">Latitude</label>
	        <input type="text" name="lat" value="" />
		    <label for="lng">Longitude</label>
		    <input type="text" name="lng" value="" />
	    </div>

	    <?php wp_editor( '', 'description', array('media_buttons' => false) ); ?>

	    <!-- <div class="postbox">
		    <label for="file">Image</label>
	        <input type="file" name="image" multiple="false" />
	    </div> -->

        <?php submit_button( 'Submit' ); ?>

    </form>

</div>
