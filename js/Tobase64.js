/**
 *
 */

/**
 *
 */
export function base64(file) {
  return new Promise((resolve) => {
    const reader = new FileReader();
    reader.addEventListener("loadend", () => {
      resolve(reader.result);
    });
    reader.readAsDataURL(file);
  });
}
