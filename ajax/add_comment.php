<script>
function sendRating(productId) {
    const rating = document.querySelector('#rating').value;
    const comment = document.querySelector('#comment').value;

    fetch("admin/ajax/save_rating.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            product_id: productId,
            rating: rating,
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("rating-message").innerText = data.message;
    })
    .catch(err => {
        alert("Er ging iets mis");
    });
}
</script>
