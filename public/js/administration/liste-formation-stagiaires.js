// SELECTIONNER MON INPUT TEXT & MES BUTTONS
const formationInputText = document.querySelector("#text");
const formationButtonAdd = document.querySelector(".button_add");
const formationButtonDelete = document.querySelector(".button_formation");

// RECUPERER AU CLICK SUR LE BUTTON LA VALEUR DE L'INPUT QUI NAME FORMATION & CREER LES ELEMENTS HTML PUIS L'AJOUTER A LA DIV
formationButtonAdd.addEventListener("click", function () {
  const userInput = formationInputText.value;

  // Créer une div pour contenir le label et le bouton
  const containerLabelInputFormation = document.createElement("div");
  containerLabelInputFormation.classList.add("container_label_input_formation");

  // Créer un label
  const labelFormation = document.createElement("label");
  labelFormation.classList.add("formation_label");
  // Utiliser la valeur de l'input pour nommer la formation
  labelFormation.textContent = `${userInput}`;

  // Créer un input checkbox
  const inputFormation = document.createElement("input");
  inputFormation.classList.add("formation_input");
  inputFormation.type = "checkbox";
  inputFormation.id = "scales";
  inputFormation.name = "scales";

  // Ajouter le label et l'input dans le container
  containerLabelInputFormation.appendChild(labelFormation);
  containerLabelInputFormation.appendChild(inputFormation);

  // Sélectionner les div qui englobe le tout
  const formationsList = document.querySelectorAll(
    ".container_formations_label_input"
  );
  formationsList.appendChild(containerLabelInputFormation);

  // Vider le champ de texte après récupération de la valeur
  formationInputText.value = "";
});

// Ajouter un gestionnaire d'événements pour supprimer les formations cochées
formationButtonDelete.addEventListener("click", function () {
  // Sélectionner toutes les checkboxes de type checkbox
  const allCheckboxes = document.querySelectorAll(".formation_input");

  // Parcourir toutes les checkboxes et supprimer la div si elle est cochée
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
