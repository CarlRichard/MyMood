// SELECTIONNER MES INPUTS, MON BUTTON & MA SECTION
const formStagiaire = document.querySelector("#form_stagiaire");
const inputEmailStagiaire = document.querySelector(".input_email");
const inputPasswordStagiaire = document.querySelector(".input_password");
const buttonSubmit = document.querySelector(".button_submit");
const sectionError = document.querySelector(".section_error_msg");
const main = document.querySelector("main");

// RECUPERER LA VALEUR DES INPUTS ET L'ENVOYER QUAND ON CLICK SUR LE BUTTON
formStagiaire.addEventListener("submit", (event) => {

  // initialisation des tableaux des messages d'erreur
  let errorMessageEmail = "";
  let errorMessageMp = "";

  // si des erreurs, les afficher et arrêter l'envoi du formulaire
  if (!inputEmailStagiaire.value) {
    errorMessageEmail += `Veuillez entrer votre email !`;
  }
  if (!inputPasswordStagiaire.value) {
    errorMessageMp += `Veuillez entrer votre mots de passe !`;
  }
  if (errorMessageEmail) {
    const errorElement = document.createElement("p");
    errorElement.classList.add("message_error");
    errorElement.textContent = errorMessageEmail;
    sectionError.appendChild(errorElement);
    main.appendChild(sectionError);
  }
  if (errorMessageMp) {
    const errorElement2 = document.createElement("p");
    errorElement2.classList.add("message_error");
    errorElement2.textContent = errorMessageMp;
    sectionError.appendChild(errorElement2);
    main.appendChild(sectionError);
    return;
  } 
  

  // CONSTRUCTION DE L'OBJET A ENVOYER
  const data = {
    email: inputEmailStagiaire.value,
    password: inputPasswordStagiaire.value,
  };
  console.log(data);

  // ENVOI DES DONNEES AVEC FETCH
  fetch("localhost/login_check", {
    // méthode POST pour envoyer les données
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    // convertion des données en JSON
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((result) => {
      console.log("Données envoyées avec succès :", result);
      try {
        // stocker le token dans localStorage
        localStorage.setItem("tokenUser", result.tokenUser);

        // redirection vers la page mymood
        window.location.href = "../pages/stagiaires/mymood.html";
      } catch (error) {
        console.error(
          "Erreur lors du traitement du token ou de la redirection :",
          error
        );
        const errorMessage = document.createElement("p");
        errorMessage.classList.add('message_error');
        errorMessage.textContent = "Identifiant ou mots de passe incorrect.";
        main.appendChild(errorMessage);
      }
    })
    .catch((error) => {
      console.error("Erreur lors de l'envoi :", error);
    });
});
