<?php $__env->startSection('title', __( 'lang_v1.sales_order')); ?>
<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1><?php echo app('translator')->getFromJson('lang_v1.sales_order'); ?>
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
    <?php $__env->startComponent('components.filters', ['title' => __('report.filters')]); ?>
        <div class="col-md-3">
            <div class="form-group">
                <?php echo Form::label('sell_list_filter_location_id',  __('purchase.business_location') . ':'); ?>


                <?php echo Form::select('sell_list_filter_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]);; ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php echo Form::label('sell_list_filter_customer_id',  __('contact.customer') . ':'); ?>

                <?php echo Form::select('sell_list_filter_customer_id', $customers, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]);; ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php echo Form::label('so_list_filter_status',  __('sale.status') . ':'); ?>

                <?php echo Form::select('so_list_filter_status', $sales_order_statuses, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]);; ?>

            </div>
        </div>
        <?php if(!empty($shipping_statuses)): ?>
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo Form::label('so_list_shipping_status', __('lang_v1.shipping_status') . ':'); ?>

                    <?php echo Form::select('so_list_shipping_status', $shipping_statuses, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]);; ?>

                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3">
            <div class="form-group">
                <?php echo Form::label('sell_list_filter_date_range', __('report.date_range') . ':'); ?>

                <?php echo Form::text('sell_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']);; ?>

            </div>
        </div>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.widget', ['class' => 'box-primary']); ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('so.create')): ?>
            <?php $__env->slot('tool'); ?>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="<?php echo e(action('SellController@create'), false); ?>?sale_type=sales_order">
                    <i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('lang_v1.add_sales_order'); ?></a>
                </div>
            <?php $__env->endSlot(); ?>
        <?php endif; ?>
        <?php if( auth()->user()->can('so.view_own') || auth()->user()->can('so.view_all')): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped ajax_view" id="sell_table">
                <thead>
                    <tr>
                        <th><?php echo app('translator')->getFromJson('messages.action'); ?></th>
                        <th><?php echo app('translator')->getFromJson('messages.date'); ?></th>
                        <th><?php echo app('translator')->getFromJson('restaurant.order_no'); ?></th>
                        <th><?php echo app('translator')->getFromJson('sale.customer_name'); ?></th>
                        <th><?php echo app('translator')->getFromJson('lang_v1.contact_no'); ?></th>
                        <th><?php echo app('translator')->getFromJson('sale.location'); ?></th>
                        <th><?php echo app('translator')->getFromJson('sale.status'); ?></th>
                        <th><?php echo app('translator')->getFromJson('lang_v1.shipping_status'); ?></th>
                        <th><?php echo app('translator')->getFromJson('lang_v1.quantity_remaining'); ?></th>
                        <th><?php echo app('translator')->getFromJson('lang_v1.added_by'); ?></th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
</section>
<!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<?php if ($__env->exists('sales_order.common_js')) echo $__env->make('sales_order.common_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
$(document).ready( function(){
    $('#sell_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            sell_table.ajax.reload();
        }
    );
    $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#sell_list_filter_date_range').val('');
        sell_table.ajax.reload();
    });
    sell_table = $('#sell_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'desc']],
        "ajax": {
            "url": '/sells?sale_type=sales_order',
            "data": function ( d ) {
                if($('#sell_list_filter_date_range').val()) {
                    var start = $('#sell_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.start_date = start;
                    d.end_date = end;
                }

                if($('#sell_list_filter_location_id').length) {
                    d.location_id = $('#sell_list_filter_location_id').val();
                }
                d.customer_id = $('#sell_list_filter_customer_id').val();

                if ($('#so_list_filter_status').length) {
                    d.status = $('#so_list_filter_status').val();
                }
                if ($('#so_list_shipping_status').length) {
                    d.shipping_status = $('#so_list_shipping_status').val();
                }

                if($('#created_by').length) {
                    d.created_by = $('#created_by').val();
                }
            }
        },
        columnDefs: [ {
            "targets": 7,
            "orderable": false,
            "searchable": false
        } ],
        columns: [
            { data: 'action', name: 'action'},
            { data: 'transaction_date', name: 'transaction_date'  },
            { data: 'invoice_no', name: 'invoice_no'},
            { data: 'conatct_name', name: 'conatct_name'},
            { data: 'mobile', name: 'contacts.mobile'},
            { data: 'business_location', name: 'bl.name'},
            { data: 'status', name: 'status'},
            { data: 'shipping_status', name: 'shipping_status'},
            { data: 'so_qty_remaining', name: 'so_qty_remaining', "searchable": false},
            { data: 'added_by', name: 'u.first_name'},
        ]
    });
    $(document).on('change', '#sell_list_filter_location_id, #sell_list_filter_customer_id, #created_by, #so_list_filter_status, #so_list_shipping_status',  function() {
        sell_table.ajax.reload();
    });
});
</script>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pos\resources\views/sales_order/index.blade.php ENDPATH**/ ?>