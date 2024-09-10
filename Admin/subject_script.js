var modal = document.getElementById('subjectModal');
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


document.getElementById('saveSubjectBtn').onclick = function () {
    var subjectName = document.getElementById('subject_name').value;
    var subjectCode = document.getElementById('subject_code').value;
    var gradeLevel = document.getElementById('grade_level').value;

    if (subjectName && gradeLevel && subjectCode) {
        var formData = new FormData();
        formData.append('subject_name', subjectName);
        formData.append('subject_code', subjectCode);
        formData.append('grade_level', gradeLevel);

        fetch('submit_subject.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                modal.style.display = 'none';
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert('Please fill in all the fields');
    }
}


const editSubjectModal = document.getElementById('editSubjectModal');
const closeEditModalBtn = document.getElementById('closeEditModalBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const saveEditSubjectBtn = document.getElementById('saveEditSubjectBtn');

function openEditModal(subject) {
    document.getElementById('edit_subject_id').value = subject.subID;  
    document.getElementById('edit_subject_name').value = subject.subject;  
    document.getElementById('edit_subject_code').value = subject.subject_code;  
    document.getElementById('edit_grade_level').value = subject.grade_level;  

    editSubjectModal.style.display = 'flex';
}



function closeEditModal() {

    editSubjectModal.style.display = 'none';
}

closeEditModalBtn.addEventListener('click', closeEditModal);
cancelEditBtn.addEventListener('click', closeEditModal);


document.getElementById('saveEditSubjectBtn').addEventListener('click', function() {
    
    const subjectId = document.getElementById('edit_subject_id').value;
    const subjectName = document.getElementById('edit_subject_name').value;
    const subjectCode = document.getElementById('edit_subject_code').value;
    const gradeLevel = document.getElementById('edit_grade_level').value;

    const formData = new FormData();
    formData.append('subject_id', subjectId);
    formData.append('subject_name', subjectName);
    formData.append('subject_code', subjectCode);
    formData.append('grade_level', gradeLevel);

    fetch('update_subject.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

var removeConfirmationModal = document.getElementById('removeConfirmationModal');
var closeRemoveModalBtn = document.getElementById('closeRemoveModalBtn');
var cancelRemoveBtn = document.getElementById('cancelRemoveBtn');
var confirmRemoveBtn = document.getElementById('confirmRemoveBtn');
var subjectIdToRemove = null;

// Function to show the remove confirmation modal
function showRemoveConfirmation(subID) {
    subjectIdToRemove = subID;
    removeConfirmationModal.style.display = 'flex';
}

// Function to close the remove confirmation modal
function closeRemoveConfirmationModal() {
    removeConfirmationModal.style.display = 'none';
}

// Confirm removal
confirmRemoveBtn.onclick = function() {
    if (subjectIdToRemove) {
        location.href = "remove_subject.php?id=" + subjectIdToRemove;
    }
}

// Close modal events
closeRemoveModalBtn.onclick = cancelRemoveBtn.onclick = function () {
    closeRemoveConfirmationModal();
}

// Close modal when clicking outside
window.onclick = function (event) {
    if (event.target == removeConfirmationModal) {
        closeRemoveConfirmationModal();
    }
}


