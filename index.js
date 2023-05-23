$(document).ready(function() {
    // Show/hide additional fields based on selected type
    $('#type').change(function() {
      var type = $(this).val();
  
      // Define object with keys as types and values as field IDs
      var fieldIDs = {
        'book': '#book-fields',
        'dvd': '#dvd-fields',
        'furniture': '#furniture-fields'
      };
  
      // Hide all additional fields initially
      $('.hidden').hide();
  
      // Show additional fields based on selected type
      if (fieldIDs[type]) {
        $(fieldIDs[type]).show();
      }
    });
  
  });