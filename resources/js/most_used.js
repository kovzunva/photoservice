import 'bootstrap/dist/js/bootstrap.min.js';
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

// Селект
$(document).ready(function() {
    $(".base-select").on("click", ".selected-option", function() {
      var $baseSelect = $(this).closest(".base-select");
      $baseSelect.find(".options").toggleClass("hide");
    });
  
    $(".base-select").on("click", ".options li", function() {
        var $baseSelect = $(this).closest(".base-select");
        var selectedValue = $(this).data("value");
        $baseSelect.find("input[type='hidden']").val(selectedValue);
        $baseSelect.find(".selected-option").text($(this).text());
        $baseSelect.find(".options").addClass("hide");
            
        // фільтрування при зміні опції
        if ($(this).hasClass("filter-option")) {
            var $parentForm = $baseSelect.closest("form");
            if ($parentForm.length > 0) {
                $parentForm.submit();
            }
        }
    });
});

// Кнопка з випадним списком
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('show');
}
document.addEventListener('click', function(event) {
    const buttons = document.querySelectorAll('.custom-dropdown-btn');
    buttons.forEach(function(button) {
        if (button.contains(event.target)) {
            toggleDropdown(button);
            event.preventDefault();
        } else {
            const dropdown = button.nextElementSibling;
            dropdown.classList.remove('show');
        }
    });
});


// Введення дати
document.addEventListener('input', function(event) {
    if (event.target.classList.contains('input-date')) {
      const input = event.target;
      const value = input.value.replace(/\D/g, '');
      
      if (value.length >= 2 && value.length < 4) {
        input.value = value.slice(0, 2) + '.' + value.slice(2);
      }
      else if (value.length >= 4) {
        input.value = value.slice(0, 2) + '.' + value.slice(2, 4) + '.' + value.slice(4, 8);
      }
      else {
        input.value = value;
      }
      
    }
  });
document.addEventListener('keydown', function(event) {
if (event.target.classList.contains('input-date')) {
    if (event.key === 'Backspace' || event.key === 'Delete') {
    event.target.value = '';
    }
}
});

// Лише числа
const numberInputs = document.querySelectorAll('.number');
numberInputs.forEach(input => {
  input.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
});

// Лише числа з комою
const numberInputsDot = document.querySelectorAll('.number-dot');
numberInputsDot.forEach(input => {
    input.addEventListener('input', function() {
        let value = input.value;
        
        // Замінюємо всі символи, крім цифр і крапки, на порожній рядок
        value = value.replace(/[^0-9.]/g, '');

        // Перевіряємо, чи є більше однієї крапки
        if (value.split('.').length > 2) {
            const parts = value.split('.');
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        // Перевіряємо, чи введено більше однієї крапки
        if (value.includes('.') && (value.match(/\./g) || []).length > 1) {
            value = value.substring(0, value.lastIndexOf('.'));
        }

        // Оновлюємо значення поля вводу
        input.value = value;
    });
});