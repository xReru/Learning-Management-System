// Open Add Course Modal
var modal = document.getElementById('courseModal');
var openModalBtn = document.getElementById('openModalBtn');
var closeModalBtn = document.getElementById('closeModalBtn');
var cancelBtn = document.getElementById('cancelBtn');

openModalBtn.onclick = function () {
    modal.style.display = 'flex';
}

closeModalBtn.onclick = cancelBtn.onclick = function () {
    modal.style.display = 'none';
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Save New Course
document.getElementById('saveCourseBtn').onclick = function () {
    var courseName = document.getElementById('course_name').value;
    var courseDescription = document.getElementById('course_description').value;
    var courseCode = document.getElementById('course_code').value;

    if (courseName && courseDescription && courseCode) {
        var formData = new FormData();
        formData.append('course_name', courseName);
        formData.append('course_description', courseDescription);
        formData.append('course_code', courseCode);

        fetch('submit_course.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast('Course added successfully'); // Show toast message

                    // Dynamically add new course to the table
                    const newRow = `
                    <tr data-id="${data.course_id}">
                        <td>${courseName}</td>
                        <td>${courseDescription}</td>
                        <td>${courseCode}</td>
                        <td>
                            <button class='btn' onclick='openEditModal(${JSON.stringify(data.course)})'>Edit</button>
                            <button class='btn btn-remove' onclick='showRemoveConfirmation(${data.course_id})'>Archive</button>
                        </td>
                    </tr>`;
                    document.querySelector('table').insertAdjacentHTML('beforeend', newRow);
                    modal.style.display = 'none'; // Close modal
                } else {
                    showToast(data.message); // Show error toast
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error adding course. Please try again.');
            });
    } else {
        showToast('Please fill in all the fields'); // Show error toast
    }
};

// Open Edit Course Modal
const editCourseModal = document.getElementById('editCourseModal');
const closeEditModalBtn = document.getElementById('closeEditModalBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const saveEditCourseBtn = document.getElementById('saveEditCourseBtn');

function openEditModal(course) {
    document.getElementById('edit_course_id').value = course.course_id;
    document.getElementById('edit_course_name').value = course.course_name;
    document.getElementById('edit_course_description').value = course.course_description;
    document.getElementById('edit_course_code').value = course.course_code;

    editCourseModal.style.display = 'flex';
}

function closeEditModal() {
    editCourseModal.style.display = 'none';
}

closeEditModalBtn.addEventListener('click', closeEditModal);
cancelEditBtn.addEventListener('click', closeEditModal);

// Save Edited Course
saveEditCourseBtn.addEventListener('click', function () {
    const courseId = document.getElementById('edit_course_id').value;
    const courseName = document.getElementById('edit_course_name').value;
    const courseDescription = document.getElementById('edit_course_description').value;
    const courseCode = document.getElementById('edit_course_code').value;

    const formData = new FormData();
    formData.append('course_id', courseId);
    formData.append('course_name', courseName);
    formData.append('course_description', courseDescription);
    formData.append('course_code', courseCode);

    fetch('update_course.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast(data.message); // Show toast message
                // Update course in the table dynamically
                const row = document.querySelector(`tr[data-id="${courseId}"]`);
                row.cells[0].textContent = data.course.course_name;
                row.cells[1].textContent = data.course.course_description;
                row.cells[2].textContent = data.course.course_code;
                closeEditModal(); // Close the modal after saving
            } else {
                showToast(data.message); // Show error toast
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});


// Show Toast Function
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.style.display = 'block';
    toast.style.opacity = '1';

    // Fade out after 3 seconds
    setTimeout(() => {
        toast.style.transition = 'opacity 0.5s ease'; // Smooth transition
        toast.style.opacity = '0'; // Hide
    }, 3000);

    // Fully hide the toast after the transition
    setTimeout(() => {
        toast.style.display = 'none';
        toast.style.opacity = '1'; // Reset opacity for the next use
    }, 3500);
}

// Remove Confirmation Modal
var removeConfirmationModal = document.getElementById('removeConfirmationModal');
var closeRemoveModalBtn = document.getElementById('closeRemoveModalBtn');
var cancelRemoveBtn = document.getElementById('cancelRemoveBtn');
var confirmRemoveBtn = document.getElementById('confirmRemoveBtn');
var courseIdToRemove = null;

// Function to show the remove confirmation modal
function showRemoveConfirmation(courseId) {
    courseIdToRemove = courseId;
    removeConfirmationModal.style.display = 'flex';
}

// Confirm removal
confirmRemoveBtn.onclick = function () {
    if (courseIdToRemove) {
        fetch(`remove_course.php?id=${courseIdToRemove}`, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Check if the course row exists before trying to remove it
                    const rowToRemove = document.querySelector(`tr[data-id="${courseIdToRemove}"]`);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }
                    showToast(data.message); // Show success toast
                    closeRemoveConfirmationModal(); // Close modal
                } else {
                    showToast(data.message); // Show error toast
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error removing course. Please try again.');
            });
    }
};

// Close modal events
function closeRemoveConfirmationModal() {
    removeConfirmationModal.style.display = 'none';
}

closeRemoveModalBtn.onclick = cancelRemoveBtn.onclick = function () {
    closeRemoveConfirmationModal();
}

// Close modal when clicking outside
window.onclick = function (event) {
    if (event.target == removeConfirmationModal) {
        closeRemoveConfirmationModal();
    }
}
// Update confirmArchive function similarly
function confirmArchive(courseId) {
    const removeConfirmationModal = document.getElementById("removeConfirmationModal");
    removeConfirmationModal.style.display = "flex";

    // Handle confirmation action
    document.getElementById("confirmRemoveBtn").onclick = function() {
        // Send a request to archive the course
        fetch(`remove_course.php?id=${courseId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Check if the course row exists before trying to remove it
                    const rowToRemove = document.querySelector(`tr[data-id="${courseId}"]`);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }
                    showToast(data.message); // Show success toast
                } else {
                    showToast(data.message); // Show error toast
                }
                closeRemoveConfirmationModal(); // Close modal
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error archiving course. Please try again.');
            });
    };

    // Handle cancel action
    document.getElementById("cancelRemoveBtn").onclick = function() {
        removeConfirmationModal.style.display = "none"; // Hide modal on cancel
    };

    // Close modal when clicking the close button (×)
    document.getElementById("closeRemoveModalBtn").onclick = function() {
        removeConfirmationModal.style.display = "none"; // Hide modal on close
    };
}


