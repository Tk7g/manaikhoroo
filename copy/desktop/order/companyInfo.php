<?php
include(WEB_TEMPLATE."header.php");
?>
<div id="homeWrapper">
	<div class="orderPage">
		<div class="row">
			<div class="medium-9 columns orderContent">
				<?php if ( isset( $result ) ) { ?>
				<div data-alert class="infoAlert alert-box alert round">
  					<?php echo $result; ?>
  					<a href="#" class="close">&times;</a>
				</div>
				<?php } ?>
				<div class="orderPageTitle">
					<h1><?php echo $page_title; ?></h1>
				</div>
				<div class="orderPageTab">
					<ul class="button-group">
						<li><a href="order.php?action=loginOrder" class="button">Захиалга өгөх</a></li>
						<li><a href="order.php?action=companyInfo" class="button activeTab">Компаний бүртгэл</a></li>
						<li><a href="order.php?action=myOrder" class="button">Миний захиалгууд</a></li>
					</ul>
				</div>
				<div class="orderFormTitle">
					Компаний бүртгэл
				</div>
				<div class="orderForm">
					<form action="order.php?action=companyInfo" method="post" autocomplete="off">
						<input type="hidden" name="id" id="Id" value="<?php echo $company['id']; ?>" />
						<div class="row">
							<div class="medium-6 columns">
								<div class="orderFormRow" style="border-top: none;">	
									<label>Гэрээний дугаар</label>
									<input name="agreement_id" type="text" id="AgreementId" value="<?php echo $company['agreement_id']; ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
									<label>Компаний нэр</label>
        							<input name="name" type="text" id="Name" value="<?php echo $company['name']; ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
									<label>Захиалагчийн нэр</label>
        							<input name="client_name" type="text" id="ClientName" value="<?php echo $company['client_name']; ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
									<label>Албан тушаал</label>
        							<input name="position_id" type="text" id="PositionId" value="<?php echo getPositionName($company['position_id']); ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
									<label>Утас</label>
        							<input name="phone" type="text" id="Phone" value="<?php echo $company['phone']; ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
									<label>И-мэйл</label>
        							<input name="email" type="text" id="Email" value="<?php echo $company['email']; ?>" disabled="disabled" />
								</div>
								<div class="orderFormRow">
						 			<label>Нууц үг</label>
        							<input name="password" type="password" id="Password" />
								</div>
								<div class="orderFormRow">
									<label>Нууц үг баталгаажуулах</label>
        							<input name="password2" type="password" id="Password2" />
								</div>
								<div class="orderFormBtn">
									<button type="submit" name="companySubmit" class="saveCompany">Хадгалах</button>
        						</div>
							</div>
							<div class="medium-6 columns">
								<div class="infoBlockTitle">
									Захиалагчийн мэдээлэл
								</div>
								<div class="orderFormRow" style="border-top: none;">
									<div class="row">
										<div class="medium-6 columns text-left">
											<div class="infoLabel">Бүртгэсэн огноо</div>
										</div>
										<div class="medium-6 columns text-right">
											<div class="infoText"><?php echo $company['created']; ?></div>
										</div>
									</div>
								</div>
								<div class="orderFormRow" style="border-bottom: none;">
									<div class="row">
										<div class="medium-8 medium-centered columns">
											<a class="logOutBtn" href="order.php?action=logout">Системээс гарах</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="medium-3 columns">
				<div class="sideBlock1">
					<div class="sideCalculator">
						<div class="sideCatTitle">
							Тооцоолуур
						</div>
						<div class="sideCalcBody">
							<div class="calcRow">
								<div class="calcLabel">
									Урт (метр)
								</div>
								<div class="calcInput">
									<input id="Length" value="0" />
								</div>
							</div>
							<div class="calcRow">
								<div class="calcLabel">
									Өргөн (метр)
								</div>
								<div class="calcInput">
									<input id="Width" value="0" />
								</div>
							</div>
							<div class="calcRow">
								<div class="calcLabel">
									Зузаан (метр)
								</div>
								<div class="calcInput">
									<input id="Thickness" value="0" />
								</div>
							</div>
							<div class="calcBtn">
								<a href="#" id="calcBtn1">Тооцоолох</a>
							</div>
						</div>
						<div class="calcResult">
							<div class="calcResRow">
								<div class="calcResLabel">Хэмжээ (м<sup>3</sup>)</div>
								<div class="calcResInfo">--</div>
							</div>
						</div>
					</div>
					<div class="sideShapeCalc">
						<div class="sideCatTitle">
							Тооцоолуур
						</div>
						<div class="sideShapeCalcBody">
							<div class="calcShapeBlock">
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeCyl"><img src="<?php echo IMG_FOLDER.'shapes/cylinder.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeCylCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r:</div>
											<div class="calcInput"><input id="CylR" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeCylCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeCylRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeCylHol"><img src="<?php echo IMG_FOLDER.'shapes/cylinder-hollow.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeCylHolCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>1</sup>:</div>
											<div class="calcInput"><input id="CylR1" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>2</sup>:</div>
											<div class="calcInput"><input id="CylR2" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH1" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeCylHolCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeCylHolRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
								<div class="calcShapeRow">
									<a class="shapeBtn" id="shapeRec"><img src="<?php echo IMG_FOLDER.'shapes/rectangle.png'; ?>" /></a>
									<div class="shapeVolCalc" id="shapeRecCalc">
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>1</sup>:</div>
											<div class="calcInput"><input id="CylR11" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">r<sup>2</sup>:</div>
											<div class="calcInput"><input id="CylR22" value="0" /></div>
										</div>
										<div class="shapeVolCalcRow">
											<div class="calcLabel">h:</div>
											<div class="calcInput"><input id="CylH11" value="0" /></div>
										</div>
										<div class="shapeVolCalcBtn">
											<a id="shapeRecCalcBtn">Тооцоолох</a>
										</div>
										<div class="shapeVolRes">
											<div class="shapeVolResLabel">Хэмжээ (м<sup>3</sup>)</div>
											<div id="shapeRecRes" class="shapeVolInfo">--</div>
										</div>
									</div>
								</div>
							</div>
							<div class="shapeCalcSection">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include(WEB_TEMPLATE."footer.php");
?>