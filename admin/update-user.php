<?php include "header.php"; 

if(isset($_POST["submit"])){
    include"config.php";
// mysqli_real_escape_string($conn, -> this is for data protection from hacker

    $userid = mysqli_real_escape_string($conn,$_POST["user_id"]);
    $fname = mysqli_real_escape_string($conn,$_POST["f_name"]);
    $lname = mysqli_real_escape_string($conn,$_POST["l_name"]);
    $user = mysqli_real_escape_string($conn,$_POST["username"]);
    // md5 -> la password encript garxa j sukai password rakha
    //! $password = mysqli_real_escape_string($conn,md5($_POST["password"]));
    $role = mysqli_real_escape_string($conn,$_POST["role"]);
   $sql = "UPDATE user SET first_name = '{$fname}',last_name = '{$lname}',username = '{$user}',role = '{$role}'WHERE user_id='{$userid}'"; 
//    die();
//    
    $result = mysqli_query($conn,$sql) or die("Query failed");
    if (mysqli_num_rows($result) > 0){
        // $row = mysqli_fetch_array($result);
echo "<p style='color:red;text-align:center;margin:10px 0'>User Name already exits.</>";
}else{
$sql1 = "INSERT INTO user (first_name,last_name,username,password,role ) VALUE ('{$fname}','{$lname}','{$user}','{$password}','{$role}')";
if(mysqli_query($conn,$sql1)){
    header("Location:{hostname}/admin/users.php");
};
}
}

?> 
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <!-- php -->
                <?php
                include "config.php";
                $user_id = $_GET['id'];
        
                $sql = "SELECT * FROM user WHERE user_id = {$user_id}";

                $result = mysqli_query($conn, $sql) or die("query fail");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'];  ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'];  ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'];  ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'];  ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                          <?php
                          if($row['role'] == '1') {
                                echo ' <option value="0">normal User</option>
                              <option value="1" selected>Admin</option>';
                              } else {
                                echo ' <option value="0" selected>normal User</option>
                              <option value="1">Admin</option>';
                              }
                              ?>
                             
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php
                    }
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>