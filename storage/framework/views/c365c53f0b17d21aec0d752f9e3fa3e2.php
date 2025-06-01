<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="w-full min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 via-white to-blue-700"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(255,165,0,0.2),rgba(255,255,255,0))]"></div>
        
        <!-- Floating shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-orange-300/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-white/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-64 h-64 bg-blue-300/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="w-full max-w-md p-8 bg-white/60 backdrop-blur-lg rounded-3xl shadow-2xl text-center border border-orange-200/40 relative z-10">
            <div class="flex justify-center mb-8 animate-fade-in-down">
                <img src="/logoHassaka.jpg" alt="Hasaka Logo" class="h-20 w-auto drop-shadow-xl transition-transform duration-500 hover:scale-105 rounded-full border-4 border-white/80">
            </div>
            <h2 class="text-3xl font-extrabold text-orange-800 mb-8 tracking-wide drop-shadow-sm">Welcome Back!</h2>
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <input id="email" name="email" type="email" placeholder="Username"
                        class="w-full px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 bg-white/80 shadow-sm text-lg transition placeholder-gray-400"
                        value="<?php echo e(old('email')); ?>" required autofocus>
                </div>
                <div>
                    <input id="password" name="password" type="password" placeholder="Password"
                        class="w-full px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 bg-white/80 shadow-sm text-lg transition placeholder-gray-400"
                        required>
                </div>
                <div class="flex items-center justify-between text-sm text-orange-700 mb-2">
                    <label class="inline-flex items-center select-none">
                        <input type="checkbox" name="remember" class="form-checkbox text-orange-600 focus:ring-orange-400">
                        <span class="ml-2">Remember Me</span>
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="hover:underline text-orange-500">Forgot Password?</a>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-orange-500 to-blue-600 text-white py-3 rounded-xl font-bold text-lg shadow-lg hover:from-orange-600 hover:to-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    Get Started
                </button>
            </form>
        </div>
    </div>
    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Bintang Syaputra\Herd\hassaka\resources\views/auth/login.blade.php ENDPATH**/ ?>