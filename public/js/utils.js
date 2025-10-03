export function showError(message) {
  Swal.fire({
    title: "Error",
    text: message,
    icon: "error"
  });
}

export function showSuccess(message) {
  Swal.fire({
    title: "Success",
    text: message,
    icon: "success"
  });
}

export async function showSuccessWithRedirect(title, text, redirectUrl) {
  const result = await Swal.fire({
    title: title,
    text: text,
    icon: "success",
    confirmButtonText: "OK"
  });
  
  if (result.isConfirmed) {
    redirectTo(redirectUrl);
  }
}

export function redirectTo(path) {
  window.location.href = path;
}