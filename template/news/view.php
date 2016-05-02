<div id="news-lists">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="news-title">
					<?php echo $news['title']; ?>
				</div>
				<div class="news-date">
					<?php echo substr($news['created'], 0, 10); ?>
				</div>
				<div class="news-content">
					<?php echo $news['content']; ?>
				</div>
			</div>
		</div>
	</div>
</div>