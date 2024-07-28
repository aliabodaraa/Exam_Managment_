export function isFileValid(file: File) {
  if (!file || !file?.name) {
    showAlert('file or its name is empty');
    return false;
  }
  if (!isSuffixAllowed(file.name)) {
    showAlert(
      'please select only images where they end with one of the following suffixces : jpeg, jpg, png'
    );
    return false;
  }
  return true;
}
function showAlert(mssg: string) {
  alert(mssg);
}
function isSuffixAllowed(file_name: string) {
  const suffixesAllowed = ['png', 'gpg', 'jpeg'];
  let is_allowed = false;
  suffixesAllowed.forEach((suffix) => {
    if (file_name.endsWith(suffix)) {
      is_allowed = true;
    }
  });
  return is_allowed;
}
