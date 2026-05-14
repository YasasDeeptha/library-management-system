<?php

require_once '../../config/database.php';

$search = trim($_POST['search'] ?? '');

$sql = "SELECT * FROM user
        WHERE
        user_id LIKE ?
        OR first_name LIKE ?
        OR last_name LIKE ?
        OR username LIKE ?
        OR email LIKE ?
        ORDER BY user_id ASC";

$searchTerm = "%" . $search . "%";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssss",
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>

            <td>
                <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                    <?= htmlspecialchars($row['user_id']); ?>
                </span>
            </td>

            <td>
                <div class="d-flex align-items-center gap-3">

                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                         style="width:48px;height:48px;font-weight:700;font-size:18px;">
                        <?= strtoupper(substr($row['first_name'], 0, 1)); ?>
                    </div>

                    <div>
                        <div class="fw-semibold">
                            <?= htmlspecialchars($row['first_name']); ?>
                            <?= htmlspecialchars($row['last_name']); ?>
                        </div>

                        <small class="text-muted">
                            Library Staff Member
                        </small>
                    </div>

                </div>
            </td>

            <td>
                <?= htmlspecialchars($row['username']); ?>
            </td>

            <td style="min-width: 180px;">
                <div class="d-flex align-items-center gap-2">
                    <span id="passwordText<?= htmlspecialchars($row['user_id']); ?>"
                          class="font-monospace text-muted">
                        ••••••••
                    </span>

                    <button type="button"
                            class="btn btn-light btn-sm border"
                            onclick="togglePassword(
                                'passwordText<?= htmlspecialchars($row['user_id']); ?>',
                                '<?= htmlspecialchars(substr($row['password'], 0, 8), ENT_QUOTES); ?>'
                            )">
                        👁 Show
                    </button>
                </div>
            </td>

            <td>
                <?= htmlspecialchars($row['email']); ?>
            </td>

            <td class="text-center">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                    Active
                </span>
            </td>

            <td>
                <div class="d-flex justify-content-end gap-2">

                    <a href="view.php?id=<?= urlencode($row['user_id']); ?>"
                       class="btn btn-light btn-sm px-3 border">
                        View
                    </a>

                    <a href="edit.php?id=<?= urlencode($row['user_id']); ?>"
                       class="btn btn-primary btn-sm px-3">
                        Edit
                    </a>

                    <a href="delete.php?id=<?= urlencode($row['user_id']); ?>"
                       class="btn btn-danger btn-sm px-3"
                       onclick="return confirm('Delete this user?')">
                        Delete
                    </a>

                </div>
            </td>

        </tr>
        <?php
    }

} else {
    ?>
    <tr>
        <td colspan="7" class="text-center text-muted py-5">
            No matching staff found.
        </td>
    </tr>
    <?php
}
?>