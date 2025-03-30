function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}
function closeModal(){
    document.getElementById('confirm-modal').style.display = "none";
}
function logout(e){
    e.preventDefault();  
    document.getElementById('logout-form').submit();
}
function attendanceReport(){
    document.getElementById("legend").style.display = "none";
    document.getElementById("report-section").style.display = "none";
    document.getElementById("report-attendance-section").style.display = "flex";
}
function gradeReport(){
    document.getElementById("report-attendance-section").style.display = "none";
    document.getElementById("legend").style.display = "flex";
    document.getElementById("report-section").style.display = "flex";
}