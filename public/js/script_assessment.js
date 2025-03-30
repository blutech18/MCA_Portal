function confirmExit() {
    document.getElementById("confirm-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("confirm-modal").style.display = "none";
}

function goToResult() {
    let resultRoute = document.querySelector(".submit-btn").getAttribute("data-result-route");
    window.location.href = resultRoute; // Redirect to result page
}


function exitAssessment() {
    let exitRoute = document.querySelector(".button-back").getAttribute("data-route");
    window.location.href = exitRoute; // Redirect to the assessment page
}
