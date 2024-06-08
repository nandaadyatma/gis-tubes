document.addEventListener('DOMContentLoaded', function() {
    // Show modal dialog initially
    const modalDialog = document.getElementById('modal-dialog');
    
    // Set a timeout to hide the modal after 2 seconds
    setTimeout(function() {
        modalDialog.classList.add('hidden');
    }, 1500); // 2000 milliseconds = 2 seconds
});
