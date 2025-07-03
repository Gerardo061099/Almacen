/**
 *
 */

/**
 *
 */
$(document).ready(function () {
  $(document).on("change", "#Check1", (e) => {
    let chekbox = document.getElementById("Check1");
    let keypass = document.getElementById("keypass");
    if (chekbox.checked === true) {
      keypass.type = "text";
    } else {
      keypass.type = "password";
    }
  });
});
