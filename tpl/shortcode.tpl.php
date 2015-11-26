<div class="lulav">
    <div class="map"></div>
    <div class="list">
	    <?php foreach ( $marks as $mark ): ?>
			<a href="#">
				<span><?php echo $mark['title']; ?></span>
				<div data-lat="<?php echo $mark['lat']; ?>" data-lng="<?php echo $mark['lng']; ?>">
					<h3><?php echo $mark['title']; ?></h3>
					<?php echo $mark['description']; ?>
				</div>
			</a><br/>
	    <?php endforeach; ?>
    </div>
</div>
