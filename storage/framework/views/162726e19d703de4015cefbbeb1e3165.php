<?php $__env->startSection('title', 'About'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 mb-3 text-secondary">About</h1>
                    <p class="lead text-secondary mb-4">
                        This application helps you organize work with a simple task list backed by a MySQL database.
                    </p>
                    <p class="mb-3">
                        You can add tasks with a title, description, due date, and priority, then track whether each item
                        is still pending or already completed. Filters make it easy to focus on what is left to do or
                        review finished work.
                    </p>
                    <p class="mb-0 text-muted small">
                        Built with Laravel, Bootstrap 5, and Blade templates.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\web assignemnet 3\resources\views\about.blade.php ENDPATH**/ ?>