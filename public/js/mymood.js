// SELECTIONNER 
const slider = document.querySelector('.slider'); // Sélection de l'input range
const moodButton = document.querySelector('.humeur_button'); // Sélection du bouton

moodButton.addEventListener('click', () => {
  const sliderValue = slider.value; 
  console.log(`Valeur actuelle du slider : ${sliderValue}`);
});
