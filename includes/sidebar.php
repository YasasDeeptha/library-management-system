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
       <a href="#"
   class="nav-link custom-nav-link d-flex align-items-center <?php echo $is_staff ? 'active' : ''; ?>"
   data-bs-toggle="modal"
   data-bs-target="#superAdminAccessModal">

    <span class="material-symbols-outlined me-3">badge</span>

    Staff

</a>
    </nav>
    <div class="p-3 border-top border-secondary border-opacity-25">
        <a href="/library-management-system/logout.php" class="nav-link custom-nav-link text-danger d-flex align-items-center">
            <span class="material-symbols-outlined me-3">logout</span> Logout
        </a>
    </div>
</aside>


<!-- SUPER ADMIN ACCESS MODAL -->

<div class="modal fade"
     id="superAdminAccessModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0 pb-0">

                <h4 class="fw-bold mb-0">

                    Super Admin Access

                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body pt-3">

                <p class="fw-semibold mb-2">

                    Accessing the Staff section requires
                    Super Admin privileges.

                </p>

                <p class="text-muted small mb-0">

                    (If you continue further,
                    your current session will be logged out.)

                </p>

            </div>

            <div class="modal-footer border-0 pt-0">

                <button type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <a href="/library-management-system/features/auth/switchtosuperadmin.php"
                   class="btn btn-primary px-4">

                    Continue

                </a>

            </div>

        </div>

    </div>

</div>
