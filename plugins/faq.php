<?php 
$Testimonial = $mysql->list_table("faqs_tbl","status = '1'", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
$i=1;
if($mysql->affected_rows>0){
?>
 	
	
	
<div id="design-testimony" class="designlightgrey faq">
	<div class="container">
		<div class="row">
			<div class="col-md-4 animate-box design-heading animate-box">
				  <h2><span class="thick"><?php if($pre==''){?>Frequently Asked Questions<?php }else{ ?>أسئلة مكررة<?php } ?></span></h2>  
			</div>
			<div class="col-md-7 col-md-push-1"> 
			 
			
				<div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
				<?php foreach($Testimonial as $post){ ?>
				 <div class="card">
					<div class="card-header" role="tab" id="headingOne<?php echo $i;?>">
					  <h5 class="mb-0 panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i;?>" class="">
						  <?php echo stripslashes($post[$pre.'question']); ?> 
						</a>
					  </h5>
					</div>

					<div id="collapseOne<?php echo $i;?>" class="bg-custom collapse <?php if($i==1){echo 'in';}?>" role="tabpanel" aria-labelledby="headingOne<?php echo $i++;?>" aria-expanded="true" style="">
					  <div class="card-block">
						<?php echo stripslashes($post[$pre.'answer']); ?>
					  </div>
					</div>
				  </div>
				<?php } ?>				  
				</div> 
			</div>
		</div>
	</div>
</div>
<?php } ?> 