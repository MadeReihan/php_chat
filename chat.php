<?php 

    session_start();

    if(isset($_SESSION['username'])){
        include 'app/db.conn.php';
        include 'app/helpers/user.php';
        include 'app/helpers/timeAgo.php';
        include 'app/helpers/chat.php';

        if(!isset($_GET['user'])){
            header("Location: home.php");
            exit;
        }

        $chatWith = getUser($_GET['user'],$conn);
        
        if(empty($chatWith)){
            header("Location: home.php");
            exit;
        }

        $chats = getChats($_SESSION['user_id'],$chatWith['user_id'],$conn);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="w-400 shadow p-4 rounded">
        <a href="home.php" class="fs-4 link-dark">&#8592;</a>
        <div class="d-flex align-items-center">
            <img src="uploads/<?= $chatWith['p_p']; ?>" class="w-15 rounded-circle"> 
            <h3 class="display-4 fs-sm m-2 "><?= $chatWith['name']; ?> 
                <br> 
                <div class="d-flex align-items-center" title="online">
                    <?php if(last_seen($chatWith['last_seen']) == "Active"){ ?>
                        <div class="online me-1"></div>
                        <small class="d-block p-1 ">Online</small>
                    <?php }else{ ?>
                        <small class="d-block p-1 "><?= $chatWith['last_seen'] ?></small>
                    <?php } ?>
                </div>
            </h3>
        </div>

        <div class="shadow p-4 rounded d-flex flex-column mt-2  chat-box" id="chatBox">

            <?php if(!empty($chats)){ ?>

                <p class="rtext align-self-end border rounded p-2 mb-1">
                    <!-- <?= $chats['message'] ?> -->
                    <small class="d-block ">12.00</small>
                </p>
    
                <p class="ltext align-self-start border rounded p-2 mb-1">Hello there
                    <small class="d-block ">12.00</small>
                </p>

            <?php }else{ ?>


                <div class="alert alert-info text-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm11.293-4.707L18 10.586l-2.293-2.293-1.414 1.414 2.292 2.292-2.293 2.293 1.414 1.414 2.293-2.293 2.294 2.294 1.414-1.414L19.414 12l2.293-2.293z"></path></svg> <br> no messages yet, start the conversation
                </div>

            <?php } ?>

            

        </div>

        <div class="input-group mb-3">
            <textarea cols="3" class="form-control" id="message" >

            </textarea>
            <button class=" btn btn-primary" id="sendBtn"><i class='bx bxs-send'></i></button>
        </div>

    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var scrollDown = function(){
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        scrollDown();

        $(document).ready(function(){

            $('#sendBtn').on('click', function(){
                message = $('#message').val();
                if(message == "") return;

                $.post("app/ajax/insert.php",{
                    message: message,
                    to_id: <?=$chatWith['user_id'] ?>
                },
                function(data,status){
                    $("#message").val("");
                    $("#chatBox").append(data);
                    scrollDown();
                });
            })
        
        });
    </script>
</body>
</html>


<?php 
    }else{
        header("Location: home.php");
        exit;
    }
?>