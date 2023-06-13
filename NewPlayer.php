<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/newPlayer.css" />
    <title>New Player</title>
</head>
<body>
    <?php 
    require "PlayerFunctions.inc";
    $DisplayForm = TRUE;
    $fName = "";
    $lName = "";
    $email = "";
    $city = "";
    $country = "";
    $countries = array("", "Canada", "United-States", "Argentina", "Brazil", "Columbia", "Ecuador", "Peru", "Poland");
    $professional = "";
    $password = "";
    $passwordConfirmation = "";
    $errors = array();
    $errorMsgEmpty=array("fName" => "Please enter a first name", "lName" => "Please enter a last name", "email" => "Please enter an email address", "city" =>"Please enter a city", "country"=>"Please select a country", "password"=>"Please enter a password", "passwordConfirmation" =>"Please confirm your password");
    $regex = array("fName" => "/^[a-zA-Z]+((\h|\-|\'){1}[a-zA-Z]+)*$/", "lName"=> "/^[a-zA-Z]+((\h|\-|\'){1}[a-zA-Z]+)*$/", "email"=>"/^[a-zA-Z\d_\-.]+@[a-zA-Z\d]+\.(com|ca|org)$/", "city" => "/^[a-zA-Z]+((\h|\-){1}[a-zA-Z]+)*$/", "password"=>"/^[^\s]{8,}$/");
    $errorMsgValidate = array("fName"=> "First name can only contain letters with a dash, an apostrophe or a space between them", "lName" => "Last name can only contain letters with a dash, an apostrophe or a space between them", "city"=>"City can only contain letters, dash or space", "password" =>"Password cannot contain any spaces and must be at least 8 characters long", "passwordConfirmation" => "Passwords do not match, please try again", "email"=>"Please enter a valid email address e.g.: johndoe3@email.com");
    if(isset($_POST["theB"])){
        $DisplayForm = FALSE;
        $fName = $_POST["fName"];
        $lName = $_POST["lName"];
        $email = $_POST["email"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $professional = $_POST["professional"];
        $password = $_POST["password"];
        $passwordConfirmation = $_POST["passwordConfirmation"];

        foreach($_POST as $name => $p) {
            if(isFieldEmpty($p)){
                $errors["$name"] = TRUE;
                $errorEmpty["$name"] = TRUE;       
                $DisplayForm = TRUE;
            } else if($regex["$name"]) {
                if(!validateFields($p, $regex["$name"])) {
                    $DisplayForm = TRUE;
                    $errors["$name"] = TRUE;
                    $errorValidate["$name"] = TRUE;
                }
            }
        } 
        if(!confirmPassword($password, $passwordConfirmation)){
            $DisplayForm = TRUE;
            $errors["password"] = TRUE;
            $errors["passwordConfirmation"] = TRUE;
            $errorValidate["passwordConfirmation"] = TRUE;
        }
    }
    if($DisplayForm){
    ?>
    <div id="theImg"></div>
    
    <form id="myForm" name="myForm" method="POST" action="NewPlayer.php">
    <h1>Add New Player</h1>
        <p>
            <label for="fName">First name:</label>
            <input type="text" name="fName" id="fName" placeholder="John" class="<?php echo $errors["fName"] ? "error" : ""; ?>" value="<?php echo $fName ?>" />
            <span class="errorMsg"> <?php echo $errorEmpty["fName"] ? $errorMsgEmpty["fName"] : ($errorValidate["fName"]? $errorMsgValidate["fName"] : ""); ?></span>
        </p>
        <p>
            <label for="lName">Last name:</label>
            <input type="text" name="lName" id="lName" placeholder="Doe" class="<?php echo $errors["lName"] ? "error" : "";?>" value="<?php echo $lName ?>" />
            <span class="errorMsg"> <?php echo $errorEmpty["lName"] ? $errorMsgEmpty["lName"] : ($errorValidate["lName"]? $errorMsgValidate["lName"] : ""); ?></span>
        </p>
        <p>
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email" placeholder="johndoe@hockeytown.ca" class="<?php echo $errors["email"] ? "error" : "";?>" value="<?php echo $email ?>" />
            <span class="errorMsg"> <?php echo $errorEmpty["email"] ? $errorMsgEmpty["email"] : ($errorValidate["email"]? $errorMsgValidate["email"] : ""); ?></span>
        </p>
        <p>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" class="<?php echo $errors["city"] ? "error" : "";?>" value="<?php echo $city ?>" />
            <span class="errorMsg"> <?php echo $errorEmpty["city"] ? $errorMsgEmpty["city"] : ($errorValidate["city"]? $errorMsgValidate["city"] : ""); ?></span>
        </p>
        <p>
            <label for="country">Country:</label>
            <select name="country" class="<?php echo $errors["country"] ? "error" : "";?>">
                <?php 
                    foreach($countries as $c){ 
                ?>
                <option value=
                    <?php 
                        echo "\"$c\""; 
                        echo $c === $country ? "selected" : "";
                    ?>>
                    <?php
                        echo $c; 
                    ?>
                </option>
                <?php   
                    }
                ?>
            </select>
            <span class="errorMsg"> <?php echo $errorEmpty["country"] ? $errorMsgEmpty["country"] : ($errorValidate["country"]? $errorMsgValidate["country"] : ""); ?></span>
        </p>
        <p id="checkboxPara">
            <label for="professional">Professional:</label>
            <input type="checkbox" name="professional" id="professional" <?php echo $professional? "checked":""?> />
           
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="<?php echo $errors["password"] ? "error" : "";?>" value="<?php echo $password ?>" />
            <span class="errorMsg"><?php echo $errorEmpty["password"] ? $errorMsgEmpty["password"] : ($errorValidate["password"]? $errorMsgValidate["password"] : ""); ?></span>
        </p>
        <p>
            <label for="passwordConfirmation">Password Confirmation:</label>
            <input type="password" name="passwordConfirmation" id="passwordConfirmation" class="<?php echo $errors["passwordConfirmation"] ? "error" : "";?>" value="<?php echo $passwordConfirmation ?>" />
            <span class="errorMsg"> <?php echo $errorEmpty["passwordConfirmation"] ? $errorMsgEmpty["passwordConfirmation"] : ($errorValidate["passwordConfirmation"]? $errorMsgValidate["passwordConfirmation"] : ""); ?></span>
        </p>
        <p id="theButtonP">
            <input type="submit" name="theB" id="theB" value="Add Player" />
        </p>

    </form>

    <?php 
    }
else{
    $info = "$lName~$fName~$email~$city~$country~" . ($professional ? "yes" : "no") . "\r\n";
    savePlayerInfo($info);
     ?>
     <div id="pa-container">
     <p id="pa">Player added!</p>
     <a href="NewPlayer.php">Add another player</a>
     </div>
<?php
}
    ?>
</body>
</html>