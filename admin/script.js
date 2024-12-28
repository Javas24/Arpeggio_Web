// JavaScript for modal
window.onload = function() {
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var form = document.getElementById("registerForm");

    // When the form is submitted, display the modal
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        modal.style.display = "block";
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
};
