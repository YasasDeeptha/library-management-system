<?php
$path = $_SERVER['REQUEST_URI'] ?? '';
$is_dashboard = strpos($path, '/dashboard.php') !== false;
$is_books = strpos($path, '/features/books/') !== false;
$is_categories = strpos($path, '/features/categories/') !== false;
$is_borrow = strpos($path, '/features/borrow/') !== false;
$is_fines = strpos($path, '/features/fines/') !== false;
$is_members = strpos($path, '/features/members/') !== false;
$is_staff = strpos($path, '/features/auth/') !== false;
?>
<aside class="custom-sidebar d-flex flex-column text-white flex-shrink-0 h-100">
    <div class="p-4 border-bottom border-secondary border-opacity-25">
        <h5 class="mb-0 fw-bold d-flex align-items-center">
            <img src="/library-management-system/assets/images/book.png" alt="LMS" style="width:28px;height:28px;object-fit:contain;margin-right:.5rem;"> LMS
        </h5>
    </div>
    <nav class="nav flex-column p-3 flex-grow-1 overflow-auto">
        <a href="/library-management-system/dashboard.php" class="nav-link custom-nav-link d-flex align-items-center <?php echo $is_dashboard ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">grid_view</span> Dashboard
        </a>
        <a href="/library-management-system/features/books/manage.php" class="nav-link custom-nav-link d-flex align-items-center mt-3 <?php echo $is_books ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">library_books</span> Books
        </a>
        <a href="/library-management-system/features/categories/manage.php" class="nav-link custom-nav-link d-flex align-items-center <?php echo $is_categories ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">category</span> Categories
        </a>
        <a href="/library-management-system/features/borrow/manage.php" class="nav-link custom-nav-link d-flex align-items-center mt-3 <?php echo $is_borrow ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">sync_alt</span> Borrow
        </a>
        <a href="/library-management-system/features/fines/manage.php" class="nav-link custom-nav-link d-flex align-items-center <?php echo $is_fines ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">payments</span> Fines
        </a>
        <a href="/library-management-system/features/members/manage.php" class="nav-link custom-nav-link d-flex align-items-center mt-3 <?php echo $is_members ? 'active' : ''; ?>">
            <span class="material-symbols-outlined me-3">group</span> Members
        </a>
    </nav>
    <div class="p-3 border-top border-secondary border-opacity-25">
        <a href="/library-management-system/logout.php" class="nav-link custom-nav-link text-danger d-flex align-items-center">
            <span class="material-symbols-outlined me-3">logout</span> Logout
        </a>
    </div>
</aside>

