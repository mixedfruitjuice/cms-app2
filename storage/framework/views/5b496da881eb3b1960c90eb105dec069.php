<?php $__currentLoopData = backpack_theme_config('options.colorModes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<button
    onclick="colorMode.switch()"
    class="btn-link text-secondary border-none decoration-none shadow-none nav-link d-none show-theme-<?php echo e($mode); ?>"
    data-bs-toggle="tooltip"
    data-bs-placement="bottom"
    aria-label="Using <?php echo e($mode); ?> color mode"
    data-bs-original-title="Using <?php echo e($mode); ?> color mode">
    <i class="la <?php echo e($icon); ?> fs-2 m-0"></i>
</button>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/vhosts/tijdydesign.nl/cmb--cms.tijdydesign.nl/vendor/backpack/theme-tabler/resources/views/layouts/partials/switch_theme.blade.php ENDPATH**/ ?>