<div class="lulav">
	<?php if ( sizeof( $collections ) > 1 ): ?>
		<div class="llv-controls">
			<a href="#" class="dashicons-before dashicons-arrow-left-alt2 left"></a>
			<a href="#" class="dashicons-before dashicons-arrow-right-alt2 right"></a>
		</div>
	<?php endif; ?>

	<div class="llv-map"></div>

	<div class="llv-thumbs">
		<?php foreach ( $collections as $collection ): ?>
			<table>
				<?php foreach ( $collection as $row ): ?>
					<tr>
						<?php foreach ( $row as $cell ): ?>
							<td data-id="<?php echo $cell['id']; ?>"
							    data-coordinates="<?php echo $cell['coordinates']; ?>"
							    data-thumbnail="<?php echo $cell['thumbnail']; ?>">
								<div class="llv-desc">
									<?php echo $cell['description']; ?>
								</div>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endforeach; ?>
	</div>
</div>
