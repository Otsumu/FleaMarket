document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('favoriteButton').addEventListener('click', async () => {
        const itemId = document.getElementById('favoriteButton').getAttribute('data-item-id');
        const favoriteCountElement = document.getElementById('favoriteCount');

        const response = await fetch(`/items/${itemId}/toggle-favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const data = await response.json();
            favoriteCountElement.textContent = data.favorite_count;
        }
    });
});