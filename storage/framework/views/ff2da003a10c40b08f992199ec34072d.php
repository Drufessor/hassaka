<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Audit Log Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="<?php echo e(route('audit-logs.index')); ?>" class="text-blue-600 hover:text-blue-900">
                            ← Back to Audit Logs
                        </a>
                    </div>

                    <!-- Basic Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Event Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date/Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e($auditLog->created_at->format('Y-m-d H:i:s')); ?>

                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">User</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e($auditLog->user->name ?? 'System'); ?>

                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e(ucfirst($auditLog->event)); ?>

                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e(class_basename($auditLog->auditable_type)); ?> #<?php echo e($auditLog->auditable_id); ?>

                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">URL</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e($auditLog->url); ?>

                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo e($auditLog->ip_address); ?>

                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Changes -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Changes</h3>
                        <?php if($auditLog->event === 'updated'): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Old Values -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Old Values</h4>
                                    <dl class="space-y-2">
                                        <?php $__currentLoopData = $auditLog->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500"><?php echo e(ucfirst($field)); ?></dt>
                                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($value); ?></dd>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </dl>
                                </div>
                                <!-- New Values -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">New Values</h4>
                                    <dl class="space-y-2">
                                        <?php $__currentLoopData = $auditLog->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500"><?php echo e(ucfirst($field)); ?></dt>
                                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($value); ?></dd>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </dl>
                                </div>
                            </div>
                        <?php elseif($auditLog->event === 'created'): ?>
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-2">Created Values</h4>
                                <dl class="space-y-2">
                                    <?php $__currentLoopData = $auditLog->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500"><?php echo e(ucfirst($field)); ?></dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($value); ?></dd>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </dl>
                            </div>
                        <?php elseif($auditLog->event === 'deleted'): ?>
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-2">Deleted Values</h4>
                                <dl class="space-y-2">
                                    <?php $__currentLoopData = $auditLog->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500"><?php echo e(ucfirst($field)); ?></dt>
                                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($value); ?></dd>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </dl>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\Users\Bintang Syaputra\Herd\hassaka\resources\views/audit-logs/show.blade.php ENDPATH**/ ?>