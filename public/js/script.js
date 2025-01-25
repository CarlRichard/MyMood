// SELECTIONNER MES INPUTS, MON BUTTON & MA SECTION
const formStagiaire = document.querySelector("#form_stagiaire");
const inputEmailStagiaire = document.querySelector(".input_email");
const inputPasswordStagiaire = document.querySelector(".input_password");
const buttonSubmit = document.querySelector(".button_submit");
const main = document.querySelector("main");

// RECUPERER LA VALEUR DES INPUTS ET L'ENVOYER QUAND ON CLICK SUR LE BUTTON
formStagiaire.addEventListener("submit", (event) => {
  // event.preventDefault();

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
    // convertir les données en JSON
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((result) => {
      console.log("Données envoyées avec succès :", result);
      try {
        // Stocker le token dans localStorage
        localStorage.setItem("tokenUser", result.tokenUser);

        // Rediriger vers une autre page
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
