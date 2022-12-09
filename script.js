document.querySelector("#fileUpload").onchange = function () 
{
  document.querySelector("#fileName").textContent = this.files[0].name;
    document.querySelector("#fileSize").textContent = this.files[0].size + " bytes";
  
  document.querySelector("#fileName2").textContent = this.files[1].name;
    document.querySelector("#fileSize2").textContent = this.files[1].size + " bytes";
  
  document.querySelector("#fileName3").textContent = this.files[2].name;
    document.querySelector("#fileSize3").textContent = this.files[2].size + " bytes";
};

function convert()
{
  
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("AboutUs");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function(e) {
  modal.style.display = "block";
  e.preventDefault();
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}