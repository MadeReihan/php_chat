<?php 

    session_start();

    if(!isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php chat - sign up</title>
    
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="POST" action="app/http/signup.php" enctype="multipart/form-data">
            <div class="d-flex justify-content-center align-content-center flex-column">
                <h3 class="display-4 fs-1 text-center">Sign Up</h3>
            </div>
            
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-warning" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php } 
                if(isset($_GET['name'])){
                    $name = $_GET['name'];
                }else $name = '';

                if(isset($_GET['username'])){
                    $username = $_GET['username'];
                }else $username = '';
            
            ?>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>

            <div class="mb-3">
                <label for="pp" class="form-label">profile picture</label>
                <input type="file" class="form-control" id="pp" name="pp">
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
            <a href="index.php">Login</a>
            
        </form>
    </div>



    
</body>
</html>

<?php 
    }else{
        header("Location: home.php");
        exit;
    }
?>