<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Page title (used in page content)
$page_title = isset($page_title)
    ? $page_title
    : 'LMS';

$nav_title = isset($nav_title)
    ? $nav_title
    : preg_replace('/^(Add|Edit|View|Manage|Super Admin\s*\|)\s*/i', '', $page_title);

?>

<header class="bg-white px-4 py-3 border-bottom shadow-sm d-flex justify-content-between align-items-center sticky-top">

    <div class="d-flex align-items-center">

        <h5 class="mb-0 fw-bold">

            <?php echo htmlspecialchars($nav_title); ?>

        </h5>

    </div>

    <div class="d-flex align-items-center gap-3">

        <!-- DATE -->
        <span class="text-muted small d-none d-md-flex align-items-center">

            <span class="material-symbols-outlined me-1"
                  style="font-size: 1.1rem;">

                calendar_today

            </span>

            <?php echo date('Y-m-d'); ?>

        </span>

        <button type="button"
                class="btn d-flex align-items-center bg-light rounded-pill px-3 py-1 border shadow-sm"
                data-bs-toggle="modal"
                data-bs-target="#profileModal">

            <span class="material-symbols-outlined text-primary me-2"
                  style="font-size: 1.25rem;">

                account_circle

            </span>

            <span class="fw-medium small text-dark">

                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Staff'); ?>

            </span>

        </button>

    </div>

</header>

<!-- PROFILE MODAL -->

<div class="modal fade"
     id="profileModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <!-- MODAL HEADER -->

            <div class="modal-header border-0 pb-0">

                <h4 class="fw-bold mb-0">

                    My Profile

                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <!-- MODAL BODY -->

            <div class="modal-body pt-3">


                <div class="text-center mb-4">

                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm mb-3"
                         style="width:90px;height:90px;font-size:32px;font-weight:700;">

                        <?= strtoupper(substr($_SESSION['username'] ?? 'S',0,1)); ?>

                    </div>

                    <h4 class="fw-bold mb-1">

                        <?= htmlspecialchars($_SESSION['username'] ?? 'Staff'); ?>

                    </h4>

                    <p class="text-muted mb-0">

                        Library Staff Member

                    </p>

                </div>


                <div class="row g-3">

                    <div class="col-6">

                        <div class="border rounded-4 p-3">

                            <small class="text-muted d-block mb-1">

                                Username

                            </small>

                            <div class="fw-semibold">

                                <?= htmlspecialchars($_SESSION['username'] ?? ''); ?>

                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="border rounded-4 p-3">

                            <small class="text-muted d-block mb-1">

                                Status

                            </small>

                            <span class="badge bg-success">

                                Active

                            </span>

                        </div>

                    </div>

                </div>


                <div class="d-grid gap-2 mt-4">

                    <button class="btn btn-primary"
                            data-bs-target="#editProfileModal"
                            data-bs-toggle="modal">

                        Edit Profile

                    </button>

                    <a href="/library-management-system/logout.php"
                       class="btn btn-outline-danger">

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- EDIT PROFILE MODAL -->

<div class="modal fade"
     id="editProfileModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4 shadow">

            <!-- MODAL HEADER -->

            <div class="modal-header border-0 pb-0">

                <h4 class="fw-bold mb-0">
                    Edit Profile
                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <!-- MODAL BODY -->

            <div class="modal-body pt-4">

                <div class="alert alert-danger d-none"
                     id="profileMessage"></div>

                <form id="editProfileForm">

                    <div class="row">


                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-medium">
                                First Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="profile_firstname"
                                   value="<?= htmlspecialchars($_SESSION['first_name'] ?? ''); ?>"
                                   required>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-medium">
                                Last Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="profile_lastname"
                                   value="<?= htmlspecialchars($_SESSION['last_name'] ?? ''); ?>"
                                   required>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-medium">
                                Username
                            </label>

                            <input type="text"
                                   class="form-control bg-light"
                                   value="<?= htmlspecialchars($_SESSION['username'] ?? ''); ?>"
                                   readonly>
                        </div>

                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            Email Address
                        </label>

                        <input type="email"
                               class="form-control"
                               id="profile_email"
                               value="<?= htmlspecialchars($_SESSION['email'] ?? ''); ?>"
                               required>
                    </div>


                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            New Password
                        </label>

                        <input type="password"
                               class="form-control"
                               id="profile_password"
                               placeholder="Leave blank to keep current password">
                    </div>

                  
                    <button type="submit"
                            class="btn btn-primary w-100 py-2 fw-semibold">
                        Save Changes
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>