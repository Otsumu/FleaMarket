document.addEventListener('DOMContentLoaded', () => {
    const favoriteButton = document.getElementById('favoriteButton');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!favoriteButton || !csrfToken) {
        console.error('Required elements not found');
        return;
    }

    favoriteButton.addEventListener('click', async () => {
        try {
            const itemId = favoriteButton.getAttribute('data-item-id');
            const favoriteCountElement = document.getElementById('favoriteCount');

            if (!itemId || !favoriteCountElement) {
                throw new Error('Required attributes not found');
            }

            favoriteButton.disabled = true;

            const response = await fetch(`/item/${itemId}/toggle-favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to update favorite');
            }

            const data = await response.json();
            favoriteCountElement.textContent = data.favorite_count;

            favoriteButton.classList.add('favorited');
            setTimeout(() => {
                favoriteButton.classList.remove('favorited');
            }, 200);

        } catch (error) {
            console.error('Error:', error);
            alert('お気に入りの更新に失敗しました。');
        } finally {
            favoriteButton.disabled = false;
        }
    });
});
