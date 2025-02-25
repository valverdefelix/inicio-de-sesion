<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://firebasestorage.googleapis.com/v0/b/dulceria-743f5.appspot.com/o/xd.jpeg?alt=media&token=812c3bed-4c04-4225-8341-dc67257cc078');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(48, 46, 46, 0.9);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: white;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .toggle {
            margin-top: 20px;
            cursor: pointer;
            color: #007BFF;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 id="form-title">Iniciar Sesión</h1>
        <form id="login-form">
            <input type="email" id="email" placeholder="Correo electrónico" required>
            <input type="password" id="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
            <div class="error" id="error-message"></div>
        </form>

        <form id="register-form" style="display:none;">
            <input type="email" id="register-email" placeholder="Correo electrónico" required>
            <input type="password" id="register-password" placeholder="Contraseña" required>
            <button type="submit">Registrar</button>
            <div class="error" id="register-error"></div>
        </form>

        <div class="toggle" id="toggle-link">¿No tienes una cuenta? Regístrate</div>
    </div>

    <script>
        // Configura tu Firebase
        const firebaseConfig = {
  apiKey: "AIzaSyCbm36BVR9F82jx3P_zxHoMkNMqav_dQW4",
  authDomain: "saul-5535c.firebaseapp.com",
  projectId: "saul-5535c",
  storageBucket: "saul-5535c.firebasestorage.app",
  messagingSenderId: "559056639182",
  appId: "1:559056639182:web:51aafa5dcd9f1d7c0bac9f"
};

        // Inicializa Firebase
        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();

        // Manejo del inicio de sesión
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            auth.signInWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;

                    // Verifica si es el superusuario
                    if (email === "root@gmail.com") {
                        window.location.href = "bitacora_calificacion.html"; 
                    } else {
                        alert('Inicio de sesión exitoso');
                        window.location.href = "inicio_pagina.html"; 
                    }
                })
                .catch((error) => {
                    const errorMessage = error.message;
                    document.getElementById('error-message').textContent = errorMessage;
                });
        });

        // Manejo del registro de usuario
        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;

            auth.createUserWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    user.sendEmailVerification()
                        .then(() => {
                            alert('Registro exitoso. Se ha enviado un correo de verificación a ' + email);
                            // Redirigir al formulario de inicio de sesión después de un breve retraso
                            setTimeout(() => {
                                const loginForm = document.getElementById('login-form');
                                const registerForm = document.getElementById('register-form');
                                const formTitle = document.getElementById('form-title');
                                loginForm.style.display = "block";
                                registerForm.style.display = "none";
                                formTitle.textContent = "Iniciar Sesión";
                                document.getElementById('toggle-link').textContent = "¿No tienes una cuenta? Regístrate";
                            }, 2000); // Espera 2 segundos antes de redirigir
                        })
                        .catch((error) => {
                            const errorMessage = error.message;
                            document.getElementById('register-error').textContent = errorMessage;
                        });
                })
                .catch((error) => {
                    const errorMessage = error.message;
                    document.getElementById('register-error').textContent = errorMessage;
                });
        });

        // Cambio entre formularios
        document.getElementById('toggle-link').addEventListener('click', function() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const formTitle = document.getElementById('form-title');

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                formTitle.textContent = "Iniciar Sesión";
                this.textContent = "¿No tienes una cuenta? Regístrate";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                formTitle.textContent = "Registrar Usuario";
                this.textContent = "¿Ya tienes una cuenta? Inicia sesión";
            }
        });
    </script>

</body>

</html>
