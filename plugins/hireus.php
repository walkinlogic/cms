<div class="">
<div class="footer-top">
	<div class="container">
		<div class="row">
			<?php if($pre==''){?>
				<div class="col-md-9">
					<h2><?php if($pre==''){?>Ready to provice great services?<?php }else{?>هل أنت جاهز لتقديم خدمات رائعة<?php }?></h3>
				</div>
				<div class="col-md-3"> <a href="javascript:void(0);" class="btn btn-primary btn-border d-flex justify-content-center p-t" style="padding-top: 12px; font-weight:bold;" data-toggle="modal" data-target="#hire_us_form" data-wpel-link="internal"> <?php if($pre==''){?>HIRE US<?php }else{?>استئجار لنا<?php }?></a>
				<?php  ?>
				
				</div>
			<?php }else{ ?>
				<div class="col-md-3"> <a href="javascript:void(0);" class="btn btn-primary btn-border d-flex justify-content-center p-t" style="padding-top: 12px; font-weight:bold;" data-toggle="modal" data-target="#hire_us_form" data-wpel-link="internal"> <?php if($pre==''){?>HIRE US<?php }else{?>استئجار لنا<?php }?></a> 
				</div>
				<div class="col-md-9">
					<h2><?php if($pre==''){?>Ready to provice great services?<?php }else{?>هل أنت جاهز لتقديم خدمات رائعة<?php }?></h3>
				</div>
			
			<?php } ?>
			
			</div>
		</div>
	</div> 
</div> 

<div class="modal fade popup-form member-popup" id="hire_us_form" tabindex="-1" role="dialog" style="padding-right: 17px;" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content pop-up">
      <div class="modal-body p-0">
        <div class="about-model">
          <div class="container-fluid p-0 font-normal">
            <div class="row">
              <div class="col-md-12">
                <div class="form-wrapper hire-us-form">
                  <h3><?php if($pre==''){?>HIRE US<?php }else{?>استئجار لنا<?php }?> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></h3>
                  <div role="form" class="wpcf7"> 
										
						<form action="<?php echo URL;?>hireus.php" id="hireusform" method="post" enctype="multipart/form-data">
							<?php 
									$services = $mysql->list_table("services_tbl","status = '1'", array ('range' => '*','sortColumn'=>$pre."heading",'sortType'=>'ASC'));
									?>
								<?php if(is_array($services)){?>	
									<h3 class="contact-subheading mb-2"><?php if($pre==''){?>Service<?php }else{?>الخدمات<?php }?></h3>
									<p>
										<span class="wpcf7-form-control-wrap your-service">
											<span class="wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required">
												
												<?php foreach($services as $servicepost){  ?>
												<span class="wpcf7-list-item first">
													<label>
														<input type="checkbox" name="yourservice[]" value="<?php echo $servicepost[$pre."heading"]; ?>">
														<span class="wpcf7-list-item-label"><?php echo $servicepost[$pre."heading"]; ?></span>
													</label>
												</span>
												<?php } ?>
												 
											</span>
										</span>
									</p>
							<?php } ?>
							<h3 class="contact-subheading mb-2 mt-4"><?php if($pre==''){?>Budget<?php }else{?>ميزانية<?php }?></h3>
							<p>
								<span class="wpcf7-form-control-wrap your-budget">
									<span class="wpcf7-form-control wpcf7-radio">
										<span class="wpcf7-list-item first">
											<label>
												<input type="radio" checked name="yourbudget" value="25k - 50k">
												<span class="wpcf7-list-item-label">25k - 50k</span>
											</label>
										</span>
										<span class="wpcf7-list-item">
											<label>
												<input type="radio" name="yourbudget" value="50k - 100k">
												<span class="wpcf7-list-item-label">50k - 100k</span>
											</label>
										</span>
										<span class="wpcf7-list-item">
											<label>
												<input type="radio" name="yourbudget" value="100k - 250k">
												<span class="wpcf7-list-item-label">100k - 250k</span>
											</label>
										</span>
										<span class="wpcf7-list-item last">
											<label>
												<input type="radio" name="yourbudget" value="more than 250k">
												<span class="wpcf7-list-item-label">more than 250k</span>
											</label>
										</span>
									</span>
								</span>
							</p>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label><?php if($pre==''){?>Name<?php }else{?>اسم<?php }?></label>
										<input type="text" name="yourname" class="form-control" placeholder="Full Name" />		
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?php if($pre==''){?>Email<?php }else{?>البريد الإلكتروني<?php }?> </label>
										<input type="email" name="youremail" class="form-control" placeholder="Email Address" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php if($pre==''){?>Phone<?php }else{?>هاتف<?php }?></label>
										<input type="number" name="yournumber" class="form-control" placeholder="Phone Number" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label><?php if($pre==''){?>Project Details<?php }else{?>تفاصيل المشروع<?php }?></label>
										<textarea name="yourmessage" cols="40" rows="10" class="form-control" placeholder="Please provide a brief description of your project."></textarea>
									</div>
								</div>
							</div>
							<div class="row mt-15">
								<div class="col-md-6">
									<div class="attached-btn custom-file">
									<span class="wpcf7-form-control-wrap your-file">
										<input type="file" name="yourfile" size="40" class="wpcf7-file" id="customFile-1"/>
									</span><label class="custom-file-label" for="customFile-1"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php if($pre==''){?>ADD ATTACHMENT<?php }else{?>إضافة مرفق<?php }?></label>
									</div>
								</div>
								<div class="col-md-6 text-right"> <input type="submit" value="Submit" class="btn btn-primary btn-border">
								</div>
							</div>
						</form> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
