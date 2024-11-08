document.getElementById('reviewForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const userName = document.getElementById('userName').value;
    const userReview = document.getElementById('userReview').value;

    const reviewList = document.getElementById('reviewList');
    const newReview = document.createElement('div');

    newReview.innerHTML = "<strong>" + userName + "</strong><p>" + userReview + "</p><hr>";

    reviewList.appendChild(newReview);
    document.getElementById('reviewForm').reset();
});
