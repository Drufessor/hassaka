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
            <?php echo e(__('Document History')); ?> - <?php echo e($document->title); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="<?php echo e(route('databank')); ?>" class="text-blue-600 hover:text-blue-900">
                            ← Back to Databank
                        </a>
                    </div>

                    <!-- Document Information -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document Details</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Document Title</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($document->title); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Owner</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($document->user->name); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($document->created_at->format('Y-m-d H:i:s')); ?></dd>
                            </div>
                        </dl>
                    </div>

                    <!-- History Timeline -->
                    <div class="relative">
                        <div class="border-l-2 border-gray-200 ml-3">
                            <?php $__currentLoopData = $auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-8 ml-6">
                                    <!-- Timeline Dot -->
                                    <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-1 mt-2"></div>
                                    
                                    <!-- Event Card -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">
                                                    <?php echo e(ucfirst($log->event)); ?>

                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    by <?php echo e($log->user->name ?? 'System'); ?>

                                                </p>
                                            </div>
                                            <span class="text-sm text-gray-500">
                                                <?php echo e($log->created_at->format('Y-m-d H:i:s')); ?>

                                            </span>
                                        </div>

                                        <?php if($log->event === 'updated'): ?>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Previous Values</h5>
                                                    <dl class="space-y-1">
                                                        <?php $__currentLoopData = $log->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div>
                                                                <dt class="text-xs font-medium text-gray-500">
                                                                    <?php echo e(ucfirst($field)); ?>

                                                                </dt>
                                                                <dd class="text-sm text-gray-900"><?php echo e($value); ?></dd>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </dl>
                                                </div>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-700 mb-2">New Values</h5>
                                                    <dl class="space-y-1">
                                                        <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div>
                                                                <dt class="text-xs font-medium text-gray-500">
                                                                    <?php echo e(ucfirst($field)); ?>

                                                                </dt>
                                                                <dd class="text-sm text-gray-900"><?php echo e($value); ?></dd>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </dl>
                                                </div>
                                            </div>
                                        <?php elseif($log->event === 'created'): ?>
                                            <div class="mt-4">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Initial Values</h5>
                                                <dl class="space-y-1">
                                                    <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div>
                                                            <dt class="text-xs font-medium text-gray-500">
                                                                <?php echo e(ucfirst($field)); ?>

                                                            </dt>
                                                            <dd class="text-sm text-gray-900"><?php echo e($value); ?></dd>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </dl>
                                            </div>
                                        <?php elseif($log->event === 'deleted'): ?>
                                            <div class="mt-4">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Deleted Values</h5>
                                                <dl class="space-y-1">
                                                    <?php $__currentLoopData = $log->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div>
                                                            <dt class="text-xs font-medium text-gray-500">
                                                                <?php echo e(ucfirst($field)); ?>

                                                            </dt>
                                                            <dd class="text-sm text-gray-900"><?php echo e($value); ?></dd>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </dl>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <?php echo e($auditLogs->links()); ?>

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
<?php endif; ?> <?php /**PATH C:\Users\Bintang Syaputra\Herd\hassaka\resources\views/audit-logs/document-history.blade.php ENDPATH**/ ?>