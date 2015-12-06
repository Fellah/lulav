<div class="lulav">
	<?php if ( sizeof( $collections ) > 1 ): ?>
		<div class="llv-controls">
			<div class="llv-links">
				<a href="/kontakti-10ka/obratnaya-svyaz-2/">
					<img src="<?php echo plugins_url( '../images/partners.png', __FILE__ ); ?>" title="Контакты"
					     alt="Предложить партнерство">
				</a>
				<a href="/vakansii/">
					<img src="<?php echo plugins_url( '../images/resume.png', __FILE__ ); ?>" title="Контакты"
					     alt="Отправить резюме">
				</a>
				<a href="/kontakti-10ka/obratnaya-svyaz-2/">
					<img src="<?php echo plugins_url( '../images/events.png', __FILE__ ); ?>" title="Контакты"
					     alt="Пригласить на мероприятие">
				</a>
				<a href="/kontakti-10ka/obratnaya-svyaz-2/">
					<img src="<?php echo plugins_url( '../images/feedback.png', __FILE__ ); ?>" title="Контакты"
					     alt="Оставить отзыв">
				</a>
				<div class="llv-ctrl-bg"></div>
			</div>
			<div class="llv-arrows">
				<!--<a href="#" class="dashicons-before dashicons-arrow-left-alt2 left"></a>
				<a href="#" class="dashicons-before dashicons-arrow-right-alt2 right"></a>-->
				<div class="llv-arrows-panel">
					<a href="#" class="left"></a>
					<a href="#" class="right"></a>
				</div>
			</div>
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
