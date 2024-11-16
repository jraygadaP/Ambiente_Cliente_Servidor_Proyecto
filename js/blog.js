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

//botón de Me gusta
const likeButtons = document.querySelectorAll('.btn-like');
likeButtons.forEach((button, index) => {
    let likeCount = 0;
    button.addEventListener('click', () => {
        likeCount++;
        button.querySelector('.like-count').textContent = likeCount;
        button.querySelector('.fas').classList.toggle('liked'); // Cambiar ícono de corazón
    });
});

// agregar un comentario
function addComment(blogId) {
    const commentInput = document.getElementById(`comment-input-${blogId}`);
    const commentText = commentInput.value;
    
    if (commentText.trim() !== "") {
        const commentList = document.getElementById(`comments-${blogId}`);
        const newComment = document.createElement('div');
        newComment.textContent = commentText;
        commentList.appendChild(newComment);
        
        commentInput.value = ''; 
    }
}