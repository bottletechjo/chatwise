<?php 
	$this->load->view("include/upload_js"); 

	$image_upload_limit = 1; 
	if($this->config->item('facebook_poster_image_upload_limit') != '')
	$image_upload_limit = $this->config->item('facebook_poster_image_upload_limit'); 

	$video_upload_limit = 10; 
	if($this->config->item('facebook_poster_video_upload_limit') != '')
	$video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');
?>

<style type="text/css">
	.card{margin-bottom:0;border-radius: 0;}
	.main_card{box-shadow: none !important;height: 100%;}
	.card .card-header input{max-width: 100% !important;}
	.card .card-header h4 a{font-weight: 700 !important;}
	::placeholder{color: white !important;}
	.full-documentation{cursor: pointer;}
	.input-group-prepend{margin-left:-1px;}
	.input-group-text{background: #eee;}
	.padding-20{padding: 20px}
	.slide_content_block_common{ padding:20px;margin-bottom:20px; }
	.slide_content_block_d_none,.video_content_block_d_none{display: none;}
	.schedule_block_item label,label{color:#34395e !important;font-size:12px !important;font-weight:600 !important;letter-spacing: .5px !important;}
	.card-body	#tab_contents{ border:solid 1px #dee2e6;border-top:0;padding:30px 20px 30px 20px; }
</style>


<section class="section section_custom">
	<div class="section-header">
		<h1><i class="fas fa-video"></i> <?php echo $page_title; ?></h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item"><a href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a></div>
			<div class="breadcrumb-item"><a href='<?php echo base_url("ultrapost/carousel_slider_post"); ?>'><?php echo $this->lang->line("Carousel/Slider Posts"); ?></a></div>
			<div class="breadcrumb-item"><?php echo $page_title; ?></div>
		</div>
	</div>
	
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card main_card">
					<div class="card-header" style="border-bottom: 0;padding-bottom:0 !important;">
						<ul class="nav nav-tabs" role="tablist" style="width:100% !important;margin-bottom:-7px;">
							<li class="nav-item">
								<a id="slider_post" class="nav-link post_type active" data-toggle="tab" href="#" role="tab" aria-selected="false"><i class="fa fa-file-image-o"></i> <?php echo $this->lang->line('Carousel') ?></a>
							</li>              
							<li class="nav-item">
								<a id="video_post" class="nav-link post_type" data-toggle="tab" href="#" role="tab" aria-selected="true"><i class="fa fa-video-camera"></i> <?php echo $this->lang->line("Video Slide Show") ?></a>
							</li>

						</ul>
					</div>
		          	<div class="card-body" style="padding-top:0 !important;">
						<div id="tab_contents">
							<form action="#" enctype="multipart/form-data" id="video_slider_form" method="post">
								<!-- common for carousel and video slider -->
								<input type="hidden" name="auto_reply_template" id="auto_reply_template" value="0">
								<div class="row" id="common_block">
									<div class="col-12 col-md-6">
										<div class="form-group">
											<div class="form-group">
												<label><?php echo $this->lang->line('Campaign Name'); ?> <span class="red">*</span></label>
												<input class="form-control" name="campaign_name" id="campaign_name" />
											</div>
										</div>
									</div>

									<div class="col-12 col-md-6">
										<div class="form-group">
											<label><?php echo $this->lang->line('Post to pages'); ?> <span class="red">*</span></label>
											<select multiple class="form-control select2" id="post_to_pages" name="post_to_pages[]" style="width:100%;">	
											<?php
												foreach($fb_page_info as $key=>$val)
												{	
													$id=$val['id'];
													$page_name=$val['page_name'];
													echo "<option value='{$id}'>{$page_name}</option>";								
												}
											 ?>						
											</select>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group" style="display: none;">
											 <?php 
											 	$facebook_rx_fb_user_info_id=isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0; 
											 	$facebook_rx_fb_user_info_name=isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : ""; 
											 	$facebook_rx_fb_user_info_access_token=isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : ""; 
											 ?>
											<label><?php echo $this->lang->line('Post to timeline/pages'); ?></label><br/>
											<input name="post_to_profile" value="<?php echo $facebook_rx_fb_user_info_id;?>" id="post_to_profile_yes"  type="radio"> <?php echo $this->lang->line('Post to timeline'); ?> (<?php echo $facebook_rx_fb_user_info_name;?>) &nbsp;&nbsp;
											<input name="post_to_profile" value="No" id="post_to_profile_no" type="radio" checked> <?php echo $this->lang->line('No, don\'t post'); ?>
										</div>
									</div>
								</div>
								<!-- End common for carousel and video slider -->

								<!-- carousel block -->
								<div class="row" id="slider_block">
									<div class="col-12">
										<div class="card card-primary" id="slider_content">
											<div class="card-header"><h4><?php echo $this->lang->line('Carousel'); ?></h4></div>
											
											<div class="card-body">
												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label><?php echo $this->lang->line('Slider Link'); ?> <span class="red">*</span></label>
															<input type="text" class="form-control" name="slider_link" id="slider_link" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
														</div>
													</div>
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label><?php echo $this->lang->line('Message'); ?></label>
															<a href="#" data-placement="right"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='fa fa-info-circle'></i> </a>
															<textarea class="form-control" name="slider_message" id="slider_message" placeholder="<?php echo $this->lang->line('Type your status here...'); ?>"></textarea>
														</div>
													</div>
												</div>

												<div class="card card-secondary">
													<div id="slider_content_1">
														<div class="card">
															<div class="card-header">
																<h4><?php echo $this->lang->line('Slider Content 1:'); ?></h4>
															</div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Title'); ?></label>
																			<input type="text" class="form-control" name="post_title_1" id="post_title_1" placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Action Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_link_1" id="post_link_1" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
																		</div>
																	</div>								
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Description'); ?></label>
																			<textarea style="min-height:130px;" class="form-control" name="post_description_1" id="post_description_1" placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_image_link_1" id="post_image_link_1" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload image'); ?></label>
																			<div id="post_image_1"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="slide_content_block_d_none" id="slider_conten_2">
														<div class="card">
															<div class="card-header">
																<h4><?php echo $this->lang->line('Slider Content 2:'); ?></h4>
															</div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-sm-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Title'); ?></label>
																			<input type="text" class="form-control" name="post_title_2" id="post_title_2" placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Action Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_link_2" id="post_link_2" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Description'); ?></label>
																			<textarea style="min-height:130px;" class="form-control" name="post_description_2" id="post_description_2" placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_image_link_2" id="post_image_link_2" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload image'); ?></label>
																			<div id="post_image_2"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>								
													</div>

													<div class="slide_content_block_d_none" id="slider_conten_3">
														<div class="card">
															<div class="card-header">
																<h4><?php echo $this->lang->line('Slider Content 3:'); ?></h4>
															</div>

															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Title'); ?></label>
																			<input type="text" class="form-control" name="post_title_3" id="post_title_3" placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Action Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_link_3" id="post_link_3" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Description'); ?></label>
																			<textarea style="min-height:130px;" class="form-control" name="post_description_3" id="post_description_3" placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_image_link_3" id="post_image_link_3" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload image'); ?></label>
																			<div id="post_image_3"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>					
													</div>

													<div class="slide_content_block_d_none" id="slider_conten_4">
														<div class="card">
															<div class="card-header">
																<h4><?php echo $this->lang->line('Slider Content 4:'); ?></h4>
															</div>

															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Title'); ?></label>
																			<input type="text" class="form-control" name="post_title_4" id="post_title_4" placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Action Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_link_4" id="post_link_4" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Description'); ?></label>
																			<textarea style="min-height:130px;" class="form-control" name="post_description_4" id="post_description_4" placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
																		</div>
																	</div>
																	<div class="col-12 col-sm-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_image_link_4" id="post_image_link_4" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload image'); ?></label>
																			<div id="post_image_4"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>	
															</div>
														</div>					
													</div>

													<div class="slide_content_block_d_none" id="slider_conten_5">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Slider Content 5:'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-sm-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Title'); ?></label>
																			<input type="text" class="form-control" name="post_title_5" id="post_title_5" placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-sm-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Action Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_link_5" id="post_link_5" placeholder="<?php echo $this->lang->line('Type link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Description'); ?></label>
																			<textarea style="min-height:130px;" class="form-control" name="post_description_5" id="post_description_5" placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
																		</div>
																	</div>
																	<div class="col-12 col-sm-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?> <span class="red">*</span></label>
																			<input type="text" class="form-control" name="post_image_link_5" id="post_image_link_5" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload image'); ?></label>
																			<div id="post_image_5"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>							
													</div>
												</div>

												<div class="clearfix">
													<p class="btn btn-outline-primary float-right mt-2" id="add_more"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('Add More Content'); ?></p>
												</div>
											</div>
										</div> <!-- card card-primary end -->
									</div>
								</div>
								<!-- end of carousel block -->

								<!-- Video block -->
								<div class="row" id="video_block">
									<div class="col-12">
										<div class="card card-primary" id="video_content">
											<div class="card-header"><h4><?php echo $this->lang->line('Video-Slide'); ?></h4></div>
											<div class="card-body">

												<div class="row">
													<div class="col-12">
														<div class="form-group">
															<label><?php echo $this->lang->line('Message'); ?></label>
															<a href="#" data-placement="right"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='fa fa-info-circle'></i> </a>
															<textarea class="form-control" name="video_message" id="video_message" placeholder="<?php echo $this->lang->line('Type your message here...'); ?>"></textarea>
														</div>
													</div>

													<div class="col-12 col-md-6">
														<div class="form-group">
															<label><?php echo $this->lang->line('Image Duration (second)'); ?></label>
															<select class="form-control select2" id="video_image_duration" name="video_image_duration" style="width:100%;">	
																<option value="1"><?php echo $this->lang->line('1 sec'); ?></option>	
																<option value="2"><?php echo $this->lang->line('2 sec'); ?></option>
																<option value="3"><?php echo $this->lang->line('3 sec'); ?></option>
																<option value="4"><?php echo $this->lang->line('4 sec'); ?></option>
																<option value="5"><?php echo $this->lang->line('5 sec'); ?></option>
															</select>
														</div>
													</div>

													<div class="col-12 col-md-6">
														<div class="form-group">
															<label><?php echo $this->lang->line('Transition Duration (second)'); ?></label>
															<select class="form-control select2" id="video_image_transition_duration" name="video_image_transition_duration" style="width:100%;">	
																<option value="1"><?php echo $this->lang->line('1 sec'); ?></option>
																<option value="2"><?php echo $this->lang->line('2 sec'); ?></option>
																<option value="3"><?php echo $this->lang->line('3 sec'); ?></option>
																<option value="4"><?php echo $this->lang->line('4 sec'); ?></option>
																<option value="5"><?php echo $this->lang->line('5 sec'); ?></option>		
															</select>
														</div>
													</div>
												</div>
												
												<div class="card card-secondary">
													<div id="video_image_div_1">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 1 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_1" id="video_image_link_1" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_1"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_2">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 2 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_2" id="video_image_link_2" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_2"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_3">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 3 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_3" id="video_image_link_3" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_3"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_4">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 4 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_4" id="video_image_link_4" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_4"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_5">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 5 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_5" id="video_image_link_5" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_5"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_6">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 6 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_6" id="video_image_link_6" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_6"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="video_content_block_d_none" id="video_image_div_7">
														<div class="card">
															<div class="card-header"><h4><?php echo $this->lang->line('Image Content 7 :'); ?></h4></div>
															<div class="card-body">
																<div class="row">
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Image Link'); ?></label>
																			<input type="text" class="form-control" name="video_image_link_7" id="video_image_link_7" placeholder="<?php echo $this->lang->line('Type image link here...'); ?>" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label><?php echo $this->lang->line('Upload Image'); ?></label>
																			<div id="video_images_7"><?php echo $this->lang->line('Upload'); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="clearfix">
														<p class="btn btn-outline-primary float-right mt-2" id="add_more_video_image"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('Add More Image'); ?></p>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
								<!-- end of video block -->

								<!-- schedule block -->
								<div class="row" id="posting_schedule_block">
									<div class="col-6 padding-20">
										<div class="form-group">
											<label><?php echo $this->lang->line("Posting Time") ?>
												<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Posting Time") ?>" data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i class='fa fa-info-circle'></i> </a>
											</label>
											<br>
										  	<label class="custom-switch mt-2">
												<input type="checkbox" name="schedule_type" value="now" id="schedule_type" class="custom-switch-input" checked>
												<span class="custom-switch-indicator"></span>
												<span class="custom-switch-description"><?php echo $this->lang->line('Post Now');?></span>
										  	</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="schedule_block_item col-12 col-md-6">
										<div class="form-group">
											<label><?php echo $this->lang->line('Schedule time'); ?></label>
											<input placeholder="<?php echo $this->lang->line('Time'); ?>"  name="schedule_time" id="schedule_time" class="form-control datepicker_x" type="text"/>
										</div>
									</div>

									<div class="schedule_block_item col-12 col-md-6">
										<div class="form-group">
											<label><?php echo $this->lang->line('Time zone'); ?></label>
											<?php
											$time_zone[''] = 'Please Select';
											echo form_dropdown('time_zone',$time_zone,$this->config->item('time_zone'),' class="form-control select2" id="time_zone" required style="width:100%;"'); 
											?>
										</div>
									</div>

									<div class=" schedule_block_item col-12 col-md-6">
										<div class="input-group">
										  	<label class="input-group-addon"><?php echo $this->lang->line('repost this post'); ?></label>
										  	<div class="input-group">
					                          	<input type="number" class="form-control" name="repeat_times" id="repeat_times" aria-describedby="basic-addon2">
					                          	<div class="input-group-prepend">
						                            <div class="input-group-text"><?php echo $this->lang->line('Times'); ?></div>
					                          	</div>
				                        	</div>
										</div>								  	
									</div>

									<div class="col-12 col-md-6">
										<div class="schedule_block_item">
											<div class="form-group">
												<label><?php echo $this->lang->line('time interval'); ?></label>
												<?php
													$time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
													echo form_dropdown('time_interval',$time_interval,set_value('time_interval'),' class="form-control select2" id="time_interval" required style="width:100%;"');
												?>
											</div>
										</div>
									</div>
								</div>
								<!-- end of schedule block -->

								<div class="clearfix"></div>

								<input type="hidden" name="content_counter" id="content_counter" />
								<input type="hidden" name="video_content_counter" id="video_content_counter" />
								<input type="hidden" name="content_type" id="content_type" />
							</form>

							<div class="card-footer padding-0">
								<button class="btn btn-lg btn-primary" submit_type="slider_submit" id="submit_post" type="button"><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?> </button>
								<a class="btn btn-lg btn-light float-right" onclick='goBack("ultrapost/carousel_slider_post",0)'><i class="fas fa-times"></i> <?php echo $this->lang->line("Cancel") ?> </a>
							</div>
						</div>
			        </div>
	          	</div>          
	        </div>
		</div>
	</div>
</section>


<script type="text/javascript">
	$('[data-toggle="popover"]').popover(); 
	$('[data-toggle="popover"]').on('click', function(e) {e.preventDefault(); return true;});
</script>

<script>
	$("document").ready(function(){
	
	$("#video_message, #slider_message").emojioneArea({
        	autocomplete: false,
			pickerPosition: "bottom",
			//hideSource: false,
     	 });

	var today = new Date();
	var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
	$('.datepicker_x').datetimepicker({
		theme:'light',
		format:'Y-m-d H:i:s',
		formatDate:'Y-m-d H:i:s',
		minDate: today,
		maxDate: next_date

	})
		 

		var base_url = "<?php echo base_url(); ?>";

		var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
		if(makeScheduleValEmptyifscheduleisNow == 'now') $("#schedule_time").val("");


		var content_counter = 1;
		$("#content_counter").val(content_counter);
		$("#add_more").click(function(){
			content_counter++;
			if(content_counter == 5)
				$("#add_more").hide();
			$("#content_counter").val(content_counter);

			$("#slider_conten_"+content_counter).show();

		});


        $("#video_block,.auto_share_post_block_item,.auto_comment_block_item,.auto_reply_block_item,.schedule_block_item,.preview_video_block,.preview_img_block").hide();
 
        $(document).on('change','input[name=auto_share_post]',function(){    
        	if($("input[name=auto_share_post]:checked").val()=="1")
        	$(".auto_share_post_block_item").show();
        	else $(".auto_share_post_block_item").hide();
        });  

        $(document).on('change','input[name=auto_private_reply]',function(){    
        	if($("input[name=auto_private_reply]:checked").val()=="1")
        	$(".auto_reply_block_item").show();
        	else $(".auto_reply_block_item").hide();
        }); 

        $(document).on('change','input[name=schedule_type]',function(){

        	var scheduletype = $("input[name=schedule_type]:checked").val();

        	if(typeof(scheduletype)=="undefined")
        		$(".schedule_block_item").show();
        	else 
        	{
        		$("#schedule_time").val("");
        		$("#time_zone").val("");
        		$("#repeat_times").val("");
        		$("#time_interval").val("");
        		$(".schedule_block_item").hide();
        	}
        }); 

        $(document).on('change','input[name=auto_comment]',function(){    
        	if($("input[name=auto_comment]:checked").val()=="1")
        	$(".auto_comment_block_item").show();
        	else $(".auto_comment_block_item").hide();
        });

		

        $(document).on('click','.post_type',function(){ 
  
        	var post_type=$(this).attr("id");

        	if(post_type=="video_post")
        	{
        		$("#slider_block").hide();
        		$("#video_block").show();
        		$('.post_type').removeClass("active");
        		$('#submit_post').attr("submit_type","video_submit");
        	}
        	else if(post_type=="slider_post")
        	{
        		$("#video_block").hide();
        		$("#slider_block").show();
        		$('.post_type').removeClass("active");
        		$('#submit_post').attr("submit_type","slider_submit");
        	}

        	$(this).addClass("active");
        });


        $("#submit_post").click(function(){

        	// var campaign_name = $("#campaign_name").val().trim();
        	// if(campaign_name == '')
        	// {
        	// 	alert("Campaign Name is required");
        	// 	return;
        	// }

        	var content_type = $(this).attr('submit_type');
        	$("#content_type").val(content_type);

        	if(content_type == 'slider_submit')
        	{
        		// var slider_message = $("#slider_message").val().trim();
        		// if(slider_message == ''){
        		// 	alert('Message is required for slider posting.');
        		// 	return;
        		// }

        		var image_link_counter = 0;

        		for(var i=1; i<=5; i++)
        		{
        			var slider_image_link = $("#post_image_link_"+i).val().trim();
        			if(slider_image_link != '')
        				image_link_counter++;
        		}

        		if(image_link_counter < 2)
        		{
        			swal('<?php echo $this->lang->line("Warning"); ?>',"<?php echo $this->lang->line('Please provide atleast two images and corresponding information.');?>", 'warning');
	        		return;
        		}
        	}
        	else
        	{
        		// var video_message = $("#video_message").val().trim();
        		// if(video_message == ''){
        		// 	alert('Message is required for video posting.');
        		// 	return;
        		// }

        		var video_image_counter = 0;

        		for(var i=1; i<=7; i++)
        		{
        			var video_image_link = $("#video_image_link_"+i).val().trim();
        			if(video_image_link != '')
        				video_image_counter++;
        		}

        		if(video_image_counter < 3)
        		{
        			swal('<?php echo $this->lang->line("Warning"); ?>',"<?php echo $this->lang->line('Please provide atleast three images and corresponding information.');?>", 'warning');
	        		return;
        		}

        	}

        	var post_to_profile = $("input[name=post_to_profile]:checked").val();
        	var post_to_pages = $("#post_to_pages").val();
        	if(typeof(post_to_pages) =='undefined' || post_to_pages == "")
        	{
        		swal('<?php echo $this->lang->line("Warning"); ?>',"<?php echo $this->lang->line('Please select pages to publish this post.');?>", 'warning');
        		return;
        	}

        	var schedule_type = $("input[name=schedule_type]:checked").val();
        	var schedule_time = $("#schedule_time").val();
        	var time_zone = $("#time_zone").val();
        	if(typeof(schedule_type)=='undefined' && (schedule_time=="" || time_zone==""))
        	{
        		swal('<?php echo $this->lang->line("Warning"); ?>',"<?php echo $this->lang->line('Please select schedule time/time zone.');?>", 'warning');
        		return;
        	}

        	$(this).addClass('btn-progress')
        	var that = $(this);

        	var queryString = new FormData($("#video_slider_form")[0]);
		    $.ajax({
		    	type:'POST' ,
		    	url: base_url+"ultrapost/carousel_slider_add_post_action",
		    	data: queryString,
		    	dataType : 'JSON',
		    	// async: false,
		    	cache: false,
		    	contentType: false,
		    	processData: false,
		    	success:function(response){
		    		$(that).removeClass('btn-progress');
		    		var report_link="<a href='"+base_url+"ultrapost/carousel_slider_post'> <?php echo $this->lang->line('Click here to see report'); ?></a>";

		         	if(response.status=="1")
			        {
			        	var span = document.createElement("span");
			        	span.innerHTML = report_link;
			        	swal({ title:response.message, content:span,icon:'success'});

			        }
			        else
			        {
			        	var span = document.createElement("span");
			        	span.innerHTML = report_link;
			        	swal({ title:response.message, content:span,icon:'error'});
			        }
		    	}

		    });
        });

		var image_upload_limit = "<?php echo $image_upload_limit; ?>";
		var video_upload_limit = "<?php echo $video_upload_limit; ?>";

        $("#post_image_1").uploadFile({
	        url:base_url+"ultrapost/carousel_slider_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: true,
	        multiple:false,
	        maxFileCount:1, 
	        acceptFiles:".png,.jpg,.jpeg",
	        deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) {
                    	$("#post_image_link_1").val('');                    
                    });
	           
	         },
	         onSuccess:function(files,data,xhr,pd)
	           {
	               var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	               $("#post_image_link_1").val(data_modified);		
	           }
	    });



	    $("#post_image_2").uploadFile({
	        url:base_url+"ultrapost/carousel_slider_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: true,
	        multiple:false,
	        maxFileCount:1, 
	        acceptFiles:".png,.jpg,.jpeg",
	        deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) {
                    	$("#post_image_link_2").val('');                    
                    });
	           
	         },
	         onSuccess:function(files,data,xhr,pd)
	           {
	               var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	               $("#post_image_link_2").val(data_modified);		
	           }
	    });


	    $("#post_image_3").uploadFile({
	        url:base_url+"ultrapost/carousel_slider_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: true,
	        multiple:false,
	        maxFileCount:1, 
	        acceptFiles:".png,.jpg,.jpeg",
	        deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) {
                    	$("#post_image_link_3").val('');                    
                    });
	           
	         },
	         onSuccess:function(files,data,xhr,pd)
	           {
	               var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	               $("#post_image_link_3").val(data_modified);		
	           }
	    });


	    $("#post_image_4").uploadFile({
	        url:base_url+"ultrapost/carousel_slider_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: true,
	        multiple:false,
	        maxFileCount:1, 
	        acceptFiles:".png,.jpg,.jpeg",
	        deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) {
                    	$("#post_image_link_4").val('');                    
                    });
	           
	         },
	         onSuccess:function(files,data,xhr,pd)
	           {
	               var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	               $("#post_image_link_4").val(data_modified);		
	           }
	    });


	    $("#post_image_5").uploadFile({
	        url:base_url+"ultrapost/carousel_slider_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: true,
	        multiple:false,
	        maxFileCount:1, 
	        acceptFiles:".png,.jpg,.jpeg",
	        deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) {
                    	$("#post_image_link_5").val('');                    
                    });
	           
	         },
	         onSuccess:function(files,data,xhr,pd)
	           {
	               var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	               $("#post_image_link_5").val(data_modified);		
	           }
	    });




	    var video_content_counter = 1;
		$("#video_content_counter").val(video_content_counter);
		$("#add_more_video_image").click(function(){
			video_content_counter++;
			if(video_content_counter == 7)
				$("#add_more_video_image").hide();
			$("#video_content_counter").val(video_content_counter);

			$("#video_image_div_"+video_content_counter).show();

		});



	    $("#video_images_1").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_1").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_1").val(data_modified);		
	        }

		});

		$("#video_images_2").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_2").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_2").val(data_modified);		
	        }

		});

		$("#video_images_3").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_3").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_3").val(data_modified);		
	        }

		});

		$("#video_images_4").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_4").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_4").val(data_modified);		
	        }

		});

		$("#video_images_5").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_5").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_5").val(data_modified);		
	        }

		});

		$("#video_images_6").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_6").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_6").val(data_modified);		
	        }

		});

		$("#video_images_7").uploadFile({
			url:base_url+"ultrapost/carousel_slider_upload_image_only",
			fileName:"myfile",
			maxFileSize:image_upload_limit*1024*1024,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
	        maxFileCount:1,
			acceptFiles:".png,.jpg,.jpeg",
			deleteCallback: function (data, pd) {
	            var delete_url="<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete",name: data},
                    function (resp,textStatus, jqXHR) { 
                    	$("#video_image_link_7").val("");                  
                    });
	           
	        },
	        onSuccess:function(files,data,xhr,pd)
	        {
	        	var data_modified = base_url+"upload_caster/carousel_slider/"+data;
	        	$("#video_image_link_7").val(data_modified);		
	        }

		});
	

       	
    });
</script>


<div class="modal fade" id="slider_response_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $this->lang->line('Auto Post Campaign Status'); ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="alert text-center" id="slider_response_modal_content">
					
				</div>
			</div>
		</div>
	</div>
</div>



<style type="text/css" media="screen">
	.padding-5{padding:5px;}
	.padding-20{padding:20px;}
	.box-body,.box-footer{padding:30px;}
	.box-header{padding-left: 30px;}
	.preview
	{
		font-family: helvetica,​arial,​sans-serif;
		padding: 20px;
	}
	.preview_cover_img
	{
		width:45px;
		height:45px;
		border: .5px solid #ccc;
	}
	.preview_page
	{
		padding-left: 7px;
		color: #365899;
		font-weight: 700;
		font-size: 14px;
		cursor: pointer;
	}
	.preview_page_sm
	{
		padding-left: 7px;
		padding-top: 7px;
		color: #9197a3;
		font-size: 13px;
		font-weight: 300;
		cursor: pointer;
	}
	.preview_img
	{
		width:100%;
		border: 1px solid #ccc;
		border-bottom: none;
		cursor: pointer;
	}	
	.demo_preview
	{
		width:100%;
		border-bottom: none;
		margin-top: 10px;
		cursor: pointer;
	}	
	.preview_og_info
	{
		border: 1px solid #ccc;
		box-shadow: 0px 0px 2px #ddd;
		-webkit-box-shadow: 0px 0px 2px #ddd;
		-moz-box-shadow: 0px 0px 2px #ddd;
		padding: 10px;
		cursor: pointer;

	}
	.preview_og_info_title
	{
		font-size: 23px;
		font-weight: 400;
		font-family: 'Times New Roman',helvetica,​arial;
		
	}
	.preview_og_info_desc
	{
		margin-top: 5px;
		font-size: 13px;
	}
	.preview_og_info_link
	{
		text-transform: uppercase;
		color: #9197a3;
		margin-top: 7px;
	}
	.post_type
	{
		padding: 10px 12px;
		border: 1px solid <?php echo $THEMECOLORCODE;?>;
		font-weight: bold;
		color: <?php echo $THEMECOLORCODE;?>;
		margin-right: 2px;
	}
	.post_type.active
	{
		background: <?php echo $THEMECOLORCODE;?>;
		color: #fff;
	}
	.ms-choice span
	{
		padding-top: 2px !important;
	}
	.hidden
	{
		display: none;
	}
	.well
	{
		background: #fafafa;
	}

	.content-wrapper{background: #fcfcfc;}
	.ajax-upload-dragdrop{width:100% !important;padding:0 !important;border:none !important;}
</style>