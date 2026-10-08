<section class="schedule-hero">
    <div class="schedule-hero-copy">
        <p class="eyebrow dark-eyebrow"><span class="eyebrow-line"></span> Your complete schedule</p>
        <h1>Every task.<br><em>Right on time.</em></h1>
        <p>Look beyond today. Your work is grouped by date so it’s easy to see what’s done, what’s in front of you, and what’s coming up.</p>
        <a class="text-link" href="<?= site_url('/') ?>">Back to today <span aria-hidden="true">↗</span></a>
    </div>
    <div class="schedule-feature" aria-label="Schedule summary">
        <span class="schedule-feature-kicker">The big picture</span>
        <strong><?= $total ?></strong>
        <span class="schedule-feature-label">tasks on your schedule</span>
        <div class="feature-rule"></div>
        <span class="schedule-feature-footer"><?= count($schedule) ?> <?= count($schedule) === 1 ? 'scheduled date' : 'scheduled dates' ?> <span aria-hidden="true">↗</span></span>
    </div>
</section>

<section class="schedule-statbar" aria-label="Schedule overview">
    <div><span class="statbar-icon today-icon" aria-hidden="true">●</span><span><strong><?= $todayCount ?></strong><small>Due today</small></span></div>
    <div><span class="statbar-icon coming-icon" aria-hidden="true">↗</span><span><strong><?= $upcomingCount ?></strong><small>Coming up</small></span></div>
    <div><span class="statbar-icon done-icon" aria-hidden="true">✓</span><span><strong><?= $doneCount ?></strong><small>Completed overall</small></span></div>
</section>

<?php
$formData = session()->getFlashdata('formData') ?? [];
$formErrors = session()->getFlashdata('errors') ?? [];
?>
<section class="task-workspace" id="add-task" aria-labelledby="add-task-title">
    <div class="workspace-heading">
        <div><p class="eyebrow dark-eyebrow">Make a plan</p><h2 id="add-task-title">Add a new task</h2><p>Give it a clear title, choose the day, and it will appear in your schedule.</p></div>
        <span class="workspace-mark" aria-hidden="true">＋</span>
    </div>
    <?php if ($formErrors !== []): ?>
        <div class="form-errors" role="alert"><strong>Please check your task:</strong><ul><?php foreach ($formErrors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form class="task-form" action="<?= site_url('tasks') ?>" method="post">
        <?= csrf_field() ?>
        <label class="form-field form-title"><span>Task title</span><input name="title" type="text" maxlength="150" minlength="3" required placeholder="What would you like to get done?" value="<?= esc($formData['title'] ?? '', 'attr') ?>"></label>
        <label class="form-field"><span>Scheduled date</span><input name="task_date" type="date" required value="<?= esc($formData['task_date'] ?? $today, 'attr') ?>"></label>
        <label class="form-field"><span>Status</span><select name="status"><option value="pending" <?= ($formData['status'] ?? 'pending') === 'pending' ? 'selected' : '' ?>>Pending</option><option value="in progress" <?= ($formData['status'] ?? '') === 'in progress' ? 'selected' : '' ?>>In progress</option><option value="done" <?= ($formData['status'] ?? '') === 'done' ? 'selected' : '' ?>>Done</option></select></label>
        <button class="button button-dark form-submit" type="submit">Add task <span aria-hidden="true">↗</span></button>
    </form>
</section>

<section class="content-section schedule-section" aria-labelledby="schedule-title">
    <div class="section-heading">
        <div><p class="eyebrow dark-eyebrow">Date by date</p><h2 id="schedule-title">Your schedule</h2><p class="section-description"><?= $filtersActive ? 'Showing ' . $visibleCount . ' of ' . $total . ' tasks.' : 'All ' . $total . ' tasks, shown in chronological order.' ?></p></div>
        <span class="section-count"><?= count($schedule) ?> <?= count($schedule) === 1 ? 'day' : 'days' ?></span>
    </div>

    <form class="filter-bar" action="<?= site_url('tasks') ?>" method="get" aria-label="Filter tasks">
        <label class="filter-field filter-search"><span>Search tasks</span><input type="search" name="q" maxlength="100" placeholder="Search by title" value="<?= esc($search, 'attr') ?>"></label>
        <label class="filter-field"><span>Status</span><select name="status"><option value="">All statuses</option><option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option><option value="in progress" <?= $statusFilter === 'in progress' ? 'selected' : '' ?>>In progress</option><option value="done" <?= $statusFilter === 'done' ? 'selected' : '' ?>>Done</option></select></label>
        <label class="filter-field"><span>Date</span><input type="date" name="date" value="<?= esc($dateFilter, 'attr') ?>"></label>
        <button class="filter-button" type="submit">Apply filters</button>
        <?php if ($filtersActive): ?><a class="clear-filter" href="<?= site_url('tasks') ?>#schedule-title">Clear</a><?php endif; ?>
    </form>

    <?php if ($schedule === []): ?>
        <div class="empty-state"><strong><?= $filtersActive ? 'No tasks match those filters.' : 'No tasks in the schedule yet.' ?></strong><p><?= $filtersActive ? 'Try another search, status, or date.' : 'Add a task above to start your schedule.' ?></p><?php if ($filtersActive): ?><a class="text-link" href="<?= site_url('tasks') ?>#schedule-title">Show all tasks →</a><?php endif; ?></div>
    <?php else: ?>
        <div class="schedule-timeline">
            <?php foreach ($schedule as $date => $dayTasks): ?>
                <?php
                    $timestamp = strtotime($date);
                    $relativeDay = $date === $today ? 'Today' : ($date === date('Y-m-d', strtotime($today . ' -1 day')) ? 'Yesterday' : ($date === date('Y-m-d', strtotime($today . ' +1 day')) ? 'Tomorrow' : date('l', $timestamp)));
                    $isToday = $date === $today;
                ?>
                <section class="schedule-day<?= $isToday ? ' schedule-day-today' : '' ?>" aria-label="<?= esc(date('F j, Y', $timestamp), 'attr') ?>">
                    <div class="schedule-date">
                        <div class="date-tile"><span><?= esc(date('M', $timestamp)) ?></span><strong><?= esc(date('d', $timestamp)) ?></strong></div>
                        <div class="date-meta"><span><?= esc($relativeDay) ?></span><strong><?= esc(date('l, F j', $timestamp)) ?></strong><small><?= count($dayTasks) ?> <?= count($dayTasks) === 1 ? 'task' : 'tasks' ?> scheduled</small></div>
                    </div>
                    <div class="schedule-day-tasks">
                        <?php foreach ($dayTasks as $task): ?>
                            <?php $statusClass = match ($task['status']) { 'done' => 'done', 'in progress' => 'progress', default => 'pending' }; ?>
                            <article class="schedule-task">
                                <span class="schedule-task-marker marker-<?= $statusClass ?>" aria-hidden="true"></span>
                                <div class="schedule-task-body">
                                    <div class="schedule-task-heading"><span class="schedule-task-title"><?= esc($task['title']) ?></span><span class="status status-<?= $statusClass ?>"><?= esc(ucfirst($task['status'])) ?></span></div>
                                    <div class="schedule-task-actions">
                                        <?php if ($task['status'] === 'pending'): ?><form action="<?= site_url('tasks/' . $task['id'] . '/start') ?>" method="post"><?= csrf_field() ?><input type="hidden" name="return_to" value="tasks"><button class="small-action" type="submit">Start</button></form><?php endif; ?>
                                        <form action="<?= site_url('tasks/' . $task['id'] . '/toggle') ?>" method="post"><?= csrf_field() ?><input type="hidden" name="return_to" value="tasks"><button class="small-action" type="submit"><?= $task['status'] === 'done' ? 'Reopen' : 'Mark complete' ?></button></form>
                                        <a class="small-action" href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a>
                                        <details class="delete-control"><summary>Delete</summary><form action="<?= site_url('tasks/' . $task['id'] . '/delete') ?>" method="post"><?= csrf_field() ?><input type="hidden" name="confirm_delete" value="yes"><span>Remove this task?</span><button type="submit">Yes, delete</button></form></details>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
