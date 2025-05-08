document.getElementById('search_name').addEventListener('input', function () {
    const query = this.value.trim();
    const button = document.getElementById("search-btn");

    if (query.length === 0) {
        document.getElementById('suggestions').innerHTML = '';
        button.style.display = "inline-block";
        return;
    }

    button.style.display = "none";

    fetch(`admin-edit-product.php?query=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('suggestions').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching suggestions:', error);
        });
});

setTimeout(() => {
    document.querySelectorAll("p.success-message, p.error-message").forEach(msg => {
        msg.style.display = 'none';
    });
}, 100);
