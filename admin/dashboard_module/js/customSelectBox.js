// Event listener to close the select box when clicking outside
document.addEventListener('click', function (event) {
    var selectBox = document.querySelector('.custom-select');
    var selectBoxDropdown = document.querySelector('.options');

    // Check if the click is outside the select box or its dropdown options
    if (!selectBox.contains(event.target) && !selectBoxDropdown.contains(event.target)) {
        selectBox.classList.remove('open');  // Close the select box
        selectBox.classList.remove('focused');  // Remove focus when clicked outside
    }
});

// Open the select box when the user clicks on the selected option
document.querySelector('.selected-option').addEventListener('click', function (event) {
    event.stopPropagation();  // Prevent event from bubbling up and closing the dropdown
    var selectBox = document.querySelector('.custom-select');
    selectBox.classList.toggle('open');
    selectBox.classList.add('focused');  // Add focus when clicked
    document.querySelector('.search-box').focus();  // Focus search box when opened
});

var options = document.querySelectorAll('.option');
var searchBox = document.querySelector('.search-box');
let selectedIndex = -1;

searchBox.addEventListener('input', function () {
    var query = searchBox.value.toLowerCase();
    options.forEach((option, index) => {
        var optionText = option.innerText.toLowerCase();
        if (optionText.includes(query)) {
            option.style.display = 'flex'; // Show option if it matches search
        } else {
            option.style.display = 'none'; // Hide option if it doesn't match
        }
    });
    selectedIndex = -1; // Reset selection when search changes
    updateSelection();
});

options.forEach((option, index) => {
    option.addEventListener('click', function () {
        selectOption(option);  // Pass the clicked option element
    });
});

// Keyboard navigation
document.querySelector('.custom-select').addEventListener('keydown', function (event) {
    var visibleOptions = Array.from(options).filter(option => option.style.display !== 'none');

    if (event.key === 'ArrowDown') {
        // Move down
        if (selectedIndex < visibleOptions.length - 1) {
            selectedIndex++;
        }
        updateSelection();
        scrollToSelectedOption();
    } else if (event.key === 'ArrowUp') {
        // Move up
        if (selectedIndex > 0) {
            selectedIndex--;
        }
        updateSelection();
        scrollToSelectedOption();
    } else if (event.key === 'Enter' && selectedIndex !== -1) {
        // Select the current visible option (based on selectedIndex)
        var visibleOptions = Array.from(options).filter(option => option.style.display !== 'none');
        selectOption(visibleOptions[selectedIndex]);
    }
});

// Update selection style
function updateSelection() {
    var visibleOptions = Array.from(options).filter(option => option.style.display !== 'none');
    visibleOptions.forEach((option, index) => {
        if (index === selectedIndex) {
            option.classList.add('selected');
        } else {
            option.classList.remove('selected');
        }
    });
}

// Scroll the dropdown to keep the selected item visible
function scrollToSelectedOption() {
    var visibleOptions = Array.from(options).filter(option => option.style.display !== 'none');
    var selectedOption = visibleOptions[selectedIndex];
    var optionList = document.querySelector('.options');

    if (selectedOption) {
        var optionTop = selectedOption.offsetTop;
        var optionHeight = selectedOption.offsetHeight;
        var listTop = optionList.scrollTop;
        var listHeight = optionList.offsetHeight;

        // Scroll down if the selected item is near the bottom
        if (optionTop + optionHeight > listTop + listHeight) {
            optionList.scrollTop = optionTop + optionHeight - listHeight;
        }
        // Scroll up if the selected item is near the top
        else if (optionTop < listTop) {
            optionList.scrollTop = optionTop;
        }
    }
}

// Select an option
function selectOption(option) {
    var selectedOptionHTML = option.innerHTML; // Get the content of the clicked option
    document.querySelector('.selected-option').innerHTML = selectedOptionHTML; // Update the displayed selected option

    // Update the hidden input field with the selected person's ID
    var personIdInput = document.getElementById("person_id");
    personIdInput.value = option.dataset.value;  // Set the value of the hidden input to the selected option's value

    document.querySelector('.custom-select').classList.remove('open');
    selectedIndex = -1; // Reset selection after choosing
    document.querySelector('.custom-select').classList.remove('focused');  // Remove focus after selection
}
