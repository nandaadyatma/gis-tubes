$(document).ready(function() {
    $('#login-form').on('submit', function() {
      $('#login-button').prop('disabled', true);
      $('#login-button').html('Logging in... <span class="loading-spinner"></span>');
    });
  });