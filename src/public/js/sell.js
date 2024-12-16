document.querySelector('.file-upload').addEventListener('click', function() {
    document.querySelector('#image').click();
});

document.querySelector('#image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('#preview-image').setAttribute('src', e.target.result);
            document.querySelector('#image-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const categoryButtons = document.querySelectorAll("#categoryOptions button");
    const categoryInput = document.querySelector("#categoryInput");
    const selectedCategories = new Set();

    categoryButtons.forEach(button => {
        button.addEventListener("click", () => {
            const value = button.getAttribute("data-value");

            if (selectedCategories.has(value)) {
                selectedCategories.delete(value);
                button.classList.remove("selected");
            } else {
                selectedCategories.add(value);
                button.classList.add("selected");
            }

            categoryInput.value = Array.from(selectedCategories).join(",");
        });
    });
});