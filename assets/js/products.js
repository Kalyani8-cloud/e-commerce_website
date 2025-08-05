document.addEventListener('DOMContentLoaded', function() {
    fetch('api/products.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('products');
            container.innerHTML = ''; 
            data.data.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.innerHTML = `
                    <img src="${product.image_url}" class="product-image" alt="${product.name}">
                    <div class="product-info">
                        <h3 class="product-title">${product.name}</h3>
                        <p>${product.description.substring(0,50)}...</p>
                        <div class="product-price">$${product.price}</div>
                        <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                    </div>
                `;
                container.appendChild(card);
            });

            // Attach click event after rendering
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    fetch('api/add_to_cart.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ product_id: productId, quantity: 1 })
                    })
                    .then(res => res.json())
                    .then(response => {
                        alert(response.message || 'Added to cart');
                    })
                    .catch(err => console.error(err));
                });
            });
        });
});
