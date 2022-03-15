<?php 

    session_start();

    if(isset($_SESSION['username'])){

        if(isset($_POST['key'])){
            include '../db.conn.php';

            $key = "%{$_POST['key']}%";


            $sql = "SELECT * FROM users WHERE username LIKE ? OR name LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$key,$key]);

            if($stmt->rowCount() > 0 ){ 
                $users = $stmt->fetchAll();
                foreach($users as $user){ 
                    if($user['user_id'] == $_SESSION['user_id']) continue;       
                ?>

                <li class="list-group-item">
                    <a href="chat.php?user=<?= $user['username'] ?>" class="d-flex justify-content-between align-items-center p-2 text-decoration-none">
                        <div class="d-flex align-items-center">
                            <img src="uploads/<?= $user['p_p'] ?>" class=" rounded-2" width="50px" height="50px">
                            <h5 class="fs-xs m-2"><?= $user['name'] ?></h5>
                        </div>
                    </a>
                </li>

            <?php } }else{ ?>
                <div class="alert alert-info text-center">
                    <i class='bx bxs-user-plus'></i><br>
                    The User "<?= htmlspecialchars($_POST['key']) ?>"
                    Is not found
                </div>
            <?php }
        }
    }else{
        header("Location: ../../index.php");
        exit;
    }

?>