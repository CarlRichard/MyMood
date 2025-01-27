// SELECTIONNER MON INPUT TEXT & MES BUTTONS
const formationInputText = document.querySelector("#text");
const formationButtonAdd = document.querySelector(".button_add");
const formationButtonDelete = document.querySelector(".button_formation");

// RECUPERER AU CLICK SUR LE BUTTON LA VALEUR DE L'INPUT QUI NAME FORMATION
// CREER LES ELEMENTS HTML PUIS L'AJOUTER A LA DIV
// SUPPRIMER LES INPUTS SELECTIONNES 
formationButtonAdd.addEventListener("click", function () {
  const userInput = formationInputText.value;

  // créer une div pour contenir le label et le bouton
  const containerLabelInputFormation = document.createElement("div");
  containerLabelInputFormation.classList.add("container_label_input_formation");

  // créer un label
  const labelFormation = document.createElement("label");
  labelFormation.classList.add("formation_label");
  // utiliser la valeur de l'input pour nommer la formation
  labelFormation.textContent = `${userInput}`;

  // créer un input checkbox
  const inputFormation = document.createElement("input");
  inputFormation.classList.add("formation_input");
  inputFormation.type = "checkbox";
  inputFormation.id = "scales";
  inputFormation.name = "scales";

  // ajouter le label et l'input dans le container
  containerLabelInputFormation.appendChild(labelFormation);
  containerLabelInputFormation.appendChild(inputFormation);

  // sélectionner les div qui englobe le tout
  const formationsList = document.querySelector(
    ".container_formations_label_input"
  );
  formationsList.appendChild(containerLabelInputFormation);

  // vider le champ de texte après récupération de la valeur
  formationInputText.value = "";
});

// ajouter un gestionnaire d'événements pour supprimer les formations cochées
formationButtonDelete.addEventListener("click", function () {
  // sélectionner toutes les checkboxes de type checkbox
  const allCheckboxes = document.querySelectorAll(".formation_input");

  // parcourir toutes les checkboxes et supprimer la div si elle est cochée
  allCheckboxes.forEach(function (checkbox) {
    if (checkbox.checked) {
      // Trouver la div parente de cette checkbox (la div qui contient le label et la checkbox)
      const containerDiv = checkbox.closest(".container_label_input_formation");

      // Supprimer la div du DOM
      if (containerDiv) {
        containerDiv.remove();
      }
    }
  });
});
