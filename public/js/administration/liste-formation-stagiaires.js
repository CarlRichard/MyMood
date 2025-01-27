// SELECTIONNER MON INPUT TEXT & MES BUTTONS
const formationInputText = document.querySelector("#text");
const formationButtonAdd = document.querySelector(".button_add");
const formationButtonDelete = document.querySelector(".button_formation");

const formationInputFirstName = document.querySelector("#first-name");
const formationInputName = document.querySelector("#name");
const formationInputEmail = document.querySelector("#email");
const formationButtonAddIntern = document.querySelector("#stagiaire_button_add");

// RECUPERER AU CLICK SUR LE BUTTON LA VALEUR DE L'INPUT QUI NAME FORMATION
// CREER LES ELEMENTS HTML PUIS L'AJOUTER A LA DIV
// SUPPRIMER LES INPUTS SELECTIONNES 
formationButtonAdd.addEventListener("click", function () {
  const userInput = formationInputText.value;

  // Vérifier si l'input est vide
  if (!userInput.trim()) {
    // Afficher une alerte si le champ est vide
    alert("Le nom de la formation est requis !");
    return; // Sortir de la fonction si l'input est vide
  }

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



// RECUPERER LA VALEUR DES INPUTS TEXT (PRENOM, NOM, ADRESSE MAIL)
formationButtonAddIntern.addEventListener("click", function () {
  const userFormationInputFirstName = formationInputFirstName.value;
  const userFormationInputName = formationInputName.value;
  const userFormationInputEmail = formationInputEmail.value;

  // Vérification des champs
  if (!userFormationInputFirstName) {
    alert("Le prénom est requis !");
    return; 
  }

  if (!userFormationInputName) {
    alert("Le nom est requis !");
    return;
  }

  if (!userFormationInputEmail) {
    alert("L'email est requis !");
    return;
  }

  // Si tous les champs sont remplis, on peut afficher les valeurs dans la console
  console.log(userFormationInputFirstName, userFormationInputName, userFormationInputEmail);
});


