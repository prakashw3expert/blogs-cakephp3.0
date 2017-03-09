<?php if($events) { ?>
<div class="row">
	<div class="col-sm-12">
		<h1 class="section-title">Posted Events</h1>
		<div class="section">
			<div class="row">
				<div class="col-sm-12">
					<div class="section">
						<div class="row">
							<?= $this->element('events', ['events' => $events]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>


