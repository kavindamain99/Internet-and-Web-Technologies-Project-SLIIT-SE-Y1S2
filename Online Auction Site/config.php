<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auc_sys_2020";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


//get all from item table
//check for old items
//if there are used for bidding get all bids related to that item
//find the max bid
//update cart with buyer and seller id and item id  || or iteam table sell status

$sql = "SELECT * FROM auc_sys_item";

$item_list_result = $conn->query($sql);

if ($item_list_result->num_rows > 0) {
  while ($item_list_arr = $item_list_result->fetch_assoc()) {

    $due_date =  date('Y-m-d', strtotime($item_list_arr['due_date']));
    $nowTime = date("Y-m-d");

    $datetime1 = new DateTime($due_date);
    $datetime2 = new DateTime($nowTime);
    $interval = $datetime1->diff($datetime2);

    $day_diff = $interval->format('%R%a');

    // echo $day_diff . "<br>";

    //if expired
    if ($day_diff > 0) {

      $item_id = $item_list_arr["item_id"];
      $item_id . " expired item id <br>";

      //try to get records to check the avalability of bids
      $sql = "SELECT * FROM auc_sys_bids WHERE item_id_fk = '$item_id'";
      $result = $conn->query($sql);  
      // print_r($result);

      //if bids are available
      // echo "checking for bids" . "<br>";
      if ($result->num_rows > 0) {
        //get the highest bid and buyer id
        // echo "bids found, getting max bid" . "<br>";

        $sql_2 = "SELECT buyer_id_fk, item_id_fk, MAX(bid_price) AS max_price FROM auc_sys_bids";
        $result_2 = $conn->query($sql_2);

        if ($result_2->num_rows > 0) {
          // output data of each row
          $row_2 = $result_2->fetch_assoc();
          $buyer_id_fk = $row_2["buyer_id_fk"];
          $max_price = $row_2["max_price"];
          $item_id_fk = $row_2["item_id_fk"];


          //deleted items are moved to another table before feletion
          $sql_4 = "SELECT * FROM auc_sys_item WHERE  item_id = $item_id_fk";
          $result_3 = $conn->query($sql_4);
          $row_3 = $result_3->fetch_assoc();


          $item_id = $row_3['item_id'];
          $item_name = $row_3['item_name'];
          // $seller_id = $row_3['img_name'];
          $item_price = $row_3['item_price'];
          $seller_id_fk = $row_3['seller_id_fk'];


          $sql_5 = "INSERT INTO auc_sys_rm_items (item_id, item_name, seller_id, item_price, bid_winner_id, max_price) VALUES('$item_id', '$item_name', '$seller_id_fk', '$item_price', $buyer_id_fk, $max_price )";
          $conn->query($sql_5);

          //deleted from bids
          $sql_6 = "DELETE FROM auc_sys_bids WHERE item_id_fk = $item_id";
          $conn->query($sql_6);


          //deleted from store
          $sql_7 = "DELETE FROM auc_sys_item WHERE item_id = $item_id";
          $conn->query($sql_7);
        }
      } 
        
        //if no bids for item
        else {

        //deleted from bids
        $sql_8 = "DELETE FROM auc_sys_bids WHERE item_id_fk = $item_id";
        $conn->query($sql_8);

        //deleted from store
        $sql_9 = "DELETE FROM auc_sys_item WHERE item_id = $item_id";
        $conn->query($sql_9);
            
      }
    }
  }
}
