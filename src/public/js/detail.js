window.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed');

    const favoriteButton = document.getElementById('favoriteButton');
    const commentButton = document.getElementById('commentButton');

    if (favoriteButton) {
        console.log('Favorite button found');
        favoriteButton.addEventListener('click', toggleFavorite);
    } else {
        console.log('Favorite button not found');
    }

    if (commentButton) {
        console.log('Comment button found');
        commentButton.addEventListener('click', toggleComment);
    } else {
        console.log('Comment button not found');
    }
});

function toggleFavorite() {
    console.log('toggleFavorite called');
    const favoriteCountElement = document.getElementById('favoriteCount');
    let favoriteCount = parseInt(favoriteCountElement.textContent);

    favoriteCount = (favoriteCount === 0) ? favoriteCount + 1 : favoriteCount - 1;
    favoriteCountElement.textContent = favoriteCount;
    console.log('New favorite count:', favoriteCount);
}

function toggleComment() {
    console.log('toggleComment called');
    const commentCountElement = document.getElementById('commentCount');
    let commentCount = parseInt(commentCountElement.textContent);

    
    commentCount += 1;
    commentCountElement.textContent = commentCount;
    console.log('New comment count:', commentCount);
}