var adminModal = document.getElementById("admin-modal");
var studentModal = document.getElementById("student-modal");
var teacherModal = document.getElementById("teacher-modal");
var parentModal = document.getElementById("parent-modal");
var modal = document.getElementById('confirmationModal');

var adminBtn = document.getElementById("adminadd");
var studentBtn = document.getElementById("studentadd");
var teacherBtn = document.getElementById("teacheradd");
var parentBtn = document.getElementById("parentadd");

var adminClose = document.querySelector(".close-add-admin");
var studentClose = document.querySelector(".close-add-student");
var teacherClose = document.querySelector(".close-add-teacher");
var parentClose = document.querySelector(".close-add-parent");
var confirmButton = document.getElementById('confirmArchive');
var cancelButton = document.getElementById('cancelArchive');

adminBtn.onclick = function () { adminModal.style.display = "block"; }
studentBtn.onclick = function () { studentModal.style.display = "block"; }
teacherBtn.onclick = function () { teacherModal.style.display = "block"; }
parentBtn.onclick = function () { parentModal.style.display = "block"; }

adminClose.onclick = function () { adminModal.style.display = "none"; }
studentClose.onclick = function () { studentModal.style.display = "none"; }
teacherClose.onclick = function () { teacherModal.style.display = "none"; }
parentClose.onclick = function () { parentModal.style.display = "none"; }

window.onclick = function (event) {
    if (event.target == adminModal) { adminModal.style.display = "none"; }
    if (event.target == studentModal) { studentModal.style.display = "none"; }
    if (event.target == teacherModal) { teacherModal.style.display = "none"; }
    if (event.target == parentModal) { parentModal.style.display = "none"; }
    if (event.target == modal) { modal.style.display = "none"; }
}

function setupButtonListeners() {
    const updateAdminBtn = document.querySelectorAll('.update-btn-admin');
    updateAdminBtn.forEach(button => {
        button.addEventListener('click', function () {
            const adminId = button.getAttribute('data-id');
            fetch(`fetch_user.php?category=admin&id=${adminId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('AID').value = data.Aid;
                    document.getElementById('adminID').value = data.Admin_ID;
                    document.getElementById('adminFirstName').value = data.fname;
                    document.getElementById('adminLastName').value = data.lname;
                    document.getElementById('adminUsername').value = data.username;
                    document.getElementById('adminEmail').value = data.email;
                    document.getElementById('adminPhoneNumber').value = data.phone;
                    updateAdminModal.style.display = "block";
                });
        });
    });

    const archiveButtons = document.querySelectorAll('.archive-btn');
    archiveButtons.forEach(button => {
        button.addEventListener('click', function () {
            userId = this.getAttribute('data-id');
            userRole = this.getAttribute('data-role');
            rowElement = this.closest('tr');
            modal.style.display = 'block'; // Show confirmation modal
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupButtonListeners(); // Initial call to set up listeners
    document.getElementById("addAdminForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent normal form submission

        const formData = new FormData(this);

        fetch('add_admin.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newRow = `<tr data-id='${data.Aid}'>
                    <td class='admin-username'>${data.username}</td>
                    <td class='admin-first-name'>${data.first_name}</td>
                    <td class='admin-last-name'>${data.last_name}</td>
                    <td class='admin-email'>${data.email}</td>
                    <td>
                        <button type='button' class='update-btn-admin btn-actions' data-id='${data.Aid}'>Update</button>
                        <button type='button' class='archive-btn btn-actions' data-id='${data.Aid}' data-role='admin'>Archive</button>
                    </td>
                </tr>`;
                    document.querySelector("table tbody").insertAdjacentHTML('beforeend', newRow);
                    setupButtonListeners(); // Reattach event listeners
                    showToast("Admin added successfully");
                    adminModal.style.display = "none";
                } else {
                    alert("Failed to add admin");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });

    // Confirm archive action
    confirmButton.addEventListener('click', function () {
        fetch('archive_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_id=${userId}&role=${userRole}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast(userRole + ' archived successfully');
                    rowElement.remove(); // Remove the archived row from the table
                } else {
                    showToast('Failed to archive admin');
                }
                modal.style.display = 'none'; // Close modal
            })
            .catch(error => console.error('Error:', error));
    });

    // Cancel button click - close modal
    cancelButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });
});

// Toast function
function showToast(message) {
    // Remove any existing toast
    const existingToast = document.querySelector('.toast');
    if (existingToast) {
        existingToast.remove();
    }

    // Create a new toast element
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = message;

    // Append toast to body (or a specific container)
    document.body.appendChild(toast);

    // Set a timeout to remove the toast after a certain duration
    setTimeout(() => {
        toast.remove();
    }, 3000); // Adjust duration as needed
}