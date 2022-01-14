<div class="row" id="featured_products_box" style="display: none;">
<?php if(!empty($featured_products)): ?>
	<?php echo $__env->make('sale_pos.partials.featured_products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</div>
<div class="row">
	<?php if(!empty($categories)): ?>
		<div class="col-md-4" id="product_category_div">
			<select class="select2" id="product_category" style="width:100% !important">

				<option value="all"><?php echo app('translator')->getFromJson('lang_v1.all_category'); ?></option>

				<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($category['id'], false); ?>"><?php echo e($category['name'], false); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(!empty($category['sub_categories'])): ?>
						<optgroup label="<?php echo e($category['name'], false); ?>">
							<?php $__currentLoopData = $category['sub_categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<i class="fa fa-minus"></i> <option value="<?php echo e($sc['id'], false); ?>"><?php echo e($sc['name'], false); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</optgroup>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
		</div>
	<?php endif; ?>
	<div class="col-md-8 ">
		<button type="button" class="btn btn-outline-primary pull-right " style="border-radius: 20px;" id="return-to-category"><i class="fa fa-reply fa-lg" aria-hidden="true"></i></button>
	</div>
<!-- 
	<?php if(!empty($brands)): ?>
		<div class="col-sm-4" id="product_brand_div">
			<?php echo Form::select('size', $brands, null, ['id' => 'product_brand', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important']); ?>

		</div>
	<?php endif; ?>
 -->	<div class="col-md-12">
		<div class="box box-solid mb-12">
			<div class="box-body">
				<div class="product_categories">
					<?php
					$count=0;
					?>
				<div class="col-md-2 product_category" data-value="all" style="padding: 20px; border:2px solid #39adbf; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px; background: #39adbf;color: white; cursor: pointer;">
					<?php echo app('translator')->getFromJson('lang_v1.all_category'); ?>
				</div>
				<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
				$count=$key+1;
				$stln=strlen($category['name']);

				?>
				<div class="col-md-2 product_category" data-value="<?php echo e($category['id'], false); ?>" style="<?php if($stln>17): ?> padding: 12px; <?php else: ?> padding: 20px; <?php endif; ?> border: 2px solid #39adbf; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px;background: <?php echo e($category['color'], false); ?>; color: white;cursor: pointer;">
					<?php echo e($category['name'], false); ?>

				</div>	
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php for($i=$key; $i<40; $i++): ?>
				<div class="col-md-2" style="padding: 20px; border: 2px solid #39adbf; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px;background: <?php echo e(rand_color(), false); ?>; color: white;">
					Empty Div
				</div>	
				<?php endfor; ?>
			</div>
		</div>
		</div>
	</div>
	<!-- used in repair : filter for service/product -->
	<div class="col-md-6 hide" id="product_service_div">
		<?php echo Form::select('is_enabled_stock', ['' => __('messages.all'), 'product' => __('sale.product'), 'service' => __('lang_v1.service')], null, ['id' => 'is_enabled_stock', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important']); ?>

	</div>

	<div class="col-sm-4 <?php if(empty($featured_products)): ?> hide <?php endif; ?>" id="feature_product_div">
		<button type="button" class="btn btn-primary btn-flat" id="show_featured_products"><?php echo app('translator')->getFromJson('lang_v1.featured_products'); ?></button>
	</div>
</div>
<br>
<div class="row">
	<input type="hidden" id="suggestion_page" value="1">
	<div class="col-md-12">
		<div class="eq-height-row" id="product_list_body"></div>
	</div>
	<div class="col-md-12 text-center" id="suggestion_page_loader" style="display: none;">
		<i class="fa fa-spinner fa-spin fa-2x"></i>
	</div>
</div><?php /**PATH C:\xampp\htdocs\pos\resources\views/sale_pos/partials/pos_sidebar.blade.php ENDPATH**/ ?>