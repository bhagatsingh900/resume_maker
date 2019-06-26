<style>
		html,
	  body {
	  margin: 0 auto !important;
	  padding: 0 !important;
	  height: 100% !important;
	  width: 100% !important;
	  background: #f1f1f1;
	  }
	  / What it does: Stops email clients resizing small text. /
	  * {
	  -ms-text-size-adjust: 100%;
	  -webkit-text-size-adjust: 100%;
	  }
	  / What it does: Centers email on Android 4.4 /
	  div[style*="margin: 16px 0"] {
	  margin: 0 !important;
	  }
	  / What it does: Stops Outlook from adding extra spacing to tables. /
	  table,
	  td {
	  mso-table-lspace: 0pt !important;
	  mso-table-rspace: 0pt !important;
	  }
	  / What it does: Fixes webkit padding issue. /
	  table {
	  border-spacing: 0 !important;
	  border-collapse: collapse !important;
	  table-layout: fixed !important;
	  margin: 0 auto !important;
	  }
	  / What it does: Uses a better rendering method when resizing images in IE. /
	  img {
	  -ms-interpolation-mode:bicubic;
	  }
	  / What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. /
	  a {
	  text-decoration: none;
	  }
	  / What it does: A work-around for email clients meddling in triggered links. /
	  [x-apple-data-detectors], / iOS */
	  .unstyle-auto-detected-links *,
	  .aBn {
	  border-bottom: 0 !important;
	  cursor: default !important;
	  color: inherit !important;
	  text-decoration: none !important;
	  font-size: inherit !important;
	  font-family: inherit !important;
	  font-weight: inherit !important;
	  line-height: inherit !important;
	  }
	  / What it does: Prevents Gmail from displaying a download button on large, non-linked images. /
	  .a6S {
	  display: none !important;
	  opacity: 0.01 !important;
	  }
	  / What it does: Prevents Gmail from changing the text color in conversation threads. /
	  .im {
	  color: inherit !important;
	  }
	  / If the above doesn't work, add a .g-img class to any image in question. /
	  img.g-img + div {
	  display: none !important;
	  }
	  / What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89 /
	  / Create one of these media queries for each additional viewport size you'd like to fix /
	  / iPhone 4, 4S, 5, 5S, 5C, and 5SE /
	  @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
	  u ~ div .email-container {
	  min-width: 320px !important;
	  }
	  }
	  / iPhone 6, 6S, 7, 8, and X /
	  @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
	  u ~ div .email-container {
	  min-width: 375px !important;
	  }
	  }
	  / iPhone 6+, 7+, and 8+ /
	  @media only screen and (min-device-width: 414px) {
	  u ~ div .email-container {
	  min-width: 414px !important;
	  }
	  }
</style>
<!-- CSS Reset : END -->
<!-- Progressive Enhancements : BEGIN -->
						<style>
						.primary{
						background: #f5564e;
						}
						.bg_white{
						background: #ffffff;
						}
						.bg_light{
						background: #fafafa;
						}
						.bg_black{
						background: #000000;
						}
						.bg_dark{
						background: #666666;
						}
						.email-section{
						padding:1.5em;
						}
						span.hobbies {
						margin-left: 5px;
						margin-right: 5px;
						}
						/*BUTTON*/
						.btn{
						padding: 5px 15px;
						display: inline-block;
						}
						.btn.btn-primary{
						border-radius: 5px;
						background: #f5564e;
						color: #ffffff;
						}
						.btn.btn-white{
						border-radius: 5px;
						background: #ffffff;
						color: #000000;
						}
						.btn.btn-white-outline{
						border-radius: 5px;
						background: transparent;
						border: 1px solid #fff;
						color: #fff;
						}
						h1,h2,h3,h4,h5,h6{
						font-family: 'Nunito Sans', sans-serif;
						color: #000000;
						margin: 0;
						}
						body{
						font-family: 'Nunito Sans', sans-serif;
						font-weight: 400;
						font-size: 15px;
						line-height: 1.8;
						color: rgba(0,0,0,.4);
						}
						a{
						color: #f5564e;
						}
						table{
						}
						/*LOGO*/
						.logo h1{
						margin: 0;
						}
						.logo h1 a{
						color: #000;
						font-size: 20px;
						font-weight: 700;
						text-transform: uppercase;
						font-family: 'Nunito Sans', sans-serif;
						}
						.navigation{
						padding: 0;
						}
						.navigation li{
						list-style: none;
						display: inline-block;;
						margin-left: 5px;
						font-size: 12px;
						font-weight: 700;
						text-transform: uppercase;
						}
						.navigation li a{
						color: rgba(0,0,0,.6);
						}
						/*HERO*/
						.hero{
						position: relative;
						z-index: 0;
						}
						.hero .icon{
						}
						.hero .icon a{
						display: block;
						width: 60px;
						margin: 0 auto;
						}
						.hero .text{
						color: rgba(255,255,255,.8);
						padding: 0 4em;
						}
						.hero .text h2{
						color: #ffffff;
						font-size: 40px;
						margin-bottom: 0;
						line-height: 1.2;
						font-weight: 900;
						}
						/*HEADING SECTION*/
						.heading-section{
						}
						.heading-section h2{
						color: #000000;
						font-size: 24px;
						margin-top: 0;
						line-height: 1.4;
						font-weight: 700;
						}
						.heading-section .subheading{
						margin-bottom: 20px !important;
						display: inline-block;
						font-size: 13px;
						text-transform: uppercase;
						letter-spacing: 2px;
						color: rgba(0,0,0,.4);
						position: relative;
						}
						.heading-section .subheading::after{
						position: absolute;
						left: 0;
						right: 0;
						bottom: -10px;
						content: '';
						width: 100%;
						height: 2px;
						background: #f5564e;
						margin: 0 auto;
						}
						.heading-section-white{
						color: rgba(255,255,255,.8);
						}
						.heading-section-white h2{
						font-family: 
						line-height: 1;
						padding-bottom: 0;
						}
						.heading-section-white h2{
						color: #ffffff;
						}
						.heading-section-white .subheading{
						margin-bottom: 0;
						display: inline-block;
						font-size: 13px;
						text-transform: uppercase;
						letter-spacing: 2px;
						color: rgba(255,255,255,.4);
						}
						.icon{
						text-align: center;
						}
						.icon img{
						}
						/*SERVICES*/
						.services{
						background: rgba(0,0,0,.03);
						}
						.text-services{
						padding: 10px 10px 0; 
						text-align: center;
						}
						.text-services h3{
						font-size: 16px;
						font-weight: 600;
						}
						.services-list{
						padding: 0;
						margin: 0 0 10px 0;
						width: 100%;
						float: left;
						}
						.services-list .text{
						width: 100%;
						float: right;
						}
						.services-list h3{
						margin-top: 0;
						margin-bottom: 0;
						font-size: 18px;
						}
						.services-list p{
						margin: 0;
						}
						/*DESTINATION*/
						.text-tour{
						padding-top: 10px;
						}
						.text-tour h3{
						margin-bottom: 0;
						}
						.text-tour h3 a{
						color: #000;
						}
						/*BLOG*/
						.text-services .meta{
						text-transform: uppercase;
						font-size: 14px;
						}
						/*TESTIMONY*/
						.text-testimony .name{
						margin: 0;
						}
						.text-testimony .position{
						color: rgba(0,0,0,.3);
						}
						/*COUNTER*/
						.counter{
						width: 100%;
						position: relative;
						z-index: 0;
						}
						.counter .overlay{
						position: absolute;
						top: 0;
						left: 0;
						right: 0;
						bottom: 0;
						content: '';
						width: 100%;
						background: #000000;
						z-index: -1;
						opacity: .3;
						}
						.counter-text{
						text-align: center;
						}
						.counter-text .num{
						display: block;
						color: #ffffff;
						font-size: 34px;
						font-weight: 700;
						}
						.counter-text .name{
						display: block;
						color: rgba(255,255,255,.9);
						font-size: 13px;
						}
						ul.social{
						padding: 0;
						}
						ul.social li{
						display: inline-block;
						}
						.dot {
						height: 10px;
						width: 10px;
						background-color: #c3a297;
						border-radius: 50%;
						display: inline-block;
						}
						.dot1 {
						height: 8px;
						width: 8px;
						border:solid 1px #fff;
						border-radius: 50%;
						display: inline-block;
						}
						/*FOOTER*/
						.footer{
						color: rgba(255,255,255,.5);
						}
						.footer .heading{
						color: #ffffff;
						font-size: 20px;
						}
						.footer ul{
						margin: 0;
						padding: 0;
						}
						.footer ul li{
						list-style: none;
						margin-bottom: 10px;
						}
						.footer ul li a{
						color: rgba(255,255,255,1);
						}
						@media screen and (max-width: 500px) {
						.icon{
						text-align: left;
						}
						.text-services{
						padding-left: 0;
						padding-right: 20px;
						text-align: left;
						}
						}
</style>
						
						
						
<div style="max-width: 700px; margin: 0 auto;" class="email-container"> 
<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
<tr style="background-color: #615655;" height="50px">

<td width="100%" style="text-align: center;height: 50px">
<h4 style="color: #fff;font-size: 26px;letter-spacing:2px;">JOHN DEVID </h4>
</td>
</tr>
<tr style="background-color: #615655;" height="50px">

<td width="20%" style="text-align: center;">

</td>
<td width="60%" style="text-align: center;">

<h5 style="color: #fff;width: 300px;margin: auto;border: solid 1px #fff;font-size: 14">MARKETING EXECUTIVE</h5>
</td>
<td width="20%" class="logo" style="text-align: center;">
</td>
</tr>
<!-- end tr -->
<tr>
<td width="40%" class="logo" style="text-align: center;background-color: #615655;">
<h2 style="color: #fff;font-size: 18px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">CONTACT</h2>
<div style="text-align: center;clear: both;padding-top: 10px;">
<img src="<?php echo base_url('assets/images/')?>user.png" style="vertical-align: middle;width:100%">
<h4 style="color: #fff;font-weight: 500;font-size: 16px;">
&nbsp; Sample Your Name
</h4>
<img src="<?php echo base_url('assets/images/')?>email.png" style="vertical-align: middle;">
<h4 style="color: #fff;font-weight: 500;font-size: 16px;">&nbsp; user@gmail.com </h4>
<img src="<?php echo base_url('assets/images/')?>call.png" style="vertical-align: middle;">
<h4 style="color: #fff;font-weight: 500;font-size: 16px;">&nbsp;   +91-9865574433  </h4>
<img src="<?php echo base_url('assets/images/')?>address.png" style="vertical-align: middle;">
<h4 style="color: #fff;font-weight: 500;font-size: 16px;">&nbsp;<span style="">Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016</span></h4>
</div>
<h2 style="color: #fff;font-size: 18px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">AWARDS</h2>
<div style="text-align: left;">
<div style="text-align: center;">
<h5 style="color: #fff;font-weight: 500"><a href="#" style="font-size: 16px;color: #fff;vertical-align: middle;"><span style="font-size: 14px;">GRAPHICS DESIGN</span></a>
</h5>
<h4 style="color: #fff;font-weight: 500;font-size: 16px;">MARKETING AXECUTIVE AWARDS</h4>
<h4 style="clear:both;margin-top: 0px;color: #fff;font-family: initial;font-weight: 400 !important;font-size: 14px;">
	We have dedicated customer service specialists who would be delighted to help you book a private viewing.</h4>
</div>
<div style="text-align: center;">
<h5 style="color: #fff;font-weight: 500"><span style="font-size: 14px;">GRAPHICS DESIGN</span>
</h5>
<h4 style="color: #fff;font-weight: 400;font-size: 16px">MARKETING AXECUTIVE AWARDS</h4>
<h4 style="clear:both;margin-top: 0px;color: #fff;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">
	We have dedicated customer service specialists who would be delighted to help you book a private viewing.</h4>
</div>
</div>
<h2 style="color: #fff;font-size: 18px;padding: 10px 0px 0px;font-weight: 400 !important;border-bottom: solid 1px #ffffff;width: 80%;margin: auto;">PASSION</h2>
<div style="text-align: center;padding-left: 10px;clear: both;">
<div style="padding-top: 20px;">
<img src="<?php echo base_url('assets/images/')?>photo-camera.png" style="height:25px">&nbsp;
<img src="<?php echo base_url('assets/images/')?>karaoke1.png" style="height:25px">&nbsp;
<img src="<?php echo base_url('assets/images/')?>pencil-edit-button.png" style="height:25px">&nbsp;
<img src="<?php echo base_url('assets/images/')?>open-book.png" style="height:25px">
</div>
</div>
</td>
<td width="3%"></td>
<td width="57%" class="logo" style="text-align: left;background-color: #fff;padding-left: 20px;">
<div>
<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;padding-left: 10px;">PROFILE</h3>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">
	We have dedicated customer service specialists who would be delighted to help you book a private viewing.</h4>
</div>
<div>
<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;">EDUCATION</h3>
<h4 style="clear: both">2010-2013</h4>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
<h4 style="clear: both">2010-2013</h4>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
</div>
<div>
	
	
	
	
<h3 style="color: #000; padding: 0px 0px;margin-top: 0px;border-bottom: solid 1px #615655;width: 90%;">EXPERIENCE</h3>
<h4 style="clear: both">2010-2013</h4>
<h5 style="color: #615655;">GRAPHICS DESIGN</h5>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
<h4 style="clear: both">2010-2013</h4>
<h5 style="color: #615655;">WEB DESIGN</h5>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
<h4 style="clear: both">2010-2013</h4>
<h5 style="color: #615655;">UI DESIGN</h5>
<h4 style="clear:both;margin-top: 0px;color: #1b2324;line-height: 20px;padding-top: 10px;font-family: initial;font-weight: 400 !important;font-size: 14px;">We have dedicated customer service specialists who would be delighted to help you.</h4>
</div>
</td>
</tr>
<!-- end: tr -->
<!-- end:tr -->
<!-- 1 Column Text + Button : END -->
</table>
</div>