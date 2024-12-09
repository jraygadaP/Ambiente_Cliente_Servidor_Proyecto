<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$posts = [
    [
        'id' => 1,
        'titulo' => 'Consejos para Ahorrar',
        'descripcion' => 'Aprende cómo manejar tus finanzas y mejorar tu capacidad de ahorro.',
        'imagen' => 'img/ahorro.png',
        'enlace' => 'https://bettermoneyhabits.bankofamerica.com/es/saving-budgeting/ways-to-save-money'
    ],
    [
        'id' => 2,
        'titulo' => 'Cómo invertir inteligentemente',
        'descripcion' => 'Descubre estrategias de inversión para principiantes.',
        'imagen' => 'img/invertir.png',
        'enlace' => 'https://finhabits.com/es/invertir-inteligentemente-como-empezar-con-poco-dinero'
    ],
    [
        'id' => 3,
        'titulo' => 'Planificación Financiera',
        'descripcion' => 'Organiza tus finanzas para el futuro con estos consejos.',
        'imagen' => 'img/planificacion.png',
        'enlace' => 'https://emprendiendohistorias.com/invertir-dinero/'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .blog-title {
            color: #9EC4BB;
        }
        .blog-card {
            background-color: #EED7C5;
            border: none;
            margin-bottom: 20px;
            height: 100%;
        }
        .btn-read {
            background-color: #CCCCBB;
            color: #2D2E2C;
        }
        .btn-read:hover {
            background-color: #9EC4BB;
            color: white;
        }
        .card {
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #reviewList {
            margin-top: 20px;
            background-color: #F7DECE;
            padding: 10px;
            border-radius: 8px;
        }
        .btn-submit {
            background-color: #9EC4BB; 
            color: #2D2E2C; 
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .card-img-top {
            height: 200px; 
            object-fit: cover; 
            width: 100%; 
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .btn-like {
            background-color: transparent;
            border: none;
            color: #9EC4BB;
            cursor: pointer;
        }
        .comments-section {
            border-top: 1px solid #CCCCBB;
            margin-top: 20px;
            padding-top: 10px;
        }
        .comments-list {
            margin-top: 10px;
        }

     
.footer {
    text-align: center;
    background-color: #2D2E2C;
    color: #FFFFFF;
    padding: 20px;
    margin-top: 50px;
}
    </style>
</head>
<body>
   <?php include 'includes/header.php'; ?>

   <div class="container mt-5">
       <h2 class="blog-title text-center">Nuestro Blog</h2>
       <div class="row mt-4">
           <?php foreach ($posts as $post): ?>
               <div class="col-md-4">
                   <div class="card blog-card">
                       <img src="<?php echo htmlspecialchars($post['imagen']); ?>" class="card-img-top" alt="Imagen Blog">
                       <div class="card-body">
                           <h5 class="card-title"><?php echo htmlspecialchars($post['titulo']); ?></h5>
                           <p class="card-text"><?php echo htmlspecialchars($post['descripcion']); ?></p>
                           <a href="<?php echo htmlspecialchars($post['enlace']); ?>" class="btn btn-read" target="_blank">Leer más</a>
                           
                           <button class="btn-like" data-post-id="<?php echo $post['id']; ?>">
                               <i class="fas fa-heart"></i> 
                               <span class="like-count">0</span> Me gusta
                           </button>

                           <div class="comments-section mt-3">
                               <form class="comment-form">
                                   <input type="text" class="form-control" placeholder="Deja un comentario" required>
                                   <button type="submit" class="btn btn-comment mt-2">Comentar</button>
                               </form>
                               <div class="comments-list mt-2"></div>
                           </div>
                       </div>
                   </div>
               </div>
           <?php endforeach; ?>
       </div>

       <div class="container mt-5">
           <h2 class="text-center">Envíanos tu Reseña</h2>
           <div class="card p-4 mt-4">
               <form id="reviewForm">
                   <div class="form-group">
                       <label for="userName">Nombre:</label>
                       <input type="text" class="form-control" id="userName" required>
                   </div>
                   <div class="form-group">
                       <label for="userReview">Reseña:</label>
                       <textarea class="form-control" id="userReview" rows="4" required></textarea>
                   </div>
                   <button type="submit" class="btn-submit">Enviar Reseña</button>
               </form>
               <div id="reviewList" class="mt-4"></div>
           </div>
       </div>
   </div>

   <?php include 'includes/footer.php'; ?>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       $(document).ready(function() {
           let likes = {};
           let comments = {};
           
           $('.btn-like').click(function() {
               const postId = $(this).data('post-id');
               likes[postId] = (likes[postId] || 0) + 1;
               $(this).find('.like-count').text(likes[postId]);
           });

           $('.comment-form').submit(function(e) {
               e.preventDefault();
               const form = $(this);
               const comment = form.find('input').val();
               const postId = form.closest('.card').find('.btn-like').data('post-id');
               
               if (!comments[postId]) {
                   comments[postId] = [];
               }
               comments[postId].push(comment);
               
               const commentsList = form.siblings('.comments-list');
               commentsList.html('');
               comments[postId].forEach(c => {
                   commentsList.append(`<div class="comment">${c}</div>`);
               });
               
               form.find('input').val('');
           });

           $('#reviewForm').submit(function(e) {
               e.preventDefault();
               const name = $('#userName').val();
               const review = $('#userReview').val();
               
               $('#reviewList').append(`
                   <div class="review-item">
                       <strong>${name}</strong>
                       <p>${review}</p>
                       <small>${new Date().toLocaleDateString()}</small>
                   </div>
               `);
               
               this.reset();
           });
       });
   </script>
</body>
</html>