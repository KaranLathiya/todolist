<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo";

$conn = mysqli_connect($servername,$username,$password,$database);
 if(!$conn){
    die("sorry we failed to connect" . mysqli_connect_error());
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO LIST</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<style>
  .fix{
    float: right;
  }
  marquee{
    margin-top: 10px;
  }
  .editt:disabled{
    pointer-events: visible;
    cursor: not-allowed !important;
    /* background-color: black; */
  }
  /* .tra{
    transition: all 2s cubic-bezier(1, 0, 0, 1);
  } */
  /* .tra:hover{
    color: white;
    padding-left: 500px;
  } */
  body{
    opacity: 0.9;
    background-image: url(istockphoto-528917900-612x612.jpg);
    background-repeat: no-repeat;
            background-position: center;
            height: 100%;
            width: 100%;
            background-attachment: fixed;
            background-size: 100%;
  }
  .cl,marquee{
    color: white;
  }
  li{
    margin-top: 2px;
    border-color: black ;
    list-style: none;
  }
  li:hover{
    border-color: white ;
    background-color: black;
     color: white;
  }
  .op{
    opacity: 1;  
   background-color: rgba(255, 183, 0, 0.814); 
   color:white;
     }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container-fluid" >
          <a class="navbar-brand cl" href="#">TO DO LIST</a>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <div id="warn" role="alert"></div>
      <div class="container mt-2">
      <form action="index.php" method="POST" >
<div class="input-group mb-3">
  
    <input type="text" class="form-control" id="adder" name="task" placeholder="TASK" >
    <button class="btn btn-outline-success"  type="submit" name="all" value="add" id="button">ADD</button>
    <button class="btn btn-outline-danger"  type="submit" title="CLEAR LOCAL STORAGE & RELOAD" name="all" id="buttonn" value="clear">CLEAR ALL</button>
  </div>
  </form>
  <ul id="addhere" class="list-group">
 
        <!-- <h3 id="itemm" class="list-group-item Rem" >ADDED ITEM WILL BE SEEN HERE</h3> -->
        <!-- <li id="item" class="list-group-item" ></li> -->
  </ul>
</div>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script >
  let timee=13
  console.log(timee)
    let warn=document.getElementById("warn");
    let adder=document.getElementById("adder");
    let buttonn=document.getElementById('buttonn')
    let button=document.getElementById('button')
    let itemadd =document.getElementById('item')
    let addhere =document.getElementById('addhere')
    let firstr=document.getElementById('itemm')
    buttonn.addEventListener('click',clearall) 
    function remove(currentli){
      let oldtext=currentli.parentElement.children[0].textContent
      console.log(oldtext)
      text=oldtext.substr(1);
      window.location.href="index.php?remove="+text;
     }
     function edit(currentli){
      let oldtext=currentli.parentElement.children[0].textContent
      console.log(oldtext)
      text=oldtext.substr(1);
      console.log("yeseE");
      let eval=prompt("PLEASE WRITE THE NEW TASK FOR OLD TASK"+oldtext );
  if(eval){
  window.location.href="index.php?edit="+text+eval;
 console.log("yese");
  }
  else{
    console.log("noe");
  window.location.href="index.php";
  }
   }
      function clearall() {
        console.log("clearing");  
      }
 </script>
</body>

</html>
<?php
$error=false;
if(isset($_GET['all'])){
  $clearall = "TRUNCATE tasks";
  $result =  mysqli_query($conn,$clearall);
  echo '<script type="text/JavaScript">
  warn.className="alert alert-danger op";
  warn.innerHTML="ALL TASKS REMOVED SUCESSFULLY";
  </script>';
  }
  if(isset($_GET['edit'])){
    $edit=$_GET['edit'];
    $old=explode(' ',$edit);
    // print_r($old[1]);
    try{
    $eedit = "UPDATE `tasks` SET `task` = '$old[1]' WHERE `tasks`.`task` = '$old[0]'";
    $result =  mysqli_query($conn,$eedit);
    }
    catch(Exception $e){
      $error=true;
      echo '<script type="text/JavaScript"> 
      warn.className="alert alert-danger op";
    warn.innerHTML=` "'. $old[1].'" TASK IS ALREADY IN THE LIST`;
    </script>';
  }
  if(!$error){
    echo '<script type="text/JavaScript">
    warn.className="alert alert-danger op";
    warn.innerHTML=`TASK "'. $old[0].'" IS EDITED TO "'. $old[1].'" SUCESSFULLY`;
    </script>';
  }
    }
  if(isset($_GET['remove'])){
    $remove=$_GET['remove'];
    $removee = "DELETE FROM `tasks` WHERE `tasks`.`task` = '$remove' ";
    $result0 =  mysqli_query($conn,$removee);
    echo '<script type="text/JavaScript">
    warn.className="alert alert-danger op";
    warn.innerHTML=` TASK "'. $remove.'" REMOVED SUCESSFULLY`;
    </script>';
    }
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_POST['all']=='add'){
    $Task    = $_POST['task'];
  // echo "<br>ssa" . $task;
  if($Task || $Task==0 ){
    $sql = "INSERT INTO `tasks` ( `task`) VALUES ( '$Task')";
  try{
  $result =  mysqli_query($conn,$sql);
  echo '<script type="text/JavaScript"> warn.className="alert alert-primary";
  warn.innerHTML=`TASK "'.$Task.'" IS INSERTED SUCESSFULLY`
  </script>';
  }
  catch(Exception $e){
    echo '<script type="text/JavaScript"> 
    warn.className="alert alert-danger op";
  warn.innerHTML="DUPLICATE VALUES ARE NOT ALLOWED";
  </script>';
}
  }

  else{
    echo '<script type="text/JavaScript">
  warn.className="alert alert-danger op";
  warn.innerHTML="NULL VALUE IS NOT ALLOWED";
  </script>';
  // echo "can not be zero";
}
echo '<script type="text/JavaScript"> 
adder.value="";
</script>';
}
elseif($_POST['all']=='clear'){
  echo '<script type="text/JavaScript">
  let flag=confirm("ARE YOU SURE YOUR ALL DATA WILL BE DELETED ?")
  if(flag){
    window.location="index.php?all=" + flag;
    console.log("yes");
  }
  else{
    window.location="index.php";
    console.log("no");
  }
  
  </script>';
  
}
elseif($_POST['all']=='add'){
  echo '<script type="text/JavaScript">
  let eval=prompt("PLEASE WRITE THE EDITED VALUE")
  if(eval){
    window.location="index.php?edit="+eval+;
    console.log("yese");
  }
  else{
    window.location="index.php";
    console.log("noe");
  }
  
  </script>';
  
}
}
?>
 <?php
  $data="SELECT * FROM `tasks` ORDER BY `tasks`.`no` ASC";
  $alldata=mysqli_query($conn,$data);
  while($row = mysqli_fetch_assoc($alldata)){
    // echo $row['task'] . "<br>"; 
    $addvalue = $row['task']; 
    //  echo $addvalue;
    echo '<script type="text/JavaScript"> 
    addhere.innerHTML+=`<li class="list-group-item d-flex justify-content-between" ><h3 id="item" name="before" value="'. $addvalue . '" class="flex-grow-1 tra"> ' . $addvalue . ' </h3> 
    <button class="btn btn-warning mx-5 fix editt" type="submit"  onclick="edit(this)">Edit</button>
    <button class="btn btn-danger fix"  onclick="remove(this)" type="submit" name="beforeedit" value="er" >Remove</button></li>`;
    </script>';
    echo '';
  }
  ?>
  <!-- // echo '<script type="text/JavaScript"> 
  //   warn.className="alert alert-danger ";
  //   warn.innerHTML="VALUE IS EDITED '. $_POST['before'] . '"
  //   </script>';
  // if(isset( $_POST['before'])){
  //   $prev= $_POST['before']; 
  //   if($_POST['beforeedit']=='ed'){
  //     echo '<script type="text/JavaScript"> 
  //   warn.className="alert alert-danger ";
  //   warn.innerHTML="VALUE IS EDITED '. $_POST['eedit'] . '"
  //   </script>';
  //   }
  //   elseif ($_POST['beforeedit']=='er'){
  //     echo '<script type="text/JavaScript"> 
  //   warn.className="alert alert-danger ";
  //   warn.innerHTML="VALUE IS EDITED '. $_POST['eedit'] . '"
  //   </script>';
  //   }
  // if($_POST['eedit']=='ec'){
  //   $Editname = $_POST['editval'];
  //   $change="UPDATE `tasks` SET `task` = '$Editname' WHERE `tasks`.`task` = '1' ";
  //   $resultchange =  mysqli_query($conn,$change);
  //   echo '<script type="text/JavaScript"> 
  //   warn.className="alert alert-danger ";
  //   warn.innerHTML="VALUE IS EDITED '. $_POST['editval'] . '"
  //   </script>';
  // }
  // else -->
  <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->