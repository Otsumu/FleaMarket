function showItems(type) {
    if (type === 'sell') {
        document.getElementById('sell-items').style.display = 'block';
        document.getElementById('purchase-items').style.display = 'none';
    } else if (type === 'purchase') {
        document.getElementById('sell-items').style.display = 'none';
        document.getElementById('purchase-items').style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.sell').addEventListener('click', function() {
        showItems('sell');
    });

    document.querySelector('.purchase').addEventListener('click', function() {
        showItems('purchase');
    });
});