function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById('confirm-modal').style.display = "none";
}

function logout(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}
