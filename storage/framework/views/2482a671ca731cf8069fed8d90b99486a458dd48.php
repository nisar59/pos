<?php if(!empty($activities)): ?>
<table class="table table-condensed">
    <tr>
        <th><?php echo app('translator')->getFromJson('lang_v1.date'); ?></th>
        <th><?php echo app('translator')->getFromJson('messages.action'); ?></th>
        <th><?php echo app('translator')->getFromJson('lang_v1.by'); ?></th>
        <th><?php echo app('translator')->getFromJson('brand.note'); ?></th>
    </tr>
    <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e(\Carbon::createFromTimestamp(strtotime($activity->created_at))->format(session('business.date_format') . ' ' . 'h:i A'), false); ?></td>
            <td>
                <?php echo e(__('lang_v1.' . $activity->description), false); ?>

            </td>
            <td>
                <?php echo e($activity->causer->user_full_name, false); ?>

                <?php if(!empty($activity->getExtraProperty('from_api'))): ?>
                    <br>
                    <span class="label bg-gray"><?php echo e($activity->getExtraProperty('from_api'), false); ?></span>
                <?php endif; ?>
            </td>
            <td>
                <?php if(!empty($activity_type)): ?>
                    <?php if($activity_type == 'sell'): ?>
                        <?php echo $__env->make('sale_pos.partials.activity_row', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif($activity_type == 'purchase'): ?>
                        <?php echo $__env->make('sale_pos.partials.activity_row', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                <?php else: ?>
                    <?php
                        $update_note = $activity->getExtraProperty('update_note');
                    ?>
                    <?php if(!empty($update_note)): ?>
                        <?php if(!is_array($update_note)): ?>
                            <?php echo e($update_note, false); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="4" class="text-center">
            <?php echo app('translator')->getFromJson('purchase.no_records_found'); ?>
          </td>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\pos\resources\views/activity_log/activities.blade.php ENDPATH**/ ?>