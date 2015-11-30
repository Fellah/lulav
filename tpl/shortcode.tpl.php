<div class="lulav">
	<?php if ( sizeof( $collections ) > 1 ): ?>
		<div class="controls">
			<a href="#" class="dashicons-before dashicons-arrow-left-alt2 left"></a>
			<a href="#" class="dashicons-before dashicons-arrow-right-alt2 right"></a>
		</div>
	<?php endif; ?>

	<div class="map"></div>

	<div class="carousel">
		<?php foreach ( $collections as $collection ): ?>
			<div class="thumbnails">
				<?php foreach ( $collection as $row ): ?>
					<div class="line">
						<?php foreach ( $row as $cell ): ?>
							<div class="cell"
							     data-id="<?php echo $cell['id']; ?>"
							     data-thumbnail="<?php echo $cell['thumbnail']; ?>">
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<ul>
		<?php foreach ( $markers as $marker ): ?>
			<li data-id="<?php echo $marker['id']; ?>">
				<?php echo $marker['title']; ?>
				<div data-coordinates="<?php echo $marker['coordinates']; ?>">
					<?php echo $marker['description']; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
