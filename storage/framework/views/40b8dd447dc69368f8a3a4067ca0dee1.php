<h2 class="h2 text-center my-4"><?php echo e(trans('backpack::base.login')); ?></h2>
<form method="POST" action="<?php echo e(route('backpack.auth.login')); ?>" autocomplete="off" novalidate="">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label class="form-label" for="<?php echo e($username); ?>"><?php echo e(trans(config('backpack.base.authentication_column_name'))); ?></label>
        <input autofocus tabindex="1" type="text" name="<?php echo e($username); ?>" value="<?php echo e(old($username)); ?>" id="<?php echo e($username); ?>" class="form-control <?php echo e($errors->has($username) ? 'is-invalid' : ''); ?>">
        <?php if($errors->has($username)): ?>
            <div class="invalid-feedback"><?php echo e($errors->first($username)); ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-2">
        <label class="form-label" for="password">
            <?php echo e(trans('backpack::base.password')); ?>

        </label>
        <input tabindex="2" type="password" name="password" id="password" class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" value="">
        <?php if($errors->has('password')): ?>
            <div class="invalid-feedback"><?php echo e($errors->first('password')); ?></div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-check mb-0">
            <input name="remember" tabindex="3" type="checkbox" class="form-check-input">
            <span class="form-check-label"><?php echo e(trans('backpack::base.remember_me')); ?></span>
        </label>
        <?php if(backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true)): ?>
            <div class="form-label-description">
                <a tabindex="4" href="<?php echo e(route('backpack.auth.password.reset')); ?>"><?php echo e(trans('backpack::base.forgot_your_password')); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="form-footer">
        <button tabindex="5" type="submit" class="btn btn-primary w-100"><?php echo e(trans('backpack::base.login')); ?></button>
    </div>
</form><?php /**PATH /var/www/vhosts/tijdydesign.nl/cmb--cms.tijdydesign.nl/vendor/backpack/theme-tabler/resources/views/auth/login/inc/form.blade.php ENDPATH**/ ?>