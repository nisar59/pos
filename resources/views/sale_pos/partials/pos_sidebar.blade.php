<div class="row" id="featured_products_box" style="display: none;">
@if(!empty($featured_products))
	@include('sale_pos.partials.featured_products')
@endif
</div>
<div class="row">
	@if(!empty($categories))
		<div class="col-md-4" id="product_category_div">
			<select class="select2" id="product_category" style="width:100% !important">

				<option value="all">@lang('lang_v1.all_category')</option>

				@foreach($categories as $category)
					<option value="{{$category['id']}}">{{$category['name']}}</option>
				@endforeach

				@foreach($categories as $category)
					@if(!empty($category['sub_categories']))
						<optgroup label="{{$category['name']}}">
							@foreach($category['sub_categories'] as $sc)
								<i class="fa fa-minus"></i> <option value="{{$sc['id']}}">{{$sc['name']}}</option>
							@endforeach
						</optgroup>
					@endif
				@endforeach
			</select>
		</div>
	@endif
	<div class="col-md-8 ">
		<button type="button" class="btn btn-outline-primary pull-right " style="border-radius: 20px;" id="return-to-category"><i class="fa fa-reply fa-lg" aria-hidden="true"></i></button>
	</div>
<!-- 
	@if(!empty($brands))
		<div class="col-sm-4" id="product_brand_div">
			{!! Form::select('size', $brands, null, ['id' => 'product_brand', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important']) !!}
		</div>
	@endif
 -->	<div class="col-md-12">
		<div class="box box-solid mb-12" style="background-color: #007bff; height: 500px; overflow-x: hidden; overflow-y: scroll;">
			<div class="box-body">
				<div class="product_categories">
					@php
					$count=0;
					@endphp
				<div class="col-md-2 product_category" data-value="all" style="padding: 21px; border:2px solid #39adbf; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px; background: #39adbf;color: white; cursor: pointer;">
					@lang('lang_v1.all_category')
				</div>
				@foreach($categories as $key=> $category)
				@php
				$count=$key+1;
				$stln=strlen($category['name']);
				$clr=$category['color'];
				@endphp
				<div class="col-md-2 product_category" data-value="{{$category['id']}}" style="@if($stln<10) padding-top: 28px; padding-bottom: 28px; @elseif($stln>17) padding: 12px;  @else padding-top: 21px; padding-bottom: 21px; @endif border: 2px solid {{$clr}}; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px;background: {{$clr}}; color: white;cursor: pointer;">
					{{$category['name']}}
				</div>	
				@endforeach

				@for($i=$key; $i<40; $i++)
				@php
				$clr=rand_color();
				@endphp
				<div class="col-md-2" style="padding: 21px; border: 2px solid {{$clr}}; border-radius: 10px; text-align: center; margin: 5px; font-size: 10px;background: {{$clr}}; color: white;">
					Empty Div
				</div>	
				@endfor
			</div>
		</div>
		</div>
	</div>
	<!-- used in repair : filter for service/product -->
	<div class="col-md-6 hide" id="product_service_div">
		{!! Form::select('is_enabled_stock', ['' => __('messages.all'), 'product' => __('sale.product'), 'service' => __('lang_v1.service')], null, ['id' => 'is_enabled_stock', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important']) !!}
	</div>

	<div class="col-sm-4 @if(empty($featured_products)) hide @endif" id="feature_product_div">
		<button type="button" class="btn btn-primary btn-flat" id="show_featured_products">@lang('lang_v1.featured_products')</button>
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
</div>