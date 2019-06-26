
<!-- CSS Reset : END -->
<!-- Progressive Enhancements : BEGIN -->
						 
<?php

  $encode= json_decode($content); 
  $name= $encode[0]->basic_info->name;
  $email= $encode[0]->basic_info->email;
  $phone= $encode[0]->basic_info->phone;
  $designation= $encode[0]->basic_info->designation;
  $award=$encode[0]->award;
  $experience=$encode[0]->experience;
  
 //print_r(json_decode($content));die;
	// foreach(json_decode($content) as $c)
	// {
	//	print_r($c);
	// }
	 
//	print_r($content); die;
 
?>

<div style="max-width: 700px; margin: 0 auto;" class="email-container"> 
<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto; font-family: times;">
		<tr style="background-color: #615655;" height="50px">
		
				<td width="100%" style="text-align: center;height: 50px">
					<h4 style="color: #fff;font-size: 26px;letter-spacing:2px;"><!--<font face="Helvetica">--><?=$name?><!--</font> --></h4>
				</td>
				
		</tr>
		
		<tr style="background-color: #615655;" height="50px">		
			<td width="20%" style="text-align: center;">			
			</td>
			<td width="60%" style="text-align: center;">
				<h5 style="color: #fff;width: 300px;margin: auto;border: solid 1px #fff;font-size: 14"><?=$designation?></h5>
			</td>
			<td width="20%" class="logo" style="text-align: center;"></td>
		</tr>
		<!-- end tr -->
		<tr>
			<td width="40%" class="logo" style="text-align: center;background-color: #615655;">
				<table>
					<tr>
						<td style="width:10%;"></td>
						<td style="width:80%;">				
							<h2 style="color: #fff;font-size: 18px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">
								CONTACT</h2>
							<div style="text-align: center;clear: both;padding-top: 10px;">
								<img src="<?php echo base_url('assets/images/')?>user.png" style="vertical-align: middle;">
								<h4 style="color: #fff;font-weight: 500;font-size: 16px;">
										&nbsp; Sample Your Name
								</h4>
								<img src="<?php echo base_url('assets/images/')?>email.png" style="vertical-align: middle;">
								&nbsp;<h4 style="color: #fff;font-weight: 500;font-size: 16px;"><?=$email?> </h4>
								<img src="<?php echo base_url('assets/images/')?>call.png" style="vertical-align: middle;">
								<h4 style="color: #fff;font-weight: 500;font-size: 16px;">&nbsp;  <?=$phone?> </h4>
								<img src="<?php echo base_url('assets/images/')?>address.png" style="vertical-align: middle;">
								<h4 style="color: #fff;font-weight: 500;font-size: 16px;">&nbsp;<span style="">
								 <?=$encode[0]->basic_info->address?></span></h4>
							</div>
						</td>
						<td style="width:10%;"></td>
					</tr>
				</table>
				<table>
					<tr>
						<td style="width:10%;"></td>
						<td style="width:80%;">
					<h2 style="color: #fff;font-size: 18px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">
						AWARDS</h2>
					<div style="text-align: left;">
						
						<?php 	foreach($award as $awards)
								{ ?>
								 
								    <div style="text-align: center;">
										<!--<h5 style="color: #fff;font-weight: 500"><a href="#" style="font-size: 16px;color: #fff;vertical-align: middle;">
										<span style="font-size: 14px;"><?=$awards->title?></span></a>
										</h5>-->
										<h4 style="color: #fff;font-weight: 500;font-size: 16px;"><?=$awards->title?></h4>
										<h4 style="clear:both;margin-top: 0px;color: #fff; font-weight: 400 !important;font-size: 14px;">
											 <?=$awards->description?></h4>
									</div>
								<?php }
							?>
	  
	  
						<!--<div style="text-align: center;">
							<h5 style="color: #fff;font-weight: 500"><a href="#" style="font-size: 16px;color: #fff;vertical-align: middle;"><span style="font-size: 14px;">GRAPHICS DESIGN</span></a>
							</h5>
							<h4 style="color: #fff;font-weight: 500;font-size: 16px;">MARKETING AXECUTIVE AWARDS</h4>
							<h4 style="clear:both;margin-top: 0px;color: #fff; font-weight: 400 !important;font-size: 14px;">
								 this is example</h4>
						</div>
						<div style="text-align: center;">
							<h5 style="color: #fff;font-weight: 500"><span style="font-size: 14px;">GRAPHICS DESIGN</span>
							</h5>
							<h4 style="color: #fff;font-weight: 400;font-size: 16px">MARKETING AXECUTIVE AWARDS</h4>
							<h4 style="clear:both;margin-top: 0px;color: #fff;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">
								We have dedicated customer service specialists who would be delighted to help you book a private viewing.</h4>
						</div>-->
						</div>
					</td>
						<td style="width:10%;"></td>
				</tr>
				</table>
				
				<table>
					<tr>
						<td style="width:10%;"></td>
						<td style="width:80%;">
							<h2 style="color: #fff;font-size: 18px;padding: 10px 0px 0px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">
						PASSION</h2>
							<table>
								<tr><td></td></tr>
							</table>
					
							<div style= "text-align: center; clear: both;">
								<div style=" ">
									<img src="<?php echo base_url('assets/images/')?>photo-camera.png" style="height:18px">&nbsp;
									<img src="<?php echo base_url('assets/images/')?>karaoke1.png" style="height:18px">&nbsp;
									<img src="<?php echo base_url('assets/images/')?>pencil-edit-button.png" style="height:18px">&nbsp;
									<img src="<?php echo base_url('assets/images/')?>open-book.png" style="height:18px">
								</div>
							</div>
							
						</td>
						<td style="width:10%;"></td>
					</tr>
				</table>
				
			</td>
			<td width="3%"></td>
			<td width="57%" class="logo" style="text-align: left;background-color: #fff;padding-left: 20px;">
			<div>
			<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;padding-left: 10px;">PROFILE</h3>
			<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">
				<?=$encode[0]->profile->declaration?></h4>
			</div>
			<div>
				<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;">
					EDUCATION</h3>
				<?php foreach($encode[0]->education as $edu): ?>				
				<h4 style="clear: both"><?=$edu->passing_year?></h4>
				<h5 style="color: #615655;"><?=$edu->institute_name.', '.$edu->location?></h5>
				<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;"><?=$edu->description?></h4>
				<?php endforeach; ?>
			</div>
			<div>
				
				
				<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;">
					EXPERIENCE</h3>
				<?php foreach($experience as $ex): ?>
					<h4 style="clear: both"><?=$ex->from_date.'-'.$ex->to_date?></h4>
					<h5 style="color: #615655;"><?=$ex->designation?></h5>
					<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;"><?=$ex->description?></h4>
				<?php endforeach; ?>
				<!--<h4 style="clear: both">2010-2013</h4>
				<h5 style="color: #615655;">WEB DESIGN</h5>
				<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
				<h4 style="clear: both">2010-2013</h4>
				<h5 style="color: #615655;">UI DESIGN</h5>
				<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
				-->
				
				
				<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;">
					Additional Information</h3>
				<?php foreach($encode[0]->additional_info as $info): ?> 
					<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;"><?=$info->description?></h4>
				<?php endforeach; ?>
			</div>
			</td>
		</tr>
		<!-- end: tr -->
		<!-- end:tr -->
		<!-- 1 Column Text + Button : END -->
</table>
</div>