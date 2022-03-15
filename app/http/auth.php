<?php 
session_start();
    if(isset($_POST['username']) && isset($_POST['password'])){
        include '../db.conn.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username)){
            $em = "username is required";

            header("Location: ../../index.php?error=$em");
            exit;
        }else if(empty($password)){
            $em = "password is required";

            header("Location: ../../index.php?error=$em");
            exit;
        }else{
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);

            if($stmt->rowCount() === 1){
                $user = $stmt->fetch();

                if($user['username'] == $username){
                    if(password_verify($password,$user['password'])){
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['name'] = $user['name'];

                        header("Location: ../../home.php");
                    }else{
                        $em = "password is incorrect";

                        header("Location: ../../index.php?error=$em");
                        exit;
                    }
                }else{
                    $em = "username does not exist";

                    header("Location: ../../index.php?error=$em");
                    exit;
                }
            }else{
                $em = "gagal login";

                header("Location: ../../index.php?error=$em");
                exit;
            }
        }
    }else{
        header("Location: ../../index.php");
        exit;
    }
?>