var modal = document.getElementById('sectionModal');
var openModalBtn = document.getElementById('openModalBtn');
var closeModalBtn = document.getElementById('closeModalBtn');
var cancelBtn = document.getElementById('cancelBtn');
var editModal = document.getElementById('editSectionModal');
var closeEditModalBtn = document.getElementById('closeEditModalBtn');
var cancelEditBtn = document.getElementById('cancelEditBtn');

// Open Add Section Modal
openModalBtn.onclick = function () {
    modal.style.display = 'flex';
}

// Close Modals
closeModalBtn.onclick = cancelBtn.onclick = function () {
    modal.style.display = 'none';
}

closeEditModalBtn.onclick = cancelEditBtn.onclick = function () {
    editModal.style.display = 'none';
}

// Close Modals on outside click
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    } else if (event.target == editModal) {
        editModal.style.display = 'none';
    }
}

// Fetch Sections from Server
function fetchSections() {
    fetch('fetch_section.php')
        .then(response => response.json())
        .then(data => {
            const sectionsTable = document.getElementById('sectionsTable');
            if (data.length > 0) {
                const tableHTML = `
                    <table>
                        <tr><th>Section</th><th>Grade Level</th><th>Section Code</th><th>Actions</th></tr>
                        ${data.map(row => `
                            <tr>
                                <td>${row.section}</td>
                                <td>${row.grade_level}</td>
                                <td>${row.section_code}</td>
                                <td>
                                    <button class='btn' onclick='openEditModal(${JSON.stringify(row)})'>Edit</button>
                                    <button class='btn btn-remove' onclick='archiveSection(${row.secID})'>Archive</button>
                                </td>
                            </tr>`).join('')}
                    </table>
                `;
                sectionsTable.innerHTML = tableHTML;
            } else {
                sectionsTable.innerHTML = '<p>No sections found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching sections:', error);
            document.getElementById('sectionsTable').innerHTML = '<p>Error loading sections.</p>';
        });
}

// Load Sections on DOMContentLoaded
document.addEventListener('DOMContentLoaded', fetchSections);

// Add Section Logic
document.getElementById('saveSectionBtn').onclick = function () {
    var sectionName = document.getElementById('section_name').value;
    var sectionCode = document.getElementById('section_code').value;
    var sectionGrade = document.getElementById('section_grade').value;

    if (sectionName && sectionCode && sectionGrade) {
        var formData = new FormData();
        formData.append('section_name', sectionName);
        formData.append('section_code', sectionCode);
        formData.append('section_grade', sectionGrade);

        fetch('submit_section.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            showToast(data);
            modal.style.display = 'none';
            fetchSections(); // Reload sections after adding a new section
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while adding the section.');
        });        
    } else {
        showToast('Please fill in all the fields');
    }
}

// Open Edit Section Modal
function openEditModal(section) {
    document.getElementById('edit_section_id').value = section.secID;
    document.getElementById('edit_section_name').value = section.section;
    document.getElementById('edit_section_code').value = section.section_code;
    document.getElementById('edit_section_grade').value = section.grade_level;

    editModal.style.display = 'flex';
}

// Edit Section Logic
document.getElementById('saveEditSectionBtn').onclick = function () {
    var sectionId = document.getElementById('edit_section_id').value;
    var sectionName = document.getElementById('edit_section_name').value;
    var sectionCode = document.getElementById('edit_section_code').value;
    var sectionGrade = document.getElementById('edit_section_grade').value;

    if (sectionName && sectionCode && sectionGrade) {
        var formData = new FormData();
        formData.append('section_id', sectionId);
        formData.append('section_name', sectionName);
        formData.append('section_code', sectionCode);
        formData.append('section_grade', sectionGrade);

        fetch('update_section.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            showToast(data);
            editModal.style.display = 'none';
            fetchSections(); // Reload sections after editing
        })
        .catch(error => console.error('Error:', error));
    } else {
        showToast('Please fill in all the fields');
    }
}

// Toast Notification Function
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Archive Section Logic
function archiveSection(sectionId) {
    if (confirm('Are you sure you want to archive this section?')) {
        fetch(`remove_section.php?id=${sectionId}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            showToast(data);
            fetchSections(); // Reload sections after archiving
        })
        .catch(error => console.error('Error archiving section:', error));
    }
}