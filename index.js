$(document).ready(function() {
  // Show/hide additional fields based on selected type
  $('#type').change(function() {
    var selectedType = $(this).val();

    // Hide all dynamic fields
    $('#book-fields, #dvd-fields, #furniture-fields').addClass('hidden');

    // Show fields based on the selected type
    if (selectedType === 'book') {
      $('#book-fields').removeClass('hidden');
    } else if (selectedType === 'dvd') {
      $('#dvd-fields').removeClass('hidden');
    } else if (selectedType === 'furniture') {
      $('#furniture-fields').removeClass('hidden');
    }
  });

  // SKU field change event
  $('#sku').change(function() {
    var sku = $(this).val();
    var warningDiv = $('#warning');

    // Check if SKU is empty
    if (sku === "") {
      warningDiv.text("SKU field is required");
      warningDiv.show();
      return;
    }

    // Make an AJAX request to check if the SKU is already used
    $.ajax({
      url: './Product/checkSku.php', // Replace with the actual URL for checking SKU
      type: 'POST',
      data: { sku: sku },
      success: function(response) {
        var responseData = JSON.parse(response);
      
        if (responseData.status === "exists") {
          warningDiv.text("SKU is already used for a different product");
          warningDiv.show();
        } else {
          warningDiv.hide();
        }
      },
      
      error: function() {
        warningDiv.text("Error occurred while checking SKU");
        warningDiv.show();
      }
    });
  });
}); // <-- Closing bracket for $(document).ready() function



function validateForm() {
  
  var type = document.getElementById("type").value;
  var warningDiv = document.getElementById("warning");

  // Check if type is selected
  if (type === "") {
    warningDiv.textContent = "Please select a type";
    warningDiv.style.display = "block";
    return false;
  }

  // Check SKU, Name, and Price fields
  var sku = document.getElementById("sku").value;
  var name = document.getElementById("name").value;
  var price = document.getElementById("price").value;

  if (sku === "" || name === "" || price === "") {
    warningDiv.textContent = "SKU, Name, and Price fields are required";
    warningDiv.style.display = "block";
    return false;
  }

  // Check if price is a valid number
  if (isNaN(parseFloat(price))) {
    warningDiv.textContent = "Please, provide the data of indicated type";
    warningDiv.style.display = "block";
    return false;
  }

  // Check required fields based on type
  if (type === "book") {
    var weight = document.getElementById("weight").value;
    if (weight !== "" && isNaN(parseFloat(weight))) {
      warningDiv.textContent = "Please, provide the data of indicated type";
      warningDiv.style.display = "block";
      return false;
    }
  } else if (type === "dvd") {
    var size = document.getElementById("size").value;
    if (size !== "" && isNaN(parseFloat(size))) {
      warningDiv.textContent = "Please, provide the data of indicated type";
      warningDiv.style.display = "block";
      return false;
    }
  } else if (type === "furniture") {
    var height = document.getElementById("height").value;
    var width = document.getElementById("width").value;
    var length = document.getElementById("length").value;

    if (
      (height !== "" && isNaN(parseFloat(height))) ||
      (width !== "" && isNaN(parseFloat(width))) ||
      (length !== "" && isNaN(parseFloat(length)))
    ) {
      warningDiv.textContent = "Please, provide the data of indicated type";
      warningDiv.style.display = "block";
      return false;
    }
  }

  warningDiv.style.display = "none"; // Hide the warning div if all validations pass
  return true; // Submit the form if all validations pass
}
