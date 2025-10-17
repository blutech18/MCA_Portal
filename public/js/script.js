/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
document.addEventListener("DOMContentLoaded", function () {
    const inputUsername = document.getElementById("username");
    const inputPass = document.getElementById("password");
    const lockPic = document.querySelector(".lock");
    const usernamePic = document.querySelector(".email");

    inputUsername.addEventListener("focus", function () {
        usernamePic.style.display = "none";
    });

    inputPass.addEventListener("focus", function () {
        lockPic.style.display = "none";
    });

    inputUsername.addEventListener("blur", function () {
        if (inputEmail.value.trim() === "") {
            usernamePic.style.display = "block";
        }
    });

    inputPass.addEventListener("blur", function () {
        if (inputPass.value.trim() === "") {
            lockPic.style.display = "block";
        }
    });
});

