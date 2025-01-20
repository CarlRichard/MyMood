const loginData = {
    username: 'Admin@admin.com',
    password: 'admin'
};
  
  fetch('https://localhost/api/login_check', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(loginData)  // Convertit l'objet JavaScript en JSON
  })
    .then(response => response.json())
    .then(data => {
      if (data.token) {
        // Stocker le token JWT dans localStorage ou sessionStorage
        localStorage.setItem('jwt_token', data.token);
        console.log('Login successful:', data);
      } else {
        console.error('Login failed:', data.message);
      }
    })
    .catch(error => console.error('Error:', error));
  