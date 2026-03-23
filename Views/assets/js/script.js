const POPUP_SUPPR = document.querySelectorAll(".popupSuppr");
const BTN_SUPPR = document.querySelectorAll(".bouttonSupprimer");
const BTN_ANNULER_SUPPR = document.querySelectorAll(".annulerSuppr");
const CONFIRMPWD = document.getElementById("confirmPassword");
const BTN_INSCRIPTION = document.getElementById("button-inscription");
const BTN_CONNECTION = document.getElementById("button-connection");
const LABEL_INSCRIPTION = document.getElementById("label-inscription");
const LABEL_CONNECTION = document.getElementById("label-connection");
const BLOCK_CONNECTION = document.getElementById("block-connection");
const BLOCK_INSCRIPTION = document.getElementById("block-inscription");



// Ouvre la popup de confirmation de suppression
BTN_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            btn.style.display = "flex";
        });
    });
});

// Ferme la popup de confirmation de suppresion
BTN_ANNULER_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            btn.style.display = "none";
            CONFIRMPWD.value="";
        });
    });
});

//Switch l'onglet Inscription/Connexion
BTN_INSCRIPTION.addEventListener("click", () => {
    BLOCK_INSCRIPTION.style.display = "flex";
    BLOCK_CONNECTION.style.display = "none";


    BTN_CONNECTION.classList.add("color-green");
    LABEL_CONNECTION.classList.add("color-green");
    BTN_CONNECTION.classList.remove("color-grey");
    LABEL_CONNECTION.classList.remove("color-grey");

    BTN_INSCRIPTION.classList.add("color-grey");
    LABEL_INSCRIPTION.classList.add("color-grey");
    BTN_INSCRIPTION.classList.remove("color-green");
    LABEL_INSCRIPTION.classList.remove("color-green");

    BTN_CONNECTION.style.zIndex = "0";
    BTN_INSCRIPTION.style.zIndex = "2";
})

BTN_CONNECTION.addEventListener("click", () => {
    BLOCK_CONNECTION.style.display = "flex";
    BLOCK_INSCRIPTION.style.display = "none";


    BTN_INSCRIPTION.classList.add("color-green");
    LABEL_INSCRIPTION.classList.add("color-green");
    BTN_INSCRIPTION.classList.remove("color-grey");
    LABEL_INSCRIPTION.classList.remove("color-grey");


    BTN_CONNECTION.classList.add("color-grey");
    LABEL_CONNECTION.classList.add("color-grey");
    BTN_CONNECTION.classList.remove("color-green");
    LABEL_CONNECTION.classList.remove("color-green");

    BTN_INSCRIPTION.style.zIndex = "0";
    BTN_CONNECTION.style.zIndex = "2";
})