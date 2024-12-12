document.querySelector('.file-upload').addEventListener('click', function() {
    document.querySelector('#image').click(); // 非表示のファイル入力をクリック
});

// ファイルが選択されたときに、プレビュー画像を表示
document.querySelector('#image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('#preview-image').setAttribute('src', e.target.result);
            document.querySelector('#image-preview').style.display = 'block'; // プレビューを表示
        };
        reader.readAsDataURL(file); // ファイルを読み込む
    }
});

// カテゴリー選択処理（複数選択可能＆色付け）
const categoryOptions = document.querySelectorAll('.category-options li');
categoryOptions.forEach(option => {
    option.addEventListener('click', function() {
        // すでに選択されている場合は解除
        if (option.classList.contains('selected')) {
            option.classList.remove('selected');
            // 選択解除したカテゴリーを削除
            const categoryValue = option.getAttribute('data-value');
            let selectedCategories = document.getElementById('categoryInput').value.split(',');
            selectedCategories = selectedCategories.filter(item => item !== categoryValue);
            document.getElementById('categoryInput').value = selectedCategories.join(',');
        } else {
            // 選択されていなければ選択状態に
            option.classList.add('selected');
            // 選択したカテゴリーを追加
            const categoryValue = option.getAttribute('data-value');
            let selectedCategories = document.getElementById('categoryInput').value.split(',');
            selectedCategories.push(categoryValue);
            document.getElementById('categoryInput').value = selectedCategories.join(',');
        }
    });
});