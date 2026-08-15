 <?php
include ("connect.php");
global $conn;
if(isset($_POST['submit'])){
    $file_name=$_FILES['image']['name'];
    $tempname=$_FILES['image'][''];
    $folder='images/'.$file_name;
    $query=mysqli_query($conn,"INSERT INTO users (file) VALUES ('$file_name')");
    if(move_uploaded_file($tempname,$folder)){
        echo "<h2>file succesfully uploaded</h2>";
    }
    else{
        echo "<h2>file not uploaded</h2>";
    }
}
?>
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Form Validation</title>
</head>
<body>
<form onsubmit="return validateForm()"  method="POST" enetype="multipart/form-data"> 
    Name:
    <input type="text" id="name"><br><br>
    Email:
    <input type="text" id="email"><br><br>
    Gender:
    <input type="radio" name="gender" value="Male"> Male
    <input type="radio" name="gender" value="Female"> Female
    <br><br>
    Qualification:
    <input type="checkbox" name="qualification" value="High School"> High School
    <input type="checkbox" name="qualification" value="Graduate"> Graduate
    <input type="checkbox" name="qualification" value="Post Graduate"> Post Graduate
    <br><br>
    Image:
    <input type="file" id="image"><br><br>
    Password:
    <input type="password" id="password"><br><br>
    <button type="submit" value="submit">Submit</button>
</form>
<====================After uploading display it====================>
<div class="">
   
</div>
<script>
function validateForm() {

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var image = document.getElementById("image").value;
    var gender = document.getElementsByName("gender");
    var qualification = document.getElementsByName("qualification");

    // Name
    if (name == "") {
        alert("Please enter your name");
        return false;
    }

    // Email
    if (email == "" || !email.includes("@")) {
        alert("Enter valid email");
        return false;
    }

    // Gender
    var genderSelected = false;
    for (var i = 0; i < gender.length; i++) {
        if (gender[i].checked) {
            genderSelected = true;
        }
    }
    if (!genderSelected) {
        alert("Please select gender");
        return false;
    }

    // Qualification (at least one checkbox)
    var qualificationSelected = false;
    for (var i = 0; i < qualification.length; i++) {
        if (qualification[i].checked) {
            qualificationSelected = true;
        }
    }
    if (!qualificationSelected) {
        alert("Please select at least one qualification");
        return false;
    }

    // Image
    if (image == "") {
        alert("Please upload image");
        return false;
    }

    // Password
    if (password.length < 4) {
        alert("Password must be at least 4 characters");
        return false;
    }

    alert("Form submitted successfully!");
    return true;
}
</script>

</body>
</html> -->










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sign Up page</h1>

    <form onsubmit="return signup()" action="form_action.php" method="POST" enctype="multipart/form-data" >
        Name: <input type="text" name="name" id="name"><br><br>
        Email: <input type="text" name="email" id="email"><br><br>
        Password: <input type="text" name="password" id="password"><br><br>
        
        Gender: <input type="radio" name="gender" value="male" class="gen">Male
        <input type="radio" name="gender" value="female" class="gen">Female <br><br>

        Qualification: 
        <input type="checkbox" name="quali" value="MP" class="qualification" id="" >MP 
        <input type="checkbox" name="quali" value="HS" class="qualification">HS
        <input type="checkbox" name="quali" value="graduation" id="" class="qualification" >Graduation
        <input type="checkbox" name="quali" value="Master" id="" class="qualification">Master 
        <br><br>

        Image: <input type="file" name="image" value="Image" id="image" accept="image/*"/><br/> <br/>
        <img src="images/background.avif" id="imgpreview" name="image" value="Image" alt=""><br><br>
        
        <button type="submit" name="submit" value="submit">Submit</button>
    </form>


    <script>
        function signup(){
            const name=document.getElementById('name').value;
            const email=document.getElementById('email').value;
            const password=document.getElementById('password').value;
            const gender=document.querySelectorAll('input[class="gen"]:checked');
            const qualify=document.querySelectorAll('input[class="qualification"]:checked');

            if(name=="" || email=="" || password==""){
                alert("All field are mandatory");
                return false;
            }
            else if(qualify.length==0){
                alert("All field are mandatory");
                return false;
            }
            else if(gender.length==0){
                alert("All field are mandatory");
                return false;
            }
            
            else{
                return true;
            }
        }

        // Image
        const fileinput=document.getElementById('image');
        const imgpreview=document.getElementById('imgpreview');
        fileinput.addEventListener("change",function(){
            const file=this.files[0];
            if(file && file.type.startsWith('image/')){
                const reader=new FileReader();
                reader.addEventListener("load",function(){
                    imgpreview.src=reader.result;
                    imgpreview.style.display='block';
                });
                reader.readAsDataURL(file);
            }
            else{
                alert("Please select a image file");
                imgpreview.src="images/background.avif";
            }
        });

    </script>

</body>
</html>