const POPUP_SUPPR = document.getElementById("popupSupprProjet");
const BTN_SUPPR_PROJET = document.getElementById("supprimerProjet");
const BTN_ANNULER_SUPPR = document.getElementById("annulerSupprimer");


BTN_SUPPR_PROJET.addEventListener("click", () => {

    POPUP_SUPPR.style.display="flex";

})

BTN_ANNULER_SUPPR.addEventListener("click", () => {

    POPUP_SUPPR.style.display="none";

})