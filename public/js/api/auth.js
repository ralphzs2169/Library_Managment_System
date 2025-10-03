import { API_ROUTES } from '../config.js';
import { redirectTo, showError } from '../utils.js';
import { displayInputErrors } from '../helpers.js';

import { BASE_URL } from '../config.js';

export async function loginHandler(username, password) {
  try {
    const response = await fetch(API_ROUTES.LOGIN, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password }),
    });

    const result = await response.json();

    if (result.status === 'success') {
        // Redirect on success
        window.location.href = BASE_URL + 'public/index.php';
    } else {
        if (result.errors){
            displayInputErrors(result.errors);
            return;
        }
    }
  } catch (err) {
    showError("Something went wrong while logging in.");
    console.error(err);
    return null;
  }
}

export async function logoutHandler(){
    try {
      const response = await fetch(API_ROUTES.LOGOUT, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      if (response.ok) {
         const confirm = await swal({
            title: "Are you sure?",
            text: "Once logged out, you will need to log in again.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          });
          if (confirm) redirectTo(BASE_URL + 'views/auth/login.php');
      } else {
       swal({
          title: "Logout Failed",
          text: "Something went wrong while logging out. Please try again.",
          icon: "error",
          button: "OK",
        });
      }
    } catch (error) {
      console.error('Error:', error);
      swal({
        title: "Network Error",
        text: "Unable to connect to the server. Please check your internet connection or try again later.",
        icon: "error",
        button: "OK",
      });
    }
}