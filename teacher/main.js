const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");
const container = document.querySelector(".container");

registerBtn.onclick = function () {
    container.classList.add("active");
};

loginBtn.onclick = function () {
    container.classList.remove("active");
};
