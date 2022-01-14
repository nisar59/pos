@php
$is_mobile = isMobile();
@endphp
<div class="row pos_form_totals" style="background-color: silver; padding: 12px; margin: 10px; border-radius: 10px;">
	<div class="col-md-12">
		<table class="table table-condensed">
			<tr>
				<td><b>@lang('sale.item'):</b>&nbsp;
					<span class="total_quantity">0</span></td>
				<td>
					<b>@lang('sale.total'):</b> &nbsp;
					<span class="price_total">0</span>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						@if($is_discount_enabled)
							@lang('sale.discount')
							@show_tooltip(__('tooltip.sale_discount'))
						@endif
						@if($is_rp_enabled)
							{{session('business.rp_name')}}
						@endif
						(-):
						<i class="fas fa-edit cursor-pointer" id="pos-edit-discount" title="@lang('sale.edit_discount')" aria-hidden="true" data-toggle="modal" data-target="#posEditDiscountModal"></i>
							<span id="total_discount">0</span>
							<input type="hidden" name="discount_type" id="discount_type" value="@if(empty($edit)){{'percentage'}}@else{{$transaction->discount_type}}@endif" data-default="percentage">

							<input type="hidden" name="discount_amount" id="discount_amount" value="@if(empty($edit)) {{@num_format($business_details->default_sales_discount)}} @else {{@num_format($transaction->discount_amount)}} @endif" data-default="{{$business_details->default_sales_discount}}">

							<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="@if(empty($edit)){{'0'}}@else{{$transaction->rp_redeemed}}@endif">

							<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="@if(empty($edit)){{'0'}}@else {{$transaction->rp_redeemed_amount}} @endif">

							
					</b> 
				</td>
				<td class="@if($pos_settings['disable_order_tax'] != 0) hide @endif">
					<span>
						<b>@lang('sale.order_tax')(+): @show_tooltip(__('tooltip.sale_tax'))</b>
						<i class="fas fa-edit cursor-pointer" title="@lang('sale.edit_order_tax')" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax" ></i> 
						<span id="order_tax">
							@if(empty($edit))
								0
							@else
								{{$transaction->tax_amount}}
							@endif
						</span>

						<input type="hidden" name="tax_rate_id" 
							id="tax_rate_id" 
							value="@if(empty($edit)) {{$business_details->default_sales_tax}} @else {{$transaction->tax_id}} @endif" 
							data-default="{{$business_details->default_sales_tax}}">

						<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
							value="@if(empty($edit)) {{@num_format($business_details->tax_calculation_amount)}} @else {{@num_format(optional($transaction->tax)->amount)}} @endif" data-default="{{$business_details->tax_calculation_amount}}">

					</span>
				</td>
				<td class="@if($pos_settings['disable_discount'] != 0) hide @endif">
					<span>

						<b>@lang('sale.shipping')(+): @show_tooltip(__('tooltip.shipping'))</b> 
						<i class="fas fa-edit cursor-pointer"  title="@lang('sale.shipping')" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
						<span id="shipping_charges_amount">0</span>
						<input type="hidden" name="shipping_details" id="shipping_details" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_details}}@endif" data-default="">

						<input type="hidden" name="shipping_address" id="shipping_address" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_address}}@endif">

						<input type="hidden" name="shipping_status" id="shipping_status" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_status}}@endif">

						<input type="hidden" name="delivered_to" id="delivered_to" value="@if(empty($edit)){{''}}@else{{$transaction->delivered_to}}@endif">

						<input type="hidden" name="shipping_charges" id="shipping_charges" value="@if(empty($edit)){{@num_format(0.00)}} @else{{@num_format($transaction->shipping_charges)}} @endif" data-default="0.00">
					</span>
				</td>
				@if(in_array('types_of_service', $enabled_modules))
					<td class="col-sm-3 col-xs-6 d-inline-table">
						<b>@lang('lang_v1.packing_charge')(+):</b>
						<i class="fas fa-edit cursor-pointer service_modal_btn"></i> 
						<span id="packing_charge_text">
							0
						</span>
					</td>
				@endif
				@if(!empty($pos_settings['amount_rounding_method']) && $pos_settings['amount_rounding_method'] > 0)
				<td>
					<b id="round_off">@lang('lang_v1.round_off'):</b> <span id="round_off_text">0</span>								
					<input type="hidden" name="round_off_amount" id="round_off_amount" value=0>
				</td>
				@endif
				@if(!$is_mobile)
				<td>
				&nbsp;&nbsp;
				<b>@lang('sale.total_payable'):</b>
				<input type="hidden" name="final_total"
				id="final_total_input" value=0>
				<span id="total_payable" class="text-success text-bold">0</span>
				&nbsp;&nbsp;
				@endif
				@if(empty($edit))
				<button type="button" class="btn rounded-circle btn-outline-danger @if($is_mobile) col-xs-6 @else btn-xs @endif" id="pos-cancel"> <i class="fas fa-window-close"></i> @lang('sale.cancel')</button>
				@else
				<button type="button" class="btn rounded-circle btn-outline-danger btn-flat hide @if($is_mobile) col-xs-6 @else btn-xs @endif" id="pos-delete"> <i class="fas fa-trash-alt"></i> @lang('messages.delete')</button>
			</td>
				@endif
			</tr>
		</table>
	<hr>
				@include('sale_pos.partials.pos_form_actions')
</div>
</div>
