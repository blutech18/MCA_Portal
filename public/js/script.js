document.addEventListener("DOMContentLoaded", function () {
    const inputEmail = document.getElementById("email");
    const inputPass = document.getElementById("password");
    const lockPic = document.querySelector(".lock");
    const emailPic = document.querySelector(".email");

    inputEmail.addEventListener("focus", function () {
        emailPic.style.display = "none";
    });

    inputPass.addEventListener("focus", function () {
        lockPic.style.display = "none";
    });

    inputEmail.addEventListener("blur", function () {
        if (inputEmail.value.trim() === "") {
            emailPic.style.display = "block";
        }
    });

    inputPass.addEventListener("blur", function () {
        if (inputPass.value.trim() === "") {
            lockPic.style.display = "block";
        }
    });
});

