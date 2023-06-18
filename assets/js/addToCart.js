function addToCart(productId) {
    var request = new XMLHttpRequest();
    request.open('POST', 'cart.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            // Handle the response from the server if needed
            window.location.href = 'cart.php';
        }
    };
    request.send('pro_id=' + productId);
}
