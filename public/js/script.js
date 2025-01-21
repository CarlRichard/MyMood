// RECUPERER LES VALEURS DANS LE FORM
const formStagiaire = document.querySelector("#form_stagiaire");
const inputEmailStagiaire = document.querySelector(".input_email");
const inputPasswordStagiaire = document.querySelector(".input_password");
const inputSubmit = document.querySelector(".input_submit");

// Ajout d'un gestionnaire d'événement sur le bouton submit
formStagiaire.addEventListener("submit", (event) => {
  event.preventDefault();
  const data = {
    email: inputEmailStagiaire.value,
    password: inputPasswordStagiaire.value,
  };

//   "localhost/api/login"
  fetch("", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      response.json();
    })
    .then((result) => {
      console.log(result);
    })
    .catch((error) => {
      console.error(error);
    });
});
