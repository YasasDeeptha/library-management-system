
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

// Staff search handling
document.addEventListener("DOMContentLoaded", () => {

    const searchStaff =
        document.getElementById("searchStaff");

    if(searchStaff){

        console.log("Search Loaded");

        searchStaff.addEventListener("keyup", function(){

            console.log("Typing:", this.value);

            const search = this.value;

            const formData = new FormData();

            formData.append("search", search);

            fetch(
                "/library-management-system/features/auth/searchstaff.php",
                {
                    method: "POST",
                    body: formData
                }
            )

            .then(response => response.text())

            .then(data => {

                console.log(data);

                document.getElementById("staffTable").innerHTML = data;

            })

            .catch(error => {

                console.log(error);

            });

        });

    }

});

// Staff registration handling

document.addEventListener("DOMContentLoaded", () => {

    const staffForm = document.getElementById("staffForm");

    if (staffForm) {

        staffForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const username = document.getElementById("staff_username").value.trim();
            const firstname = document.getElementById("staff_firstname").value.trim();
            const lastname = document.getElementById("staff_lastname").value.trim();
            const email = document.getElementById("staff_email").value.trim();
            const password = document.getElementById("staff_password").value.trim();

            const messageBox = document.getElementById("staffMessage");
            messageBox.classList.add("d-none");

            const usernameRegex = /^[a-zA-Z0-9_]+$/;
            const nameRegex = /^[a-zA-Z]+$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!usernameRegex.test(username)) {
                showStaffMessage("Username can only contain letters, numbers and underscore");
                return;
            }

            if (!nameRegex.test(firstname)) {
                showStaffMessage("Invalid first name");
                return;
            }

            if (!nameRegex.test(lastname)) {
                showStaffMessage("Invalid last name");
                return;
            }

            if (!emailRegex.test(email)) {
                showStaffMessage("Invalid email format");
                return;
            }

            if (password.length < 8) {
                showStaffMessage("Password must be at least 8 characters");
                return;
            }

            const formData = new FormData();
            formData.append("username", username);
            formData.append("firstname", firstname);
            formData.append("lastname", lastname);
            formData.append("email", email);
            formData.append("password", password);

            fetch("/library-management-system/features/auth/registerprocess.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    staffForm.reset();
                    messageBox.classList.add("d-none");

                    const modalEl = document.getElementById("addStaffModal");
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();

                    location.reload();
                } else {
                    showStaffMessage(data);
                }
            })
            .catch(() => {
                showStaffMessage("Something went wrong");
            });
        });
    }

    function showStaffMessage(message) {
        const messageBox = document.getElementById("staffMessage");
        messageBox.classList.remove("d-none");
        messageBox.innerHTML = message;
    }

});

// Edit profile handling

document.addEventListener("DOMContentLoaded", () => {

    const editProfileForm = document.getElementById("editProfileForm");

    if (editProfileForm) {

        editProfileForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const firstName = document.getElementById("profile_firstname").value.trim();
            const lastName = document.getElementById("profile_lastname").value.trim();
            const email = document.getElementById("profile_email").value.trim();
            const password = document.getElementById("profile_password").value.trim();
            const messageBox = document.getElementById("profileMessage");

            messageBox.classList.add("d-none");

            const nameRegex = /^[A-Za-z]+$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!firstName) {
                showProfileMessage("First name is required");
                return;
            }

            if (!lastName) {
                showProfileMessage("Last name is required");
                return;
            }

            if (!nameRegex.test(firstName)) {
                showProfileMessage("First name should contain only letters");
                return;
            }

            if (!nameRegex.test(lastName)) {
                showProfileMessage("Last name should contain only letters");
                return;
            }

            if (!emailRegex.test(email)) {
                showProfileMessage("Invalid email format");
                return;
            }

            if (password !== "" && password.length < 8) {
                showProfileMessage("Password must be at least 8 characters");
                return;
            }

            const formData = new FormData();
            formData.append("first_name", firstName);
            formData.append("last_name", lastName);
            formData.append("email", email);
            formData.append("password", password);

            fetch("/library-management-system/features/auth/updateprofile.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    location.reload();
                } else {
                    showProfileMessage(data);
                }
            })
            .catch(() => {
                showProfileMessage("Something went wrong");
            });
        });

    }

    function showProfileMessage(message) {
        const messageBox = document.getElementById("profileMessage");
        messageBox.classList.remove("d-none");
        messageBox.innerHTML = message;
    }

});