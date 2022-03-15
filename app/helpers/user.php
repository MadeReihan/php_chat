<?php 

    function getUser($user,$conn){
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user]);

        if($stmt->rowCount() === 1){
            $user = $stmt->fetch();
            return $user;
        }else{
            $user = [];
            return $user;
        }
    }

?>