
<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$item_name = $item_price = $due_time = $due_date =  $fileName = "";
$item_price_err = $item_name_err  = $due_date_err = $due_time_err = $file_upload_stat = $success_1 =  "";

$seller_id = $_SESSION["id"];
$item_id_update = $_SESSION["seller_item_id_update"]; 

$sql = "SELECT * FROM auc_sys_item WHERE item_id = '$item_id_update'";
$cart_items = $conn->query($sql);
$cart_items_arr = $cart_items->fetch_assoc();




if (isset($_POST["item_submit"])) {
    function test_input($form_data)
    {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    //Item name
    if (empty($_POST["item_name"])) {
        $item_name_err = "Item name is required";
    } else {
        $item_name = test_input($_POST["item_name"]);
    }

    if (!empty($_FILES["file"]["name"])) {

        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $file_upload_stat = "The file " . $fileName . " has been uploaded successfully.";
                // echo $file_upload_stat;
            } else {
                $file_upload_stat = "Sorry, there was an error uploading your file.";
            }
        } else {
            $file_upload_stat = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $file_upload_stat = 'Please select a file to upload*';
    }

    //item price
    if (empty($_POST["item_price"])) {
        $item_price_err = "Item price is required*";
    } else {
        $item_price = test_input($_POST["item_price"]);
    }

    //due_date
    if (empty($_POST["due_date"])) {
        $due_date_err = "Due date is required*";
    } else {
        $due_date = $_POST["due_date"];
    }

    //due_time
    if (empty($_POST["due_time"])) {
        $due_time_err = "Due time is required*";
    } else {
        $due_time = $_POST["due_time"];
    }

    if ($item_name && $item_price && $due_date ) {

        $sql = "UPDATE auc_sys_item SET item_name='$item_name', item_price='$item_price', due_date='$due_date' WHERE item_id = $item_id_update";

        $item_name = $item_price = $due_time = $due_date =  $fileName = "";
        $success_1 = "Item added successfully";
        header('Location:seller_dashboard.php');



        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>

    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
</head>


<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
        
    </div>
    
    
    
</header>    
    
<body>
    <div class="outer-wrapper">
        <div class="card-wrapper">
            <div class="card-body">
                <div class="reg-form-div">
                    <h1 class="title">Add items to Store</h1>
                    <p class="title-tag">Please fill in this form to add items to the store.</p>
                    <hr class="hr-styles">
                    
                    
                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                        <div class="div-row">
                            <label class="input-label"> Item name</label>
                            <input class="input-field" type="text" name="item_name" value="<?php echo $cart_items_arr["item_name"]; ?>"><br>
                            <p class="error"><?php echo  $item_name_err ?> </p>
                        </div>

                        <!-- <div class="div-row">
                            <label class="input-label">Item Image</label>
                            <input class="input-field" type="file" name="file"  value="" id="fileToUpload">
                            <p class="error">> </p>
                        </div> -->

                        <div class="div-row">
                            <label class="input-label">Price</label>
                            <input class="input-field" type="number" step="0.01" name="item_price" value="<?php echo $cart_items_arr["item_price"]; ?>"><br>
                            <p class="error"><?php echo  $item_price_err ?> </p>
                        </div>

                        <div class="div-row">
                            <label class="input-label"> Due date</label>
                            <input class="input-field" type="date" name="due_date" value="<?php echo $cart_items_arr["due_date"]; ?>">
                            <p class="error"><?php echo  $due_date_err ?> </p>
                        </div>

                        <!-- <div class="div-row">
                            <label class="input-label"> Due time</label>
                            <input class="input-field" type="time" name="due_time"  value="">
                            <p class="error"> </p>
                        </div> -->

                        <div class="btn-div-add">
                            <input class="btn btn-radius-2 btn-blue" type="submit" value="Add Item" name="item_submit">
                        </div>

                        <p class="success"><?php echo  $success_1 ?> </p>

                    </form>
                    <a class="tag-bottom-text text-dec-rm" href="seller_dashboard.php">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>

</body>

    <footer id="footer">
  <div id="list">  
<ul>
    <li><a href="#">&#169 2020 |</a></li>  
    <li><a href="#">Register For Free |</a></li>
    <li><a href="#">Privacy Policy |</a></li>
    <li><a href="#">Terms of Use |</a></li>
    <form>
    <input type="email" name="notification" placeholder="Your Email adress">
    <input type="submit" value="Connect" style="background-color:greenyellow">        
    <label for="notification" style="color:white">Connect us ! Be the First to Know Premier items delivered to your inbox.</label>
    
    </form>

 
</ul>    
</div>    
    
</footer>  
</html>