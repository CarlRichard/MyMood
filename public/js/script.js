// SELECTIONNER MES INPUTS ET MON BUTTON
const formStagiaire = document.querySelector("#form_stagiaire");
const inputEmailStagiaire = document.querySelector(".input_email");
const inputPasswordStagiaire = document.querySelector(".input_password");
const buttonSubmit = document.querySelector(".button_submit");

// RECUPERER LA VALEUR DES INPUTS QUAND ON CLICK SUR LE BUTTON
formStagiaire.addEventListener("submit", (event) => {
  event.preventDefault();

  // CONSTRUCTION DE L'OBJET A ENVOYER
  const data = {
    email: inputEmailStagiaire.value,
    password: inputPasswordStagiaire.value,
  };
  console.log(data);

  // ENVOI DES DONNEES AVEC FETCH
  fetch("/login_check", {
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
        console.error("Erreur lors du traitement du token ou de la redirection :", error);
      }
    })
    .catch((error) => {
      console.error("Erreur lors de l'envoi :", error);
    });
});
