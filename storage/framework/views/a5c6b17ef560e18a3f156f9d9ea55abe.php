<?php $__env->startSection('title', 'Tasks'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <h1 class="h3 mb-0 text-secondary">My Tasks</h1>
        <a href="<?php echo e(route('tasks.create', ['status' => $filter])); ?>" class="btn btn-primary">Add Task</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="btn-group flex-wrap" role="group" aria-label="Filter by status">
                <a href="<?php echo e(route('home', ['status' => 'all'])); ?>"
                   class="btn btn-outline-primary <?php echo e($filter === 'all' ? 'active' : ''); ?>">All</a>
                <a href="<?php echo e(route('home', ['status' => 'pending'])); ?>"
                   class="btn btn-outline-primary <?php echo e($filter === 'pending' ? 'active' : ''); ?>">Pending</a>
                <a href="<?php echo e(route('home', ['status' => 'completed'])); ?>"
                   class="btn btn-outline-primary <?php echo e($filter === 'completed' ? 'active' : ''); ?>">Completed</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end" style="min-width: 220px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-medium"><?php echo e($task->title); ?></td>
                            <td class="text-secondary small"><?php echo e($task->description ? \Illuminate\Support\Str::limit($task->description, 80) : '—'); ?></td>
                            <td><?php echo e($task->due_date->format('M j, Y')); ?></td>
                            <td>
                                <?php
                                    $priorityBadge = match ($task->priority) {
                                        'high' => 'bg-danger',
                                        'medium' => 'bg-warning text-dark',
                                        'low' => 'bg-secondary',
                                        default => 'bg-secondary',
                                    };
                                ?>
                                <span class="badge rounded-pill <?php echo e($priorityBadge); ?>"><?php echo e(ucfirst($task->priority)); ?></span>
                            </td>
                            <td>
                                <?php if($task->status === 'completed'): ?>
                                    <span class="badge bg-success rounded-pill">Completed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex flex-wrap justify-content-end gap-1">
                                    <a href="<?php echo e(route('tasks.edit', ['task' => $task, 'status' => $filter])); ?>"
                                       class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <?php if($task->isPending()): ?>
                                        <form action="<?php echo e(route('tasks.complete', $task)); ?>" method="post" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="list_status" value="<?php echo e($filter); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Mark Complete</button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this task?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <input type="hidden" name="list_status" value="<?php echo e($filter); ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-5">No tasks found for this filter.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\web assignemnet 3\resources\views/tasks/index.blade.php ENDPATH**/ ?>