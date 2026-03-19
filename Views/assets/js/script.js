const POPUP_SUPPR = document.querySelectorAll(".popupSuppr");
const BTN_SUPPR = document.querySelectorAll(".bouttonSupprimer");
const BTN_ANNULER_SUPPR = document.querySelectorAll(".annulerSuppr");
const CONFIRMPWD = document.getElementById("confirmPassword");

BTN_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            btn.style.display = "flex";
        });
    });
});

BTN_ANNULER_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            btn.style.display = "none";
            CONFIRMPWD.value="";
        });
    });
});

