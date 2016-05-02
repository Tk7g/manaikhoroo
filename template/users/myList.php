<?php 
include(ADMIN_TEMPLATE."session_check.php"); 
include(SITE_TEMPLATE. "header.php");
?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
			<h2 class="up-title">
				Миний илгээсэн санал хүсэлт
			</h2>
			<div class="sanalList">
				<table width="100%">
					<tr>
						<th width="5%">№</th>
						<th width="15%">Ангилал</th>
						<th width="34%">Агуулга</th>
						<th width="13%">Илгээсэн огноо</th>
						<th width="20%">Явц</th>
						<th width="12%"></th>
					</tr>
					<?php
						$i = 0; 
						foreach($xml_data as $x_data) : 
						$i = $i + 1;
						switch ( $x_data->type_id ) {
							case 10:
								$background_color = '#ffa900';
								break;
							case 13:
								$background_color = '#00bddc';
								break;
							case 9:
								$background_color = '#8bc837';
								break;
							case 12:
								$background_color = '#00bddc';
								break;
							case 11:
								$background_color = '#ff6f2e';
								break;
						}
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td class="text-center"><span style="border-radius: 2px; padding: 2px 5px; background: <?php echo $background_color; ?>; color: #FFFFFF;"><?php echo $x_data->type; ?></span></td>
						<td><?php echo substr($x_data->title, 0, 250); ?></td>
						<td><?php echo $x_data->ognoo; ?></td>
						<td class="text-center">
							<?php echo $x_data->status; ?>
						</td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
  								Явцын дэлгэрэнгүй
							</button>
						</td>
<div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Өргөдөл</h4>
      </div>
      <div class="modal-body">
      <?php
      	$replyData = file_get_contents('http://ub1200.mn/mobilelog/'.$x_data->ID);
		$reply=simplexml_load_string($replyData);
      ?>
      	<h2>Өргөдөл</h2>
      	<div class="alert alert-info" role="alert"><?php echo $x_data->title; ?></div>
      	<h2>Өргөдлийн шийдвэрлэлтийн явц</h2>
      	<div class="well well-sm"><b>Төлөв:</b> <?php echo $reply->answer->stts; ?></div>
      	<div class="well well-sm"><b>Өргөдлийг хянасан:</b> <?php echo $reply->answer->emp; ?></div>
      	<div class="well well-sm"><b>Албан тушаал:</b> <?php echo $reply->answer->dep; ?></div>
      	<div class="well well-sm"><b>Байгууллага:</b> <?php echo $reply->answer->org; ?></div>
      	<div class="well well-sm"><b>Утас:</b> <?php echo $reply->answer->mobile; ?></div>
      	<div class="well well-sm"><b>Хариу:</b> <?php echo $reply->answer->msg; ?></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Хаах</button>
      </div>
    </div>
  </div>
</div>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>