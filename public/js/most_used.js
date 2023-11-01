

// Перевірки при надсиланні форми
document.addEventListener("DOMContentLoaded", function() {
  const validateForms = document.querySelectorAll(".validate-form");

  validateForms.forEach(form => {
      form.addEventListener("submit", function(event) {
          let hasError = false;

          // Обов'язкові поля
          const requiredInputs = form.querySelectorAll(".required");
          requiredInputs.forEach(input => {
              const errorMessage = form.querySelector("#error_" + input.name);
              if (input.value.trim() === "") {
                  errorMessage.classList.remove('hide');
                  hasError = true;
                  input.focus();
                  errorMessage.scrollIntoView();
              }
              else {
                  errorMessage.classList.add('hide');
              }
          });

          // Блоки, які не можуть бути пусті
          const noEmptyBlocks = document.querySelectorAll('.no-empty');
          noEmptyBlocks.forEach(block => {
              const childElements = Array.from(block.children);
      
              const hasVisibleChild = childElements.some(element => {
                  const computedStyle = getComputedStyle(element);
                  const hasHiddenClass = element.classList.contains('hide') || element.classList.contains('hide-post');
                  const isHiddenAttributeSet = element.hasAttribute('hidden');
      
                  return (
                      !hasHiddenClass &&
                      !isHiddenAttributeSet
                  );
              });
      
              const errorBlock = document.getElementById('error_' + block.id);
      
              if (!hasVisibleChild) {
                  errorBlock.classList.remove('hide');
                  hasError = true;
              }
              else {
                  errorBlock.classList.add('hide');
              }
          });

          // сюди інші перевірки 

          if (hasError) {
              event.preventDefault();
          }
      });
  });
});


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

function PrintNewImgEdit(imageURL){
  post_img.src = imageURL;
  img_pass.value = imageURL;
}

const fileInput = document.getElementById('file_img');
if (fileInput) {
fileInput.addEventListener('change', function() {

  const imageFile = this.files[0];
  if (imageFile) {
    const fileReader = new FileReader();
    fileReader.onload = function(event) {
      const imageURL = event.target.result;
      PrintNewImgEdit(imageURL);
    }
    fileReader.readAsDataURL(imageFile);
  }
});
}

const urlInput = document.getElementById('url_img');
if (urlInput) {
document.getElementById('btn_url_img').addEventListener('click', function() {

  const imageURL = urlInput.value.trim();

  if (imageURL !== '') {        
    PrintNewImgEdit(imageURL);
    urlInput.value = '';
  }
});
}

// ентер на кнопку у текстових полях
document.addEventListener('DOMContentLoaded', function() {
  const enterBtnInputs = document.querySelectorAll('.enter_btn');

  enterBtnInputs.forEach(input => {
      input.addEventListener('keydown', function(event) {
          if (event.key === 'Enter') {
              event.preventDefault();
              const btnId = 'btn_' + input.id;
              const EnterButton = document.getElementById(btnId);
              if (EnterButton) {
                  EnterButton.click(); // Викликаємо обробник кнопки
              }
          }
      });
  });
});