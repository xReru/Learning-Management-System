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