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
            const label = button.innerText;

            if (selectedCategories.has(value)) {
                selectedCategories.delete(value);
                button.classList.remove("selected");
            } else {
                selectedCategories.add(value);
                button.classList.add("selected");
            }

            // 選択されたカテゴリの日本語を隠しフィールドにセット
            categoryInput.value = Array.from(selectedCategories).map(value => {
                // ここで英語の値を日本語にマッピングするロジックを入れる
                switch (value) {
                    case 'fashion': return 'ファッション';
                    case 'electronics': return '家電';
                    case 'interior': return 'インテリア';
                    case 'redies': return 'レディース';
                    case 'mens': return 'メンズ';
                    case 'cosme': return 'コスメ';
                    case 'book': return '本';
                    case 'game': return 'ゲーム';
                    case 'sports': return 'スポーツ';
                    case 'kitchen': return 'キッチン';
                    case 'handmade': return 'ハンドメイド';
                    case 'acccesary': return 'アクセサリー';
                    case 'toy': return 'おもちゃ';
                    case 'baby-kids': return 'ベビー・キッズ';
                    default: return '';
                }
            }).join(",");
        });
    });
});