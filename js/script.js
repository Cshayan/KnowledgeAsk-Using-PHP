/* Open the sidenav */
function openNav() {
  document.getElementById("mySidenav").style.width = "100%";
}

/* Close/hide the sidenav */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

var picUpload = document.getElementById('picUpload');
console.log(picUpload.innerText);
if (picUpload.innerText === '') {
  picUpload.style.visibility = 'hidden';
} else {
  picUpload.style.visibility = 'visible';
}

// setInterval(function () {
//   if (picUpload.innerText !== '') {
//     picUpload.style.visibility = 'hidden';
//   } 
// }, 3000);

var pass = document.getElementById('pass');
var rePass = document.getElementById('re-pass');

rePass.onkeyup = function () {
  if (pass.value !== "") {
    if (rePass.value !== "") {
      if (pass.value === rePass.value) {
        rePass.style.borderBottomColor = '#55efc4';
        console.log('hi');

      } else {
        rePass.style.borderBottomColor = 'yellow';
      }
    }
  }
}

