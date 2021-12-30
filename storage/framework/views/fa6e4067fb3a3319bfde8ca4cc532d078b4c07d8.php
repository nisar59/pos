<div class="modal-dialog modal-xl no-print" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="modalTitle"> <?php echo app('translator')->getFromJson('lang_v1.sell_return'); ?> (<b><?php echo app('translator')->getFromJson('sale.invoice_no'); ?>:</b> <?php echo e($sell->return_parent->invoice_no, false); ?>)
    </h4>
</div>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-6 col-xs-6">
        <h4><?php echo app('translator')->getFromJson('lang_v1.sell_return_details'); ?>:</h4>
        <strong><?php echo app('translator')->getFromJson('lang_v1.return_date'); ?>:</strong> <?php echo e(\Carbon::createFromTimestamp(strtotime($sell->return_parent->transaction_date))->format(session('business.date_format')), false); ?><br>
        <strong><?php echo app('translator')->getFromJson('contact.customer'); ?>:</strong> <?php echo e($sell->contact->name, false); ?> <br>
        <strong><?php echo app('translator')->getFromJson('purchase.business_location'); ?>:</strong> <?php echo e($sell->location->name, false); ?>

      </div>
      <div class="col-sm-6 col-xs-6">
        <h4><?php echo app('translator')->getFromJson('lang_v1.sell_details'); ?>:</h4>
        <strong><?php echo app('translator')->getFromJson('sale.invoice_no'); ?>:</strong> <?php echo e($sell->invoice_no, false); ?> <br>
        <strong><?php echo app('translator')->getFromJson('messages.date'); ?>:</strong> <?php echo e(\Carbon::createFromTimestamp(strtotime($sell->transaction_date))->format(session('business.date_format')), false); ?>

      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12">
        <br>
        <table class="table bg-gray">
          <thead>
            <tr class="bg-green">
                <th>#</th>
                <th><?php echo app('translator')->getFromJson('product.product_name'); ?></th>
                <th><?php echo app('translator')->getFromJson('sale.unit_price'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.return_quantity'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.return_subtotal'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
              $total_before_tax = 0;
            ?>
            <?php $__currentLoopData = $sell->sell_lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sell_line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($sell_line->quantity_returned == 0): ?>
                <?php continue; ?>
            <?php endif; ?>

            <?php
              $unit_name = $sell_line->product->unit->short_name;

              if(!empty($sell_line->sub_unit)) {
                $unit_name = $sell_line->sub_unit->short_name;
              }
            ?>

            <tr>
                <td><?php echo e($loop->iteration, false); ?></td>
                <td>
                  <?php echo e($sell_line->product->name, false); ?>

                  <?php if( $sell_line->product->type == 'variable'): ?>
                    - <?php echo e($sell_line->variations->product_variation->name, false); ?>

                    - <?php echo e($sell_line->variations->name, false); ?>

                  <?php endif; ?>
                </td>
                <td><span class="display_currency" data-currency_symbol="true"><?php echo e($sell_line->unit_price_inc_tax, false); ?></span></td>
                <td><?php echo e(number_format($sell_line->quantity_returned, config('constants.quantity_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php echo e($unit_name, false); ?></td>
                <td>
                  <?php
                    $line_total = $sell_line->unit_price_inc_tax * $sell_line->quantity_returned;
                    $total_before_tax += $line_total ;
                  ?>
                  <span class="display_currency" data-currency_symbol="true"><?php echo e($line_total, false); ?></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
      <table class="table">
        <tr>
          <th><?php echo app('translator')->getFromJson('purchase.net_total_amount'); ?>: </th>
          <td></td>
          <td><span class="display_currency pull-right" data-currency_symbol="true"><?php echo e($total_before_tax, false); ?></span></td>
        </tr>

        <tr>
          <th><?php echo app('translator')->getFromJson('lang_v1.return_discount'); ?>: </th>
          <td><b>(-)</b></td>
          <td class="text-right"><?php if($sell->return_parent->discount_type == 'percentage'): ?>
              @<strong><small><?php echo e($sell->return_parent->discount_amount, false); ?>%</small></strong> -
              <?php endif; ?>
          <span class="display_currency pull-right" data-currency_symbol="true"><?php echo e($total_discount, false); ?></span></td>
        </tr>
        
        <tr>
          <th><?php echo app('translator')->getFromJson('lang_v1.total_return_tax'); ?>:</th>
          <td><b>(+)</b></td>
          <td class="text-right">
              <?php if(!empty($sell_taxes)): ?>
                <?php $__currentLoopData = $sell_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <strong><small><?php echo e($k, false); ?></small></strong> - <span class="display_currency pull-right" data-currency_symbol="true"><?php echo e($v, false); ?></span><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
              0.00
              <?php endif; ?>
            </td>
        </tr>
        <tr>
          <th><?php echo app('translator')->getFromJson('lang_v1.return_total'); ?>:</th>
          <td></td>
          <td><span class="display_currency pull-right" data-currency_symbol="true" ><?php echo e($sell->return_parent->final_total, false); ?></span></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
          <strong><?php echo e(__('repair::lang.activities'), false); ?>:</strong><br>
          <?php if ($__env->exists('activity_log.activities', ['activity_type' => 'sell'])) echo $__env->make('activity_log.activities', ['activity_type' => 'sell'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
  </div>
</div>
<div class="modal-footer">
    <a href="#" class="print-invoice btn btn-primary" data-href="<?php echo e(action('SellReturnController@printInvoice', [$sell->return_parent->id]), false); ?>"><i class="fa fa-print" aria-hidden="true"></i> <?php echo app('translator')->getFromJson("messages.print"); ?></a>
      <button type="button" class="btn btn-default no-print" data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.close' ); ?></button>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var element = $('div.modal-xl');
    __currency_convert_recursively(element);
  });
</script><?php /**PATH C:\xampp\htdocs\pos\resources\views/sell_return/show.blade.php ENDPATH**/ ?>