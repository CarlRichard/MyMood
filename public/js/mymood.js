// SELECTIONNER MON SLIDER, MON BUTTON & MON LIEN
const slider = document.querySelector('.slider'); 
const moodButton = document.querySelector('.humeur_button'); 
const moodLink = document.querySelector('.humeur_container_appel'); 

// RECUPERER LA VALEUR DU SLIDER ET L'ENVOYER QUAND ON CLICK SUR LE BUTTON
moodButton.addEventListener('click', () => {
  const sliderValue = slider.value; 
  console.log(`Valeur du slider avec le button : ${sliderValue}`);
});

// RECUPERER LA VALEUR DU SLIDER ET L'ENVOYER QUAND ON CLICK SUR LE LIEN SOS
moodLink.addEventListener('click', () => {
  const sliderValue = slider.value; 
  console.log(`Valeur du slider avec le lien sos : ${sliderValue}`);
});
