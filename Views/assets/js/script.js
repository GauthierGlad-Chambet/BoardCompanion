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
const ICONES_MENU = document.querySelectorAll(".icones-menu");
const FORM_SELECT = document.querySelectorAll('.form-select select');
const PAGE_CONTAINER = document.querySelector('.page-container');
const FOOTER = document.getElementsByTagName('footer')[0];
const HEADER = document.getElementsByTagName('header')[0];

let popupSupprProjetFlag = 0;

// Mise en évidence de l'onglet actif
document.addEventListener('DOMContentLoaded', () => {
    
    ICONES_MENU.forEach(link => {
        // On récupère l'URL du lien du bouton et l'url de la page
        const linkUrl = new URL(link.href);
        const currentUrl = new URL(window.location.href);

        // Compare le pathname ET les paramètres GET
        if (linkUrl.pathname === currentUrl.pathname && 
            linkUrl.search === currentUrl.search) {
            link.classList.add('menu-active');
        }
    });
});

// Permet d'envoyer les formulaire de select directement sans bouton
FORM_SELECT.forEach(select => {
    select.addEventListener('change', function() {
        this.closest('form').submit();
    });
});




// Ouvre la popup de confirmation de suppression
BTN_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            popupSupprProjetFlag = 1;
            btn.style.display = "flex";
            PAGE_CONTAINER.setAttribute('inert', '');
            PAGE_CONTAINER.style.filter = "opacity(0.4)";
            FOOTER.style.filter = "opacity(0.4)";
            FOOTER.setAttribute('inert', '');
            HEADER.style.filter = "opacity(0.4)";
            HEADER.setAttribute('inert', '');
        });
    });
});

// Ferme la popup de confirmation de suppresion
BTN_ANNULER_SUPPR.forEach(btn => {
    btn.addEventListener("click", () => {
        POPUP_SUPPR.forEach(btn =>{
            btn.style.display = "none";
            if(popupSupprProjetFlag == 0) {
                CONFIRMPWD.value="";
            }
            PAGE_CONTAINER.removeAttribute('inert');
            PAGE_CONTAINER.style.filter = "none";
            FOOTER.removeAttribute('inert');
            FOOTER.style.filter = "none";
            HEADER.removeAttribute('inert');
            HEADER.style.filter = "none";
            popupSupprProjetFlag = 0;
        });
    });
});




//Switch l'onglet Inscription/Connexion
try {
    BTN_INSCRIPTION.addEventListener("click", () => {
        BLOCK_INSCRIPTION.style.display = "flex";
        BLOCK_CONNECTION.style.display = "none";
    
        BTN_CONNECTION.classList.add("color-green");
        BTN_CONNECTION.classList.remove("color-grey");
    
        BTN_INSCRIPTION.classList.add("color-grey");
        BTN_INSCRIPTION.classList.remove("color-green");
    
        BTN_CONNECTION.style.zIndex = "0";
        BTN_INSCRIPTION.style.zIndex = "2";
    })
    
    BTN_CONNECTION.addEventListener("click", () => {
        BLOCK_CONNECTION.style.display = "flex";
        BLOCK_INSCRIPTION.style.display = "none";
    
    
        BTN_INSCRIPTION.classList.add("color-green");
        BTN_INSCRIPTION.classList.remove("color-grey");
    
        BTN_CONNECTION.classList.add("color-grey");
        BTN_CONNECTION.classList.remove("color-green");
    
    
        BTN_INSCRIPTION.style.zIndex = "0";
        BTN_CONNECTION.style.zIndex = "2";
    })
} catch (warn) {
  console.warn("Une erreur s'est produite dans login :", warn);
}


