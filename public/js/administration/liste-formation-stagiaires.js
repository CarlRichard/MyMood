// LES FORMATIONS :
// SELECTIONNER MON INPUT TEXT & MES BUTTONS
const formationInputText = document.querySelector("#text");
const formationButtonAdd = document.querySelector(".button_add");
const formationButtonDelete = document.querySelector(".button_formation");

// RECUPERER AU CLICK SUR LE BUTTON LA VALEUR DE L'INPUT QUI NAME FORMATION ET CREER LES ELEMENTS HTML PUIS L'AJOUTER A LA DIV
formationButtonAdd.addEventListener("click", function () {
  const userInput = formationInputText.value;
  
  // créer une div pour contenir le label et le bouton
  const containerLabelInputFormation = document.createElement("div");
  containerLabelInputFormation.classList.add("container_label_input_formation");

  // créer un label
  const labelFormation = document.createElement("label");
  labelFormation.classList.add("formation_label");
  // Utiliser la valeur de l'input pour nommer la formation
  labelFormation.textContent = `${userInput}`;

  // créer un input checkbox
  const inputFormation = document.createElement("input");
  inputFormation.classList.add("formation_input");
  inputFormation.type = "checkbox";
  inputFormation.id = "scales";
  inputFormation.name = "scales";

  // ajouter un gestionnaire d'événements pour vérifier si la checkbox est sélectionnée
  inputFormation.addEventListener("change", function () {
    if (inputFormation.checked) {
      console.log(`${labelFormation.textContent} est sélectionnée.`);
    } else {
      console.log(`${labelFormation.textContent} n'est pas sélectionnée.`);
    }
  });

  // ajouter le label et l'input dans le container
  containerLabelInputFormation.appendChild(labelFormation);
  containerLabelInputFormation.appendChild(inputFormation);

  // sélectionner la div qui englobe le tout
  const formationsList = document.querySelector(".container_formations_label_input");
  formationsList.appendChild(containerLabelInputFormation);

  // vider le champ de texte après récupération de la valeur
  formationInputText.value = "";
});

