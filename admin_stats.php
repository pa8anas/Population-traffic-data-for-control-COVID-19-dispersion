<?php

// Include the database
require('config.php');

// Resume the previous session
session_start();

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit();
}

require_once("functions.php");

// fetch data from database
$number_of_visits = mysqli_query($con,"SELECT COUNT(*) FROM visit_declaration");

$stmt = $con->prepare('SELECT COUNT(*) AS number_of_visits FROM visit_declaration');
      // Bind the parameters and execute the query
      //$stmt3->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($number_of_visits);
      $stmt->fetch();
      $stmt->close();

$stmt2 = $con->prepare('SELECT COUNT(*) AS number_of_infectedusers FROM infectedusers');
      // Bind the parameters and execute the query
      //$stmt3->bind_param('s', $id);
      $stmt2->execute();
      $stmt2->store_result();
      $stmt2->bind_result($number_of_infectedusers);
      $stmt2->fetch();
      $stmt2->close();

// Create select query
$query = "SELECT userID,date FROM infectedusers";
$result = $con->query($query);
$sum = NULL;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    $stmt3 = $con->prepare('SELECT COUNT(*) AS number_of_infectedusers_visits FROM visit_declaration WHERE userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)');
          // Bind the parameters and execute the query
          $stmt3->bind_param('sss', $row["userID"], $row["date"], $row["date"]);
          $stmt3->execute();
          $stmt3->store_result();
          $stmt3->bind_result($number_of_infectedusers_visits);
          $stmt3->fetch();
          $stmt3->close();

          $sum = $sum + $number_of_infectedusers_visits;
          //echo "<h2>" . $row["userID"] . "</h2>";
          //echo "<h2>" . $row["date"] . "</h2>";
  }
} else {
  echo "0 results";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Stats</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Covid-19 Tracing</h1>


        <!-- Navigation Bar -->
        <a href="admin.php"><i class="fas fa-user"></i>Home Page</a>
        <a href="admin_stats.php"><i class="selected fas fa-chart-line"></i>Stats</a>
        <a href="admin_upload.php"><i class="fas fa-cloud-upload-alt"></i>Upload</a>
        <a href="admin_delete.php"><i class="fas fa-trash-restore-alt"></i>Delete</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

    </div>
</nav>
<div class="content">
    <h2>Admin Stats</h2>

    <div>
      <table border="2">
         <tr>
           <td>Total Number of Visits</td>
         </tr>
         <tr>
           <td><?php echo "$number_of_visits"; ?></td>
         </tr>
      </table>
    </div>

    <div>
      <table border="2">
         <tr>
            <td>Total Number of Infected Users</td>
         </tr>
         <tr>
            <td><?php echo "$number_of_infectedusers"; ?></td>
         </tr>
      </table>
    </div>

    <div>
          <table border="2">
             <tr>
                <td>Total Number of Visits by Instances</td>
             </tr>
             <tr>
                <td><?php echo "$sum"; ?></td>
             </tr>
          </table>
        </div>

    <!-- Range Picker -->
    <div>
        <h2> See the visits per day of a month </h2>
        <form action="admin_stats.php" method="post">
            <!-- Month Range -->
            <label for="month">Month:</label>
            <select id="month" name="month">
                <?php echo monthOption(); ?>
            </select>
            <br/><br/>
            <!-- Filter Range -->
            <label for="filter">Start Year:</label>
            <select id="filter" name="filter">
              <option value="visits per day">Visits per day</option>
              <option value="visits from instances per day">Visits from instances per day</option>
            </select>
            <br/><br/>
            <input type="submit" name="submit" value="Show">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    <?php
    //categories' leaderboard by visits
    // Create select query to get POIs ids from visit_declaration table
    $query2 = "SELECT id FROM visit_declaration";
        $result2 = $con->query($query2);
        $pet_store = NULL;
        $cafe = NULL;
        $restaurant = NULL;
        $food = NULL;
        $establishment = NULL;
        $convenience_store = NULL;
        $grocery_or_supermarket = NULL;
        $store = NULL;
        $bakery = NULL;
        $supermarket = NULL;
        $car_repair = NULL;
        $park = NULL;
        $tourist_attraction = NULL;
        $gym = NULL;
        $health = NULL;
        $car_wash = NULL;
        $liquor_store = NULL;
        $shopping_mall = NULL;
        $furniture_store = NULL;
        $home_goods_store = NULL;
        $lodging = NULL;
        $laundry = NULL;
        $hardware_store = NULL;
        $electronics_store = NULL;
        $hair_care = NULL;
        $drugstore = NULL;
        $bank = NULL;
        $atm = NULL;
        $finance = NULL;
        $doctor = NULL;
        $casino = NULL;
        $car_dealer = NULL;
        $bar = NULL;
        $town_square = NULL;
        $accounting = NULL;
        $pharmacy = NULL;

        if ($result2->num_rows > 0) {
          // output data of each row
          while($row2 = $result2->fetch_assoc()) {

        //count pet_store number
         $stmt4 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%pet_store%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt4->bind_param('s', $row2["id"]);
         $stmt4->execute();
         $stmt4->store_result();
         $stmt4->bind_result($pet_store_result);
         $stmt4->fetch();
         $stmt4->close();
         $pet_store = $pet_store + $pet_store_result;


         //count cafe number
         $stmt5 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%cafe%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt5->bind_param('s', $row2["id"]);
         $stmt5->execute();
         $stmt5->store_result();
         $stmt5->bind_result($cafe_result);
         $stmt5->fetch();
         $stmt5->close();
         $cafe = $cafe + $cafe_result;

         //count restaurant number
         $stmt6 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%restaurant%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt6->bind_param('s', $row2["id"]);
         $stmt6->execute();
         $stmt6->store_result();
         $stmt6->bind_result($restaurant_result);
         $stmt6->fetch();
         $stmt6->close();
         $restaurant = $restaurant + $restaurant_result;

         //count food number
         $stmt7 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%food%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt7->bind_param('s', $row2["id"]);
         $stmt7->execute();
         $stmt7->store_result();
         $stmt7->bind_result($food_result);
         $stmt7->fetch();
         $stmt7->close();
         $food = $food + $food_result;

         //count establishment number
         $stmt8 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%establishment%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt8->bind_param('s', $row2["id"]);
         $stmt8->execute();
         $stmt8->store_result();
         $stmt8->bind_result($establishment_result);
         $stmt8->fetch();
         $stmt8->close();
         $establishment = $establishment + $establishment_result;

         //count convenience_store number
         $stmt9 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%convenience_store%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt9->bind_param('s', $row2["id"]);
         $stmt9->execute();
         $stmt9->store_result();
         $stmt9->bind_result($convenience_store_result);
         $stmt9->fetch();
         $stmt9->close();
         $convenience_store = $convenience_store + $convenience_store_result;

         //count grocery_or_supermarket number
         $stmt10 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%grocery_or_supermarket%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt10->bind_param('s', $row2["id"]);
         $stmt10->execute();
         $stmt10->store_result();
         $stmt10->bind_result($grocery_or_supermarket_result);
         $stmt10->fetch();
         $stmt10->close();
         $grocery_or_supermarket = $grocery_or_supermarket + $grocery_or_supermarket_result;

         //count store number
         $stmt11 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%store%' AND id = ?");
         // Bind the parameters and execute the query
         $stmt11->bind_param('s', $row2["id"]);
         $stmt11->execute();
         $stmt11->store_result();
         $stmt11->bind_result($store_result);
         $stmt11->fetch();
         $stmt11->close();
         $store = $store + $store_result;

          //count bakery number
          $stmt12 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bakery%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt12->bind_param('s', $row2["id"]);
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($bakery_result);
          $stmt12->fetch();
          $stmt12->close();
          $bakery = $bakery + $bakery_result;

          //count supermarket number
          $stmt13 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%supermarket%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt13->bind_param('s', $row2["id"]);
          $stmt13->execute();
          $stmt13->store_result();
          $stmt13->bind_result($supermarket_result);
          $stmt13->fetch();
          $stmt13->close();
          $supermarket = $supermarket + $supermarket_result;

          //count car_repair number
          $stmt14 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_repair%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt14->bind_param('s', $row2["id"]);
          $stmt14->execute();
          $stmt14->store_result();
          $stmt14->bind_result($car_repair_result);
          $stmt14->fetch();
          $stmt14->close();
          $car_repair = $car_repair + $car_repair_result;

          //count park number
          $stmt15 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%park%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt15->bind_param('s', $row2["id"]);
          $stmt15->execute();
          $stmt15->store_result();
          $stmt15->bind_result($park_result);
          $stmt15->fetch();
          $stmt15->close();
          $park = $park + $park_result;

          //count tourist_attraction number
          $stmt16 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%tourist_attraction%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt16->bind_param('s', $row2["id"]);
          $stmt16->execute();
          $stmt16->store_result();
          $stmt16->bind_result($tourist_attraction_result);
          $stmt16->fetch();
          $stmt16->close();
          $tourist_attraction = $tourist_attraction + $tourist_attraction_result;


          //count gym number
          $stmt17 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%gym%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt17->bind_param('s', $row2["id"]);
          $stmt17->execute();
          $stmt17->store_result();
          $stmt17->bind_result($gym_result);
          $stmt17->fetch();
          $stmt17->close();
          $gym = $gym + $gym_result;

          //count health number
          $stmt18 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%health%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt18->bind_param('s', $row2["id"]);
          $stmt18->execute();
          $stmt18->store_result();
          $stmt18->bind_result($health_result);
          $stmt18->fetch();
          $stmt18->close();
          $health = $health + $health_result;

          //count car_wash number
          $stmt19 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_wash%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt19->bind_param('s', $row2["id"]);
          $stmt19->execute();
          $stmt19->store_result();
          $stmt19->bind_result($car_wash_result);
          $stmt19->fetch();
          $stmt19->close();
          $car_wash = $car_wash + $car_wash_result;

          //count liquor_store number
          $stmt20 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%liquor_store%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt20->bind_param('s', $row2["id"]);
          $stmt20->execute();
          $stmt20->store_result();
          $stmt20->bind_result($liquor_store_result);
          $stmt20->fetch();
          $stmt20->close();
          $liquor_store = $liquor_store + $liquor_store_result;

          //count shopping_mall number
          $stmt21 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%shopping_mall%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt21->bind_param('s', $row2["id"]);
          $stmt21->execute();
          $stmt21->store_result();
          $stmt21->bind_result($shopping_mall_result);
          $stmt21->fetch();
          $stmt21->close();
          $shopping_mall = $shopping_mall + $shopping_mall_result;

          //count furniture_store number
          $stmt22 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%furniture_store%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt22->bind_param('s', $row2["id"]);
          $stmt22->execute();
          $stmt22->store_result();
          $stmt22->bind_result($furniture_store_result);
          $stmt22->fetch();
          $stmt22->close();
          $furniture_store = $furniture_store + $furniture_store_result;

          //count home_goods_store number
          $stmt23 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%home_goods_store%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt23->bind_param('s', $row2["id"]);
          $stmt23->execute();
          $stmt23->store_result();
          $stmt23->bind_result($home_goods_store_result);
          $stmt23->fetch();
          $stmt23->close();
          $home_goods_store = $home_goods_store + $home_goods_store_result;

          //count lodging number
          $stmt24 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%lodging%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt24->bind_param('s', $row2["id"]);
          $stmt24->execute();
          $stmt24->store_result();
          $stmt24->bind_result($lodging_result);
          $stmt24->fetch();
          $stmt24->close();
          $lodging = $lodging + $lodging_result;

          //count laundry number
          $stmt25 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%laundry%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt25->bind_param('s', $row2["id"]);
          $stmt25->execute();
          $stmt25->store_result();
          $stmt25->bind_result($laundry_result);
          $stmt25->fetch();
          $stmt25->close();
          $laundry = $laundry + $laundry_result;

          //count hardware_store number
          $stmt26 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%hardware_store%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt26->bind_param('s', $row2["id"]);
          $stmt26->execute();
          $stmt26->store_result();
          $stmt26->bind_result($hardware_store_result);
          $stmt26->fetch();
          $stmt26->close();
          $hardware_store = $hardware_store + $hardware_store_result;

          //count electronics_store number
          $stmt27 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%electronics_store%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt27->bind_param('s', $row2["id"]);
          $stmt27->execute();
          $stmt27->store_result();
          $stmt27->bind_result($electronics_store_result);
          $stmt27->fetch();
          $stmt27->close();
          $electronics_store = $electronics_store + $electronics_store_result;

          //count hair_care number
          $stmt28 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%hair_care%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt28->bind_param('s', $row2["id"]);
          $stmt28->execute();
          $stmt28->store_result();
          $stmt28->bind_result($hair_care_result);
          $stmt28->fetch();
          $stmt28->close();
          $hair_care = $hair_care + $hair_care_result;

          //count drugstore number
          $stmt29 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%drugstore%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt29->bind_param('s', $row2["id"]);
          $stmt29->execute();
          $stmt29->store_result();
          $stmt29->bind_result($drugstore_result);
          $stmt29->fetch();
          $stmt29->close();
          $drugstore = $drugstore + $drugstore_result;

          //count bank number
          $stmt30 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bank%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt30->bind_param('s', $row2["id"]);
          $stmt30->execute();
          $stmt30->store_result();
          $stmt30->bind_result($bank_result);
          $stmt30->fetch();
          $stmt30->close();
          $bank = $bank + $bank_result;

          //count atm number
          $stmt31 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%atm%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt31->bind_param('s', $row2["id"]);
          $stmt31->execute();
          $stmt31->store_result();
          $stmt31->bind_result($atm_result);
          $stmt31->fetch();
          $stmt31->close();
          $atm = $atm + $atm_result;

          //count finance number
          $stmt32 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%finance%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt32->bind_param('s', $row2["id"]);
          $stmt32->execute();
          $stmt32->store_result();
          $stmt32->bind_result($finance_result);
          $stmt32->fetch();
          $stmt32->close();
          $finance = $finance + $finance_result;

          //count doctor number
          $stmt33 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%doctor%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt33->bind_param('s', $row2["id"]);
          $stmt33->execute();
          $stmt33->store_result();
          $stmt33->bind_result($doctor_result);
          $stmt33->fetch();
          $stmt33->close();
          $doctor = $doctor + $doctor_result;

          //count casino number
          $stmt34 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%casino%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt34->bind_param('s', $row2["id"]);
          $stmt34->execute();
          $stmt34->store_result();
          $stmt34->bind_result($casino_result);
          $stmt34->fetch();
          $stmt34->close();
          $casino = $casino + $casino_result;

          //count car_dealer number
          $stmt35 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_dealer%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt35->bind_param('s', $row2["id"]);
          $stmt35->execute();
          $stmt35->store_result();
          $stmt35->bind_result($car_dealer_result);
          $stmt35->fetch();
          $stmt35->close();
          $car_dealer = $car_dealer + $car_dealer_result;

          //count bar number
          $stmt36 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bar%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt36->bind_param('s', $row2["id"]);
          $stmt36->execute();
          $stmt36->store_result();
          $stmt36->bind_result($bar_result);
          $stmt36->fetch();
          $stmt36->close();
          $bar = $bar + $bar_result;

          //count town_square number
          $stmt37 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%town_square%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt37->bind_param('s', $row2["id"]);
          $stmt37->execute();
          $stmt37->store_result();
          $stmt37->bind_result($town_square_result);
          $stmt37->fetch();
          $stmt37->close();
          $town_square = $town_square + $town_square_result;

          //count accounting number
          $stmt38 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%accounting%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt38->bind_param('s', $row2["id"]);
          $stmt38->execute();
          $stmt38->store_result();
          $stmt38->bind_result($accounting_result);
          $stmt38->fetch();
          $stmt38->close();
          $accounting = $accounting + $accounting_result;

          //count pharmacy number
          $stmt39 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%pharmacy%' AND id = ?");
          // Bind the parameters and execute the query
          $stmt39->bind_param('s', $row2["id"]);
          $stmt39->execute();
          $stmt39->store_result();
          $stmt39->bind_result($pharmacy_result);
          $stmt39->fetch();
          $stmt39->close();
          $pharmacy = $pharmacy + $pharmacy_result;
          }
          }
          $categories = array("pet store"=>$pet_store , "cafe"=>$cafe, "restaurant"=>$restaurant,
                "food"=>$food, "establishment"=>$establishment, "convenience store"=>$convenience_store,
                "grocery or supermarket"=>$grocery_or_supermarket, "store"=>$store, "bakery"=>$bakery, "supermarket"=>$supermarket,
                "car repair"=>$car_repair, "park"=>$park, "tourist attraction"=>$tourist_attraction, "gym"=>$gym,
                "health"=>$health, "car wash"=>$car_wash, "liquor store"=>$liquor_store, "shopping mall"=>$shopping_mall,
                "furniture store"=>$furniture_store, "home goods store"=>$home_goods_store, "lodging"=>$lodging, "laundry"=>$laundry,
                "hardware store"=>$hardware_store, "electronics store"=>$electronics_store, "hair care"=>$hair_care,
                "drugstore"=>$drugstore, "bank"=>$bank, "atm"=>$atm, "finance"=>$finance, "doctor"=>$doctor, "casino"=>$casino,
                "car dealer"=>$car_dealer, "bar"=>$bar, "town square"=>$town_square, "accounting"=>$accounting, "pharmacy"=>$pharmacy);
                arsort($categories);

          $arrayLabel = array();
          $arrayValue = array();
          foreach($categories as $label => $value) {
          array_push($arrayLabel,"$label");
          array_push($arrayValue,"$value");
          }

          $arrayLabel = json_encode($arrayLabel);
          $arrayValue = json_encode($arrayValue);

      echo "<div class='chart-container'><canvas id='visitspercategoryChart'></canvas></div>";

        $pet_store2 = NULL;
        $cafe2 = NULL;
        $restaurant2 = NULL;
        $food2 = NULL;
        $establishment2 = NULL;
        $convenience_store2 = NULL;
        $grocery_or_supermarket2 = NULL;
        $store2 = NULL;
        $bakery2 = NULL;
        $supermarket2 = NULL;
        $car_repair2 = NULL;
        $park2 = NULL;
        $tourist_attraction2 = NULL;
        $gym2 = NULL;
        $health2 = NULL;
        $car_wash2 = NULL;
        $liquor_store2 = NULL;
        $shopping_mall2 = NULL;
        $furniture_store2 = NULL;
        $home_goods_store2 = NULL;
        $lodging2 = NULL;
        $laundry2 = NULL;
        $hardware_store2 = NULL;
        $electronics_store2 = NULL;
        $hair_care2 = NULL;
        $drugstore2 = NULL;
        $bank2 = NULL;
        $atm2 = NULL;
        $finance2 = NULL;
        $doctor2 = NULL;
        $casino2 = NULL;
        $car_dealer2 = NULL;
        $bar2 = NULL;
        $town_square2 = NULL;
        $accounting2 = NULL;
        $pharmacy2 = NULL;


      //categories' leaderboard by instances' visits
      $query10 = "SELECT userid,date FROM userhistory";
      $result10 = $con->query($query10);
      if ($result10->num_rows > 0) {
                 // output data of each row
          while($row10 = $result10->fetch_assoc()) {

          // Create select query to get POIs ids from visit_declaration table
          //$visit_ids;
          $query11 = $con->prepare("SELECT id FROM visit_declaration WHERE userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
          // Bind the parameters and execute the query
          $query11->bind_param('sss', $row10["userid"], $row10["date"], $row10["date"]);
          $query11->execute();
          $result11 = $query11->get_result(); // get the mysqli result
            }
            }

          if ($result11->num_rows > 0) {
           while($row11 = $result11->fetch_assoc()) {
       echo "<h2>" . $row11["id"] . "</h2>";

              //count pet_store number
               $stmt42 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%pet_store%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt42->bind_param('s', $row11["id"]);
               $stmt42->execute();
               $stmt42->store_result();
               $stmt42->bind_result($pet_store_result2);
               $stmt42->fetch();
               $stmt42->close();
               $pet_store2 = $pet_store2 + $pet_store_result2;
                //echo "<h2>" . $pet_store_result2 . "</h2>";

               //count cafe number
               $stmt52 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%cafe%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt52->bind_param('s', $row11["id"]);
               $stmt52->execute();
               $stmt52->store_result();
               $stmt52->bind_result($cafe_result2);
               $stmt52->fetch();
               $stmt52->close();
               $cafe2 = $cafe2 + $cafe_result2;

               //count restaurant number
               $stmt62 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%restaurant%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt62->bind_param('s', $row11["id"]);
               $stmt62->execute();
               $stmt62->store_result();
               $stmt62->bind_result($restaurant_result2);
               $stmt62->fetch();
               $stmt62->close();
               $restaurant2 = $restaurant2 + $restaurant_result2;

               //count food number
               $stmt72 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%food%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt72->bind_param('s', $row11["id"]);
               $stmt72->execute();
               $stmt72->store_result();
               $stmt72->bind_result($food_result2);
               $stmt72->fetch();
               $stmt72->close();
               $food2 = $food2 + $food_result2;

               //count establishment number
               $stmt82 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%establishment%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt82->bind_param('s', $row11["id"]);
               $stmt82->execute();
               $stmt82->store_result();
               $stmt82->bind_result($establishment_result2);
               $stmt82->fetch();
               $stmt82->close();
               $establishment2 = $establishment2 + $establishment_result2;

               //count convenience_store number
               $stmt92 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%convenience_store%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt92->bind_param('s', $row11["id"]);
               $stmt92->execute();
               $stmt92->store_result();
               $stmt92->bind_result($convenience_store_result2);
               $stmt92->fetch();
               $stmt92->close();
               $convenience_store2 = $convenience_store2 + $convenience_store_result2;

               //count grocery_or_supermarket number
               $stmt102 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%grocery_or_supermarket%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt102->bind_param('s', $row11["id"]);
               $stmt102->execute();
               $stmt102->store_result();
               $stmt102->bind_result($grocery_or_supermarket_result2);
               $stmt102->fetch();
               $stmt102->close();
               $grocery_or_supermarket2 = $grocery_or_supermarket2 + $grocery_or_supermarket_result2;

               //count store number
               $stmt112 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%store%' AND id = ?");
               // Bind the parameters and execute the query
               $stmt112->bind_param('s', $row11["id"]);
               $stmt112->execute();
               $stmt112->store_result();
               $stmt112->bind_result($store_result2);
               $stmt112->fetch();
               $stmt112->close();
               $store2 = $store2 + $store_result2;

                //count bakery number
                $stmt122 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bakery%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt122->bind_param('s', $row11["id"]);
                $stmt122->execute();
                $stmt122->store_result();
                $stmt122->bind_result($bakery_result2);
                $stmt122->fetch();
                $stmt122->close();
                $bakery2 = $bakery2 + $bakery_result2;

                //count supermarket number
                $stmt132 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%supermarket%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt132->bind_param('s', $row11["id"]);
                $stmt132->execute();
                $stmt132->store_result();
                $stmt132->bind_result($supermarket_result2);
                $stmt132->fetch();
                $stmt132->close();
                $supermarket2 = $supermarket2 + $supermarket_result2;

                //count car_repair number
                $stmt142 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_repair%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt142->bind_param('s', $row11["id"]);
                $stmt142->execute();
                $stmt142->store_result();
                $stmt142->bind_result($car_repair_result2);
                $stmt142->fetch();
                $stmt142->close();
                $car_repair2 = $car_repair2 + $car_repair_result2;

                //count park number
                $stmt152 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%park%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt152->bind_param('s', $row11["id"]);
                $stmt152->execute();
                $stmt152->store_result();
                $stmt152->bind_result($park_result2);
                $stmt152->fetch();
                $stmt152->close();
                $park2 = $park2 + $park_result2;

                //count tourist_attraction number
                $stmt162 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%tourist_attraction%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt162->bind_param('s', $row11["id"]);
                $stmt162->execute();
                $stmt162->store_result();
                $stmt162->bind_result($tourist_attraction_result2);
                $stmt162->fetch();
                $stmt162->close();
                $tourist_attraction2 = $tourist_attraction2 + $tourist_attraction_result2;


                //count gym number
                $stmt172 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%gym%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt172->bind_param('s', $row11["id"]);
                $stmt172->execute();
                $stmt172->store_result();
                $stmt172->bind_result($gym_result2);
                $stmt172->fetch();
                $stmt172->close();
                $gym2 = $gym2 + $gym_result2;

                //count health number
                $stmt182 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%health%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt182->bind_param('s',$row11["id"]);
                $stmt182->execute();
                $stmt182->store_result();
                $stmt182->bind_result($health_result2);
                $stmt182->fetch();
                $stmt182->close();
                $health2 = $health2 + $health_result2;

                //count car_wash number
                $stmt192 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_wash%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt192->bind_param('s', $row11["id"]);
                $stmt192->execute();
                $stmt192->store_result();
                $stmt192->bind_result($car_wash_result2);
                $stmt192->fetch();
                $stmt192->close();
                $car_wash2 = $car_wash2 + $car_wash_result2;

                //count liquor_store number
                $stmt202 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%liquor_store%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt202->bind_param('s', $row11["id"]);
                $stmt202->execute();
                $stmt202->store_result();
                $stmt202->bind_result($liquor_store_result2);
                $stmt202->fetch();
                $stmt202->close();
                $liquor_store2 = $liquor_store2 + $liquor_store_result2;

                //count shopping_mall number
                $stmt212 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%shopping_mall%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt212->bind_param('s', $row11["id"]);
                $stmt212->execute();
                $stmt212->store_result();
                $stmt212->bind_result($shopping_mall_result2);
                $stmt212->fetch();
                $stmt212->close();
                $shopping_mall2 = $shopping_mall2 + $shopping_mall_result2;

                //count furniture_store number
                $stmt222 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%furniture_store%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt222->bind_param('s', $row11["id"]);
                $stmt222->execute();
                $stmt222->store_result();
                $stmt222->bind_result($furniture_store_result2);
                $stmt222->fetch();
                $stmt222->close();
                $furniture_store2 = $furniture_store2 + $furniture_store_result2;

                //count home_goods_store number
                $stmt232 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%home_goods_store%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt232->bind_param('s', $row11["id"]);
                $stmt232->execute();
                $stmt232->store_result();
                $stmt232->bind_result($home_goods_store_result2);
                $stmt232->fetch();
                $stmt232->close();
                $home_goods_store2 = $home_goods_store2 + $home_goods_store_result2;

                //count lodging number
                $stmt242 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%lodging%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt242->bind_param('s', $row11["id"]);
                $stmt242->execute();
                $stmt242->store_result();
                $stmt242->bind_result($lodging_result2);
                $stmt242->fetch();
                $stmt242->close();
                $lodging2 = $lodging2 + $lodging_result2;

                //count laundry number
                $stmt252 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%laundry%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt252->bind_param('s', $row11["id"]);
                $stmt252->execute();
                $stmt252->store_result();
                $stmt252->bind_result($laundry_result2);
                $stmt252->fetch();
                $stmt252->close();
                $laundry2 = $laundry2 + $laundry_result2;

                //count hardware_store number
                $stmt262 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%hardware_store%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt262->bind_param('s', $row11["id"]);
                $stmt262->execute();
                $stmt262->store_result();
                $stmt262->bind_result($hardware_store_result2);
                $stmt262->fetch();
                $stmt262->close();
                $hardware_store2 = $hardware_store2 + $hardware_store_result2;

                //count electronics_store number
                $stmt272 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%electronics_store%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt272->bind_param('s', $row11["id"]);
                $stmt272->execute();
                $stmt272->store_result();
                $stmt272->bind_result($electronics_store_result2);
                $stmt272->fetch();
                $stmt272->close();
                $electronics_store2 = $electronics_store2 + $electronics_store_result2;

                //count hair_care number
                $stmt282 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%hair_care%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt282->bind_param('s', $row11["id"]);
                $stmt282->execute();
                $stmt282->store_result();
                $stmt282->bind_result($hair_care_result2);
                $stmt282->fetch();
                $stmt282->close();
                $hair_care2 = $hair_care2 + $hair_care_result2;

                //count drugstore number
                $stmt292 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%drugstore%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt292->bind_param('s', $row11["id"]);
                $stmt292->execute();
                $stmt292->store_result();
                $stmt292->bind_result($drugstore_result2);
                $stmt292->fetch();
                $stmt292->close();
                $drugstore2 = $drugstore2 + $drugstore_result2;

                //count bank number
                $stmt302 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bank%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt302->bind_param('s', $row11["id"]);
                $stmt302->execute();
                $stmt302->store_result();
                $stmt302->bind_result($bank_result2);
                $stmt302->fetch();
                $stmt302->close();
                $bank2 = $bank2 + $bank_result2;

                //count atm number
                $stmt312 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%atm%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt312->bind_param('s', $row11["id"]);
                $stmt312->execute();
                $stmt312->store_result();
                $stmt312->bind_result($atm_result2);
                $stmt312->fetch();
                $stmt312->close();
                $atm2 = $atm2 + $atm_result2;

                //count finance number
                $stmt322 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%finance%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt322->bind_param('s', $row11["id"]);
                $stmt322->execute();
                $stmt322->store_result();
                $stmt322->bind_result($finance_result2);
                $stmt322->fetch();
                $stmt322->close();
                $finance2 = $finance2 + $finance_result2;

                //count doctor number
                $stmt332 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%doctor%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt332->bind_param('s', $row11["id"]);
                $stmt332->execute();
                $stmt332->store_result();
                $stmt332->bind_result($doctor_result2);
                $stmt332->fetch();
                $stmt332->close();
                $doctor2 = $doctor2 + $doctor_result2;

                //count casino number
                $stmt342 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%casino%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt342->bind_param('s', $row11["id"]);
                $stmt342->execute();
                $stmt342->store_result();
                $stmt342->bind_result($casino_result2);
                $stmt342->fetch();
                $stmt342->close();
                $casino2 = $casino2 + $casino_result2;

                //count car_dealer number
                $stmt352 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%car_dealer%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt352->bind_param('s', $row11["id"]);
                $stmt352->execute();
                $stmt352->store_result();
                $stmt352->bind_result($car_dealer_result2);
                $stmt352->fetch();
                $stmt352->close();
                $car_dealer2 = $car_dealer2 + $car_dealer_result2;

                //count bar number
                $stmt362 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%bar%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt362->bind_param('s', $row11["id"]);
                $stmt362->execute();
                $stmt362->store_result();
                $stmt362->bind_result($bar_result2);
                $stmt362->fetch();
                $stmt362->close();
                $bar2 = $bar2 + $bar_result2;

                //count town_square number
                $stmt372 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%town_square%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt372->bind_param('s', $row11["id"]);
                $stmt372->execute();
                $stmt372->store_result();
                $stmt372->bind_result($town_square_result2);
                $stmt372->fetch();
                $stmt372->close();
                $town_square2 = $town_square2 + $town_square_result2;

                //count accounting number
                $stmt382 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%accounting%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt382->bind_param('s', $row11["id"]);
                $stmt382->execute();
                $stmt382->store_result();
                $stmt382->bind_result($accounting_result2);
                $stmt382->fetch();
                $stmt382->close();
                $accounting2 = $accounting2 + $accounting_result2;

                //count pharmacy number
                $stmt392 = $con->prepare("SELECT COUNT(*) FROM data WHERE categories LIKE '%pharmacy%' AND id = ?");
                // Bind the parameters and execute the query
                $stmt392->bind_param('s', $row11["id"]);
                $stmt392->execute();
                $stmt392->store_result();
                $stmt392->bind_result($pharmacy_result2);
                $stmt392->fetch();
                $stmt392->close();
                $pharmacy2 = $pharmacy2 + $pharmacy_result2;
                }
                }

                $categories2 = array("pet store"=>$pet_store2 , "cafe"=>$cafe2, "restaurant"=>$restaurant2,
                      "food"=>$food2, "establishment"=>$establishment2, "convenience store"=>$convenience_store2,
                      "grocery or supermarket"=>$grocery_or_supermarket2, "store"=>$store2, "bakery"=>$bakery2, "supermarket"=>$supermarket2,
                      "car repair"=>$car_repair2, "park"=>$park2, "tourist attraction"=>$tourist_attraction2, "gym"=>$gym2,
                      "health"=>$health2, "car wash"=>$car_wash2, "liquor store"=>$liquor_store2, "shopping mall"=>$shopping_mall2,
                      "furniture store"=>$furniture_store2, "home goods store"=>$home_goods_store2, "lodging"=>$lodging2, "laundry"=>$laundry2,
                      "hardware store"=>$hardware_store2, "electronics store"=>$electronics_store2, "hair care"=>$hair_care2,
                      "drugstore"=>$drugstore2, "bank"=>$bank2, "atm"=>$atm2, "finance"=>$finance2, "doctor"=>$doctor2, "casino"=>$casino2,
                      "car dealer"=>$car_dealer2, "bar"=>$bar2, "town square"=>$town_square2, "accounting"=>$accounting2, "pharmacy"=>$pharmacy2);
                      arsort($categories2);

                $arrayLabel5 = array();
                $arrayValue5 = array();
                foreach($categories2 as $label => $value) {
                array_push($arrayLabel5,"$label");
                array_push($arrayValue5,"$value");
                }

                $arrayLabel5 = json_encode($arrayLabel5);
                $arrayValue5 = json_encode($arrayValue5);
                //echo "<h2>" . $arrayValue5 . "</h2>";
            echo "<div class='chart-container'><canvas id='visitspercategoryinstancesChart'></canvas></div>";

      $summon = 0;
      $sumtue = 0;
      $sumwen = 0;
      $sumthu = 0;
      $sumfri = 0;
      $sumsat = 0;
      $sumsun = 0;
      if (isset($_POST["submit"])) {

      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      // Load the range
      $month = $_POST["month"];
      $filter = $_POST["filter"];
      //echo "<h2>" . $month . "</h2>";
      //echo "<h2>" . $filter . "</h2>";

      if($filter == "visits per day") {
      //visits per day of a month query
      //count the visits of monday
      $monday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Monday';");
      // Bind the parameters and execute the query
      $monday->bind_param('s', $month);
      $monday->execute();
      $monday->store_result();
      $monday->bind_result($monday_visits);
      $monday->fetch();
      $monday->close();

      //count the visits of tuesday
      $tuesday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Tuesday';");
      // Bind the parameters and execute the query
      $tuesday->bind_param('s', $month);
      $tuesday->execute();
      $tuesday->store_result();
      $tuesday->bind_result($tuesday_visits);
      $tuesday->fetch();
      $tuesday->close();

      //count the visits of wednesday
      $wednesday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Wednesday';");
      // Bind the parameters and execute the query
      $wednesday->bind_param('s', $month);
      $wednesday->execute();
      $wednesday->store_result();
      $wednesday->bind_result($wednesday_visits);
      $wednesday->fetch();
      $wednesday->close();

      //count the visits of thursday
      $thursday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Thursday';");
      // Bind the parameters and execute the query
      $thursday->bind_param('s', $month);
      $thursday->execute();
      $thursday->store_result();
      $thursday->bind_result($thursday_visits);
      $thursday->fetch();
      $thursday->close();

      //count the visits of friday
      $friday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Friday';");
      // Bind the parameters and execute the query
      $friday->bind_param('s', $month);
      $friday->execute();
      $friday->store_result();
      $friday->bind_result($friday_visits);
      $friday->fetch();
      $friday->close();

      //count the visits of saturday
      $saturday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Saturday';");
      // Bind the parameters and execute the query
      $saturday->bind_param('s', $month);
      $saturday->execute();
      $saturday->store_result();
      $saturday->bind_result($saturday_visits);
      $saturday->fetch();
      $saturday->close();

      //count the visits of sunday
      $sunday = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Sunday';");
      // Bind the parameters and execute the query
      $sunday->bind_param('s', $month);
      $sunday->execute();
      $sunday->store_result();
      $sunday->bind_result($sunday_visits);
      $sunday->fetch();
      $sunday->close();

      $days = array("monday"=>$monday_visits, "tuesday"=>$tuesday_visits, "wednesday"=>$wednesday_visits,
       "thursday"=>$thursday_visits, "friday"=>$friday_visits, "saturday"=>$saturday_visits, "sunday"=>$sunday_visits);

       $arrayLabel2 = array();
       $arrayValue2 = array();
       foreach($days as $label => $value) {
       array_push($arrayLabel2,"$label");
       array_push($arrayValue2,"$value");
                 }

       $arrayLabel2 = json_encode($arrayLabel2);
       $arrayValue2 = json_encode($arrayValue2);

      echo "<div class='chart-container'><canvas id='visitsperdayofmonthChart'></canvas></div>";
    }
    else {
    //visits of instances per day of a month query
    // Create select query
    $query4 = "SELECT userid,date FROM userhistory";
    $result4 = $con->query($query4);

    if ($result4->num_rows > 0) {
      // output data of each row
      while($row4 = $result4->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        //echo "<h2>" . $row4["userid"] . "</h2>";
        $monday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Monday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $monday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $monday2->execute();
        $monday2->store_result();
        $monday2->bind_result($monday_visits2);
        $monday2->fetch();
        $monday2->close();
        $summon = $summon + $monday_visits2;
              //echo "<h2>" . $sumsat . "</h2>";
              //echo "<h2>" . $row["date"] . "</h2>";

        $tuesday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Tuesday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $tuesday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $tuesday2->execute();
        $tuesday2->store_result();
        $tuesday2->bind_result($tuesday_visits2);
        $tuesday2->fetch();
        $tuesday2->close();
        $sumtue = $sumtue + $tuesday_visits2;

        $wednesday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Wednesday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $wednesday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $wednesday2->execute();
        $wednesday2->store_result();
        $wednesday2->bind_result($wednesday_visits2);
        $wednesday2->fetch();
        $wednesday2->close();
        $sumwen = $sumwen + $wednesday_visits2;

        $thursday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Thursday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $thursday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $thursday2->execute();
        $thursday2->store_result();
        $thursday2->bind_result($thursday_visits2);
        $thursday2->fetch();
        $thursday2->close();
        $sumthu = $sumthu + $thursday_visits2;

        $friday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Friday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $friday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $friday2->execute();
        $friday2->store_result();
        $friday2->bind_result($friday_visits2);
        $friday2->fetch();
        $friday2->close();
        $sumfri = $sumfri + $friday_visits2;

        $saturday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Saturday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $saturday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $saturday2->execute();
        $saturday2->store_result();
        $saturday2->bind_result($saturday_visits2);
        $saturday2->fetch();
        $saturday2->close();
        $sumsat = $sumsat + $saturday_visits2;
             // echo "<h2>" . $saturday_visits2 . "</h2>";
               // echo "<h2>" . $sumsat . "</h2>";
        $sunday2 = $con->prepare("SELECT COUNT(*) FROM visit_declaration WHERE MONTH(timestamp) = ? AND DAYNAME(timestamp) = 'Sunday' AND userid = ? AND DATE(timestamp) BETWEEN DATE_SUB(?, INTERVAL 7 DAY) AND ADDDATE(?, INTERVAL 14 DAY)");
        // Bind the parameters and execute the query
        $sunday2->bind_param('ssss', $month, $row4["userid"], $row4["date"], $row4["date"]);
        $sunday2->execute();
        $sunday2->store_result();
        $sunday2->bind_result($sunday_visits2);
        $sunday2->fetch();
        $sunday2->close();
        $sumsun = $sumsun + $sunday_visits2;
      }
      }

      $days2 = array("monday"=>$summon, "tuesday"=>$sumtue, "wednesday"=>$sumwen,
       "thursday"=>$sumthu, "friday"=>$sumfri, "saturday"=>$sumsat, "sunday"=>$sumsun);

       $arrayLabel3 = array();
       $arrayValue3 = array();
       foreach($days2 as $label => $value) {
       array_push($arrayLabel3,"$label");
       array_push($arrayValue3,"$value");
                 }

       $arrayLabel3 = json_encode($arrayLabel3);
       $arrayValue3 = json_encode($arrayValue3);
        //echo "<h2>" . $arrayValue3 . "</h2>";
       echo "<div class='chart-container'><canvas id='visitsperdayofmonthinstancesChart'></canvas></div>";
 }
  }

    ?>
<script>

				var ctx = document.getElementById('visitsperdayofmonthChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php echo $arrayLabel2; ?>,
						datasets: [{
							label: 'Visits per day'  ,
							data: <?php echo $arrayValue2; ?>,
							backgroundColor: ['rgba(25, 255, 71, 0.5)','rgba(52, 75, 239, 0.5)', 'rgba(255, 77, 0, 0.2)',
							 'rgba(0, 0, 0, 0.2)', 'rgba(0, 255, 185, 1)', 'rgba(255, 255, 0, 1)', 'rgba(255, 163, 255, 1)'],
						}]
					},
					options: {
						maintainAspectRatio: false,
						scales: {
							yAxes: [{
								gridLines: { display: false },
								ticks: { display: false, beginAtZero: true }
							}],
							xAxes: [{ gridLines: { display: false } }]
						}
					}
				});
</script>
<script>

				var ctx = document.getElementById('visitsperdayofmonthinstancesChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php echo $arrayLabel3; ?>,
						datasets: [{
							label: 'Visits per day'  ,
							data: <?php echo $arrayValue3; ?>,
							backgroundColor: ['rgba(25, 255, 71, 0.5)','rgba(52, 75, 239, 0.5)', 'rgba(255, 77, 0, 0.2)',
							 'rgba(0, 0, 0, 0.2)', 'rgba(0, 255, 185, 1)', 'rgba(255, 255, 0, 1)', 'rgba(255, 163, 255, 1)'],
						}]
					},
					options: {
						maintainAspectRatio: false,
						scales: {
							yAxes: [{
								gridLines: { display: false },
								ticks: { display: false, beginAtZero: true }
							}],
							xAxes: [{ gridLines: { display: false } }]
						}
					}
				});
</script>
<script>
				var ctx = document.getElementById('visitspercategoryChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php echo $arrayLabel; ?>,
						datasets: [{
							label: 'Categories of POIs with the most visits',
							data: <?php echo $arrayValue; ?>,
							backgroundColor: ['rgba(214, 175, 54, 0.8)','rgba(167, 167, 173, 0.8)', 'rgba(255, 127, 71, 0.5)'],
						}]
					},
					options: {
						maintainAspectRatio: false,
						scales: {
							yAxes: [{
								gridLines: { display: false },
								ticks: { display: false, beginAtZero: true }
							}],
							xAxes: [{ gridLines: { display: false } }]
						}
					}
				});
			</script>
<script>
                var ctx = document.getElementById('visitspercategoryinstancesChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php echo $arrayLabel5; ?>,
						datasets: [{
							label: 'Categories of POIs with the most visits by instances',
							data: <?php echo $arrayValue5; ?>,
							backgroundColor: ['rgba(214, 175, 54, 0.8)','rgba(167, 167, 173, 0.8)', 'rgba(255, 127, 71, 0.5)'],
						}]
					},
					options: {
						maintainAspectRatio: false,
						scales: {
							yAxes: [{
								gridLines: { display: false },
								ticks: { display: false, beginAtZero: true }
							}],
							xAxes: [{ gridLines: { display: false } }]
						}
					}
				});
			</script>

</div>
</body>
</html>
