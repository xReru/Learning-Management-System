function showToast(message) {
    const toast = document.getElementById("toast");
    toast.innerText = message;
    toast.style.display = "block";
    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
}

var updateTeacherModal = document.getElementById("updateTeacherModal");
var updateStudentModal = document.getElementById("updateStudentModal");
var updateParentModal = document.getElementById("updateParentModal");
var updateAdminModal = document.getElementById("updateAdminModal");

var updateTeacherBtn = document.querySelectorAll('.update-btn-teacher');
var updateStudentBtn = document.querySelectorAll('.update-btn-student');
var updateParentBtn = document.querySelectorAll('.update-btn-parent');
var updateAdminBtn = document.querySelectorAll('.update-btn-admin');

var updateTeacherClose = document.querySelectorAll(".close-teacher");
var updateStudentClose = document.querySelectorAll(".close-student");
var updateParentClose = document.querySelectorAll(".close-parent");
var updateAdminClose = document.querySelectorAll(".close-admin");

updateTeacherBtn.forEach(button => {
    button.addEventListener('click', function () {
        updateTeacherModal.style.display = "block";
    });
});

updateStudentBtn.forEach(button => {
    button.addEventListener('click', function () {
        updateStudentModal.style.display = "block";
    });
});

updateParentBtn.forEach(button => {
    button.addEventListener('click', function () {
        updateParentModal.style.display = "block";
    });
});

updateAdminBtn.forEach(button => {
    button.addEventListener('click', function () {
        updateAdminModal.style.display = "block";
    });
});

updateTeacherClose.forEach(button => {
    button.addEventListener('click', function () {
        updateTeacherModal.style.display = "none";
    });
});

updateStudentClose.forEach(button => {
    button.addEventListener('click', function () {
        updateStudentModal.style.display = "none";
    });
});

updateParentClose.forEach(button => {
    button.addEventListener('click', function () {
        updateParentModal.style.display = "none";
    });
});

updateAdminClose.forEach(button => {
    button.addEventListener('click', function () {
        updateAdminModal.style.display = "none";
    });
});

updateTeacherBtn.forEach(button => {
    button.addEventListener('click', function () {
        const teacherId = button.getAttribute('data-id');

        // Fetch teacher data
        fetch(`fetch_user.php?category=teacher&id=${teacherId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
                document.getElementById('TID').value = data.TID;
                document.getElementById('teacherID').value = data.teacherID;
                document.getElementById('teacherFirstName').value = data.first_name;
                document.getElementById('teacherLastName').value = data.last_name;
                document.getElementById('teacherAddress').value = data.address;
                document.getElementById('teacherEmail').value = data.email;
                document.getElementById('teacherPhoneNumber').value = data.phone_number;

                updateTeacherModal.style.display = "block";
            });
    });
});

document.getElementById("updateTeacherForm").addEventListener("submit", function (event) {
    event.preventDefault();  // Prevent form from submitting the normal way

    const formData = new FormData(this);

    fetch('update_teacher.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table row dynamically
                const teacherRow = document.querySelector(`tr[data-id='${data.TID}']`);
                teacherRow.querySelector(".teacher-first-name").innerText = data.first_name;
                teacherRow.querySelector(".teacher-last-name").innerText = data.last_name;
                teacherRow.querySelector(".teacher-email").innerText = data.email;
                teacherRow.querySelector(".teacher-phone-number").innerText = data.phone_number;
                teacherRow.querySelector(".teacher-address").innerText = data.address;
                // Show success message
                showToast("Teacher information updated successfully");

                // Close the modal
                updateTeacherModal.style.display = "none";
            } else {
                alert("Failed to update teacher information");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});


updateStudentBtn.forEach(button => {
    button.addEventListener('click', function () {
        const studentId = button.getAttribute('data-id');

        // Fetch student data
        fetch(`fetch_user.php?category=student&id=${studentId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
                document.getElementById('SID').value = data.SID;
                document.getElementById('studentID').value = data.studentID;
                document.getElementById('studentFirstName').value = data.first_name;
                document.getElementById('studentLastName').value = data.last_name;
                document.getElementById('studentAddress').value = data.address;
                document.getElementById('studentEmail').value = data.email;
                document.getElementById('studentPhoneNumber').value = data.phone_number;

                updateStudentModal.style.display = "block";
            });
    });
});
document.getElementById("updateStudentForm").addEventListener("submit", function (event) {
    event.preventDefault();  // Prevent form from submitting the normal way

    const formData = new FormData(this);

    fetch('update_student.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table row dynamically
                const studentRow = document.querySelector(`tr[data-id='${data.SID}']`);
                studentRow.querySelector(".student-first-name").innerText = data.first_name;
                studentRow.querySelector(".student-last-name").innerText = data.last_name;
                studentRow.querySelector(".student-email").innerText = data.email;
                studentRow.querySelector(".student-phone-number").innerText = data.phone_number;
                studentRow.querySelector(".student-address").innerText = data.address;
                // Show success message
                showToast("Student information updated successfully");

                // Close the modal
                updateStudentModal.style.display = "none";
            } else {
                alert("Failed to update student information");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});


updateParentBtn.forEach(button => {
    button.addEventListener('click', function () {
        const parentId = button.getAttribute('data-id');

        // Fetch parent data
        fetch(`fetch_user.php?category=parent&id=${parentId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
                document.getElementById('PID').value = data.PID;
                document.getElementById('parentID').value = data.parentID;
                document.getElementById('parentFirstName').value = data.first_name;
                document.getElementById('parentLastName').value = data.last_name;
                document.getElementById('parentEmail').value = data.email;
                document.getElementById('parentAddress').value = data.address;
                document.getElementById('parentPhoneNumber').value = data.phone_number;

                updateParentModal.style.display = "block";
            });
    });
});
document.getElementById("updateParentForm").addEventListener("submit", function (event) {
    event.preventDefault();  // Prevent form from submitting the normal way

    const formData = new FormData(this);

    fetch('update_parent.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table row dynamically
                const parentRow = document.querySelector(`tr[data-id='${data.PID}']`);
                parentRow.querySelector(".parent-first-name").innerText = data.first_name;
                parentRow.querySelector(".parent-last-name").innerText = data.last_name;
                parentRow.querySelector(".parent-email").innerText = data.email;
                parentRow.querySelector(".parent-phone-number").innerText = data.phone_number;
                parentRow.querySelector(".parent-address").innerText = data.address;
                // Show success message
                showToast("Parent information updated successfully");

                // Close the modal
                updateParentModal.style.display = "none";
            } else {
                alert("Failed to update parent information");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});

updateAdminBtn.forEach(button => {
    button.addEventListener('click', function () {
        const adminId = button.getAttribute('data-id');

        // Fetch teacher data
        fetch(`fetch_user.php?category=admin&id=${adminId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
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

document.getElementById("updateAdminForm").addEventListener("submit", function (event) {
    event.preventDefault();  // Prevent form from submitting the normal way

    const formData = new FormData(this);

    fetch('update_admin.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table row dynamically
                const adminRow = document.querySelector(`tr[data-id='${data.Aid}']`);
                adminRow.querySelector(".admin-username").innerText = data.username;
                adminRow.querySelector(".admin-first-name").innerText = data.fname;
                adminRow.querySelector(".admin-last-name").innerText = data.lname;
                adminRow.querySelector(".admin-email").innerText = data.email;
                // Show success message
                showToast("Admin information updated successfully");

                // Close the modal
                updateAdminModal.style.display = "none";
            } else {
                alert("Failed to update admin information");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});