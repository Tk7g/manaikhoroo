
<h3>Тэмдэглэгээ</h3>
			
			<?php if($activeDistrict!==null):?>
				<div class="dsb-content panel panel-default">
					<div class="panel-body">
						<?php foreach($results['regions'] as $region) : ?>

							<div class="ds-row">
								<div class="rs-link" data="<?php echo $region['id']; ?>">
								<?php echo $region['title']; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif;?>
	
	
	
		<ul class="list-group">
			<li class="list-group-item colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="pop-density">
					</div>
					<div class="color-checked" data="pop-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Хүн амын нягтаршил
					</div>
				</div>
			</li>
			<li class="list-group-item colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="kin-density">
					</div>
					<div class="color-checked" data="kin-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Цэцэрлэгт хамрагддаггүй [%]
					</div>
				</div>
			</li>
			<li class="list-group-item colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="school-density">
					</div>
					<div class="color-checked" data="school-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Сургуульд хамрагддаггүй [%]
					</div>
				</div>
			</li>
		</ul>

	
	
	<div class="panel-group" id="marker-select" role="tablist" aria-multiselectable="true" aria-expanded="false">
	  <div class="panel panel-default">
	    
	    
		<?php 
			$marker_groups = Marker::getMarkerGroups();
			$m = 0;
			foreach($marker_groups as $m_group) :
		?>	
	    <div class="panel-heading" role="tab" id="heading<?php echo $m_group['id'];?>" data="<?php echo $m_group['id']; ?>">
	      <h4 class="panel-title">
	        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $m_group['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $m_group['id'];?>">
	          <?php echo $m_group['title']; ?> <span class="caret"></span>
	        </a>
	      </h4>
	    </div>
	    	
	    <div id="collapse<?php echo $m_group['id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $m_group['id'];?>">
	      <ul class="list-group">
	      	  <?php
					$type_markers[$m] = Marker::getGroupMarkers($m_group['id']);
					foreach($type_markers[$m] as $t_marker) :
			?>
			  <li class="list-group-item marker-row">
			  	<div class="marker-image">
					<img src="<?php echo $t_marker['image']; ?>" />
					</div>
					<div class="marker-checker">
						<div class="marker-checkbox" data="<?php echo $t_marker['id']; ?>">
						</div>
						<div class="marker-checked" data="<?php echo $t_marker['id']; ?>">
						</div>
					</div>
					<div class="marker-description">
						<div class="marker-title">
							<?php echo $t_marker['title']; ?>
						</div>
					</div>
			  </li>
				<?php endforeach;?>
			</ul>
	    </div>
		<?php endforeach;?>
	  </div>
	  
	 
	  </div>	
	
	<div class="panel panel-default">
		<div class="panel-body">
		<div class="marker-row">
			<div class="marker-image">
			<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/line1.png" />
			</div>
			<div class="marker-checker">
				<div class="marker-checkbox" data="sectionline">
				</div>
				<div class="marker-checked" data="sectionline">
				</div>
			</div>
			<div class="marker-description">
				<div class="marker-title">
					Хэсгийн хил
				</div>
			</div>
			</div>
		</div>
	</div>
