
document.addEventListener("DOMContentLoaded", function() {
    console.log("Library Management System loaded.");
});

//login process handling

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    // Regular login only
    if (document.getElementById("loginForm") && !path.includes("superadmin-login.php")) {
        const loginForm = document.getElementById("loginForm");

        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const messageBox = document.getElementById("message");

            messageBox.classList.add("d-none");

            const usernameRegex = /^[a-zA-Z0-9_@.]+$/;

            if (!usernameRegex.test(username)) {
                showMessage("Invalid username or email format");
                return;
            }

            if (password.length < 8) {
                showMessage("Password must be at least 8 characters");
                return;
            }

            const formData = new FormData();
            formData.append("username", username);
            formData.append("password", password);

            fetch("/library-management-system/features/auth/loginprocess.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    window.location.href = "/library-management-system/dashboard.php";
                } else {
                    showMessage(data);
                }
            })
            .catch(() => {
                showMessage("Something went wrong");
            });
        });

        function showMessage(message) {
            const messageBox = document.getElementById("message");
            messageBox.classList.remove("d-none");
            messageBox.innerHTML = message;
        }
    }

    // Super admin login only
    if (document.getElementById("loginForm") && path.includes("superadmin-login.php")) {
        const superAdminForm = document.getElementById("loginForm");

        superAdminForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const messageBox = document.getElementById("message");

            messageBox.classList.add("d-none");

            const formData = new FormData();
            formData.append("username", username);
            formData.append("password", password);

            fetch("/library-management-system/features/auth/superadminprocess.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    window.location.href = "/library-management-system/features/auth/manage.php";
                } else {
                    messageBox.classList.remove("d-none");
                    messageBox.innerHTML = data;
                }
            });
        });
    }
});


// Password toggle handling
function togglePassword(elementId, passwordPreview) {
    const el = document.getElementById(elementId);

    if (el.dataset.state === "shown") {
        el.innerHTML = "••••••••";
        el.dataset.state = "hidden";
        return;
    }

    el.innerHTML = passwordPreview + "...";
    el.dataset.state = "shown";
}