function showAddUserModal() {
    document.getElementById("formUser").reset();
    document.getElementById("modalTitle").innerText = "Add New User";
    document.getElementById("userId").value = "";

    document.getElementById("userModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeUserModal() {
    document.getElementById("userModal").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}