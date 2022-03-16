<?php 

    session_start();

    if(isset($_SESSION['username'])){
        include 'app/db.conn.php';
        include 'app/helpers/user.php';
        include 'app/helpers/conversations.php';
        include 'app/helpers/timeAgo.php';
        $user = getUser($_SESSION['username'],$conn);
        $conversations = getConversations($user['user_id'],$conn);
        

?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Home </title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
            <link rel="stylesheet" href="css/style.css" type="text/css"/>
            
        </head>
        <body class="d-flex justify-content-center align-items-center vh-100">

            <div class="p-2 w-400 rounded shadow">

                <div>

                    <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?= $user['p_p'] ?>" class=" rounded-2" width="100px" height="100px">
                                <h5 class="fs-xs m-2 me-5" ><?= $user['name']; ?></h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <a href="logout.php" class="btn btn-dark">Logout</a>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" placeholder="Search.." class="form-control" id="searchText">
                        <button class="btn btn-primary" id="searchButton"><i class='bx bx-search'></i></button>
                    </div>
                    <ul class="list-group mvh-50 overflow-auto" id="chatList">
                        <?php if(!empty($conversations)){?>
                            <?php foreach($conversations as $conversation){ ?>
                                <li class="list-group-item">
                                    <a href="chat.php?user=<?= $conversation['username'] ?>" class="d-flex justify-content-between align-items-center p-2 text-decoration-none">
                                        <div class="d-flex align-items-center">
                                            <img src="uploads/<?= $conversation['p_p'] ?>" class=" rounded-2" width="50px" height="50px">
                                            <h5 class="fs-xs m-2"><?= $conversation['name'] ?></h5>
                                        </div>
                                        <?php if(last_seen($conversation['last_seen']) == "Active"){ ?>

                                            <div title="online">
                                                <div class=" online"></div>
                                            </div>
                                        <?php } ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="alert alert-info text-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm11.293-4.707L18 10.586l-2.293-2.293-1.414 1.414 2.292 2.292-2.293 2.293 1.414 1.414 2.293-2.293 2.294 2.294 1.414-1.414L19.414 12l2.293-2.293z"></path></svg> <br> no messages yet, start the conversation
                            </div>
                        <?php } ?>
                    </ul>

                </div>

            </div> 





        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){

                // search
                $('#searchText').on("input", function(){
                    var searchText = $(this).val();
                    if(searchText == "") return;
                    $.post('app/ajax/search.php',{
                        key: searchText
                    },
                    function(data,status){
                        $("#chatList").html(data);
                    });
                })


                // searchbybutton
                $('#searchButton').on("click", function(){
                    var searchText = $("searchText").val();
                    if(searchText == "") return;
                    $.post('app/ajax/search.php',{
                        key: searchText
                    },
                    function(data,status){
                        $("#chatList").html(data);
                    });
                })




                let lastSeenUpdate = function(){
                    $.get("app/ajax/update_last_seen.php");
                }
                lastSeenUpdate();

                setInterval(lastSeenUpdate,10000);
            });
        </script>
        </body>
    </html>
<?php 
    }else{
        header("Location: index.php");
        exit;
    }
?>
