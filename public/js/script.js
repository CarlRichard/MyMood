// SELECTIONNER MES INPUTS, MON BUTTON & MA SECTION
const formStagiaire = document.querySelector("#form_stagiaire");
const inputEmailStagiaire = document.querySelector(".input_email");
const inputPasswordStagiaire = document.querySelector(".input_password");
const sectionError = document.querySelector(".section_error_msg");
const main = document.querySelector("main");

// RECUPERER LA VALEUR DES INPUTS ET L'ENVOYER QUAND ON CLICK SUR LE BUTTON
formStagiaire.addEventListener("submit", (event) => {
  event.preventDefault();
  
  // Réinitialisation de la section des erreurs avant d'ajouter les nouvelles erreurs
  sectionError.innerHTML = "";
  
  // Initialisation des tableaux des messages d'erreur
  let errorMessageEmail = "";
  let errorMessageMp = "";

  // Vérification des erreurs dans les champs
  if (!inputEmailStagiaire.value) {
    errorMessageEmail += "Veuillez entrer votre email !";
  }
  if (!inputPasswordStagiaire.value) {
    errorMessageMp += "Veuillez entrer votre mots de passe !";
  }

  // Affichage des messages d'erreur si nécessaire
  if (errorMessageEmail) {
    const errorElement = document.createElement("p");
    errorElement.classList.add("message_error");
    errorElement.textContent = errorMessageEmail;
    sectionError.appendChild(errorElement);
  }
  if (errorMessageMp) {
    const errorElement2 = document.createElement("p");
    errorElement2.classList.add("message_error");
    errorElement2.textContent = errorMessageMp;
    sectionError.appendChild(errorElement2);
  }

  // Si des erreurs existent, on arrête l'envoi du formulaire
  if (errorMessageEmail || errorMessageMp) {
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
  fetch("/api/login_check", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((result) => {
      console.log("Données envoyées avec succès :", result);
      try {
        // Stocker le token dans localStorage
        localStorage.setItem("tokenUser", result.tokenUser);

        // Redirection vers la page mymood
        window.location.href = "../pages/stagiaires/mymood.html";
      } catch (error) {
        console.error("Erreur lors du traitement du token ou de la redirection :", error);
        const errorMessage = document.createElement("p");
        errorMessage.classList.add('message_error');
        errorMessage.textContent = "Identifiant ou mot de passe incorrect.";
        main.appendChild(errorMessage);
      }
    })
    .catch((error) => {
      console.error("Erreur lors de l'envoi :", error);
    });
});
