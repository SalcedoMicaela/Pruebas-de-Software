document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('./scriptsphp/login.php',{
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if(result.success == false){
            errorLogin();
        }else{
            window.location.href = './php/indexAdmin.php';
        }
    } catch (error) {
        console.error('Error de incio de sesion',error);
    }
    
});
function errorLogin(){
    const alertElement = document.getElementById('alertLogin');
    alertElement.classList.remove('d-none');
    alertElement.classList.add('show');
    alertElement.classList.remove('fade');  
    setTimeout(() => {
        alertElement.classList.remove('show');  
        alertElement.classList.add('fade');
        setTimeout(() => {
            alertElement.classList.add('d-none');
        }, 150);
    }, 2000);
}

document.addEventListener('keydown', function(e) {
    if ( e.key === 'c' && e.key === 'v') { // Combinación de teclas Ctrl + Shift + S
      e.preventDefault(); // Prevenir la acción predeterminada del navegador
      const secretModal = new bootstrap.Modal(document.getElementById('secretModal'));
      secretModal.show();
    }
});

// document.getElementById('superUserForm').addEventListener('submit', async function(e) {
//     e.preventDefault(); // Prevenir la acción predeterminada del formulario
  
//     const username = document.getElementById('super-username').value;
//     const password = document.getElementById('super-password').value;
  
//     const formData = new URLSearchParams({
//       action: 'createSuperUser',
//       username: username,
//       password: password
//     });
  
//     try {
//       const response = await fetch('./crudPHP/backUsuarios.php', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/x-www-form-urlencoded'
//         },
//         body: formData.toString()
//       });
  
//       const result = await response.json();
  
//       if (result.status === 'success') {
//         alert(result.message);
//         document.getElementById('superUserForm').reset(); // Limpiar el formulario
//         const secretModal = bootstrap.Modal.getInstance(document.getElementById('secretModal'));
//         secretModal.hide(); // Ocultar el modal
//       } else {
//         alert(result.message);
//       }
//     } catch (error) {
//       console.error('Error:', error);
//       alert('An error occurred while creating the super user.');
//     }
//   });
//errorLogin();
