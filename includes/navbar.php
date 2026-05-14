<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$page_title = isset($page_title)
    ? $page_title
    : 'LMS';

$nav_title = isset($nav_title)
    ? $nav_title
    : preg_replace('/^(Add|Edit|View|Manage)\s*/i', '', $page_title);

?>

<header class="bg-white px-4 py-3 border-bottom shadow-sm d-flex justify-content-between align-items-center sticky-top">

    <div class="d-flex align-items-center">

        <h5 class="mb-0 fw-bold">

            <?php echo htmlspecialchars($nav_title); ?>

        </h5>

    </div>

    <div class="d-flex align-items-center gap-3">

        <span class="text-muted small d-none d-md-flex align-items-center">

            <span class="material-symbols-outlined me-1"
                  style="font-size: 1.1rem;">

                calendar_today

            </span>

            <?php echo date('Y-m-d'); ?>

        </span>

    </div>

</header>