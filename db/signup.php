<?php
    session_start();
    include ("dbconfig.php");
    if(isset($_POST["submit"]))
    {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $conpass = $_POST["conpass"];
        $country = $_POST["country"];
        $gender = $_POST["radio"];
        $nick = $_POST["nick"];
        //Dummy Data
        $ptitle = "No Information";
        $company = "No Information";
        $college = "No Information";
        $last_qual = "No Information";
        $employment_project = "No Information";
        $aboutme = "No Information";
        $image = 'https://lh3.googleusercontent.com/-LR423YiTbOQ/AAAAAAAAAAI/AAAAAAAAAAA/eAMb2whBK-A/photo.jpg';
        $imagecontent= addslashes(file_get_contents($image));

        if ($password != $conpass){
          echo "Password Didn't Match";
        }else{
          $password = mysqli_real_escape_string($dbconfig, $password);
          $password = md5($password,TRUE);

          $sql="SELECT email,nickname FROM users WHERE email='$email' or nickname='$nick'";

          $result=mysqli_query($dbconfig,$sql);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          if(mysqli_num_rows($result) == 1)
          {
                echo "<script>
                  alert('Email/User Name Exist');
                </script>";
          }
          else
          {
              $query = mysqli_query($dbconfig, "INSERT INTO users (fname,lname,email,pass,country,nickname,gender,picture)VALUES ('$fname','$lname','$email','$password','$country','$nick','$gender','$imagecontent')");
              if ($query){
                //header('location:../index.php');
                $sql_reg = "SELECT id from users where email ='$email'";
                $result_reg = mysqli_query($dbconfig,$sql_reg);
                $row_id = mysqli_fetch_array($result_reg,MYSQLI_ASSOC);
                $newID = $row_id['id'];
                if (mysqli_num_rows($result_reg) == 1){
                    $sql = mysqli_query($dbconfig, "INSERT INTO user_education (id, ptitle,company,college,last_qual,employment_project,aboutme) VALUES ('$newID','$ptitle','$company','$college','$last_qual','$employment_project','$aboutme')");
                }else{
                  echo "couldnot get id";
                }
                header('location:success.php');
              }else{
                header('location:error.php');
              }
          }
        }
    }
?>
