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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Edit Dokumen: ') . $document->title); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-grey dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium">Sedang mengedit: <?php echo e($document->title); ?></h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dokumen dibuka dalam Microsoft Office Online Viewer</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="<?php echo e(route('databank')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Kembali ke Daftar</a>
                            <a href="<?php echo e(route('databank.getFile', $document->filename)); ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" target="_blank">
                                Buka di Tab Baru
                            </a>
                        </div>
                    </div>

                    <div class="w-full h-screen-80 border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                        <iframe
                            src="<?php echo e($viewerUrl); ?>"
                            class="w-full h-full"
                            frameborder="0"
                            allowfullscreen
                            allow="autoplay"
                        ></iframe>
                    </div>

                    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        <p>Catatan:</p>
                        <ul class="list-disc list-inside mt-2">
                            <li>Dokumen akan dibuka dalam Microsoft Office Online Viewer</li>
                            <li>Anda dapat mengedit dokumen langsung di browser</li>
                            <li>Perubahan akan otomatis tersimpan</li>
                            <li>Jika dokumen tidak terbuka, coba klik "Buka di Tab Baru"</li>
                        </ul>
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
<?php endif; ?>
<?php /**PATH C:\Users\Bintang Syaputra\Herd\hassaka\resources\views/databank/edit.blade.php ENDPATH**/ ?>