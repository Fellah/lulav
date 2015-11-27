<div class="lulav">
	<div class="map"></div>

	<ul>
		<?php foreach ( $markers as $marker ): ?>
			<li>
				<?php echo $marker['title']; ?>
				<div data-coordinates="<?php echo $marker['coordinates']; ?>">
					<?php echo $marker['description']; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php foreach ( $collections as $collection ): ?>
		<div class="thumbnails">
			<?php foreach ( $collection as $row ): ?>
				<div>
					<?php foreach ( $row as $cell ): ?>
						<div class="cell" data-thumbnail="<?php echo $cell['thumbnail']; ?>">
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>
