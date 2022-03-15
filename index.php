<?php 

    session_start();

    if(!isset($_SESSION['username'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php chat - login</title>
    
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="POST" action="app/http/auth.php">
            <div class="d-flex justify-content-center align-content-center flex-column">
                <h3 class="display-4 fs-1 text-center">Login</h3>
            </div>

            <?php if(isset($_GET['success'])){ ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php } ?>

            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-warning" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="signup.php">Sign Up</a>
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