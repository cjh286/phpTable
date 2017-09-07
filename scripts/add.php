<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type ="text/css" href= "https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/style.css">
        <title>p2</title>
    </head>
    
    <body>
        <h1>Submit Your Own Ramen:</h1>
        
        <p id='navi'>
            <a href="https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/index.php">Back to Catalogue</a>
        </p>
        
        <form method="post">
            <table class="add" border="1">
                <tr>
                    <td>Name: <input type="text" name="name" placeholder="Name of Ramen"></td>
                    <td>Brand: <input type="text" name="brand" placeholder="Brand"></td>
                    <td>Base: <br><input type="radio" name="package" value="Soup"> Soup
                        <input type="radio" name="package" value="Sauce"> Sauce</td>
                    <td>Hotness:
                    <select name="hotness">
                        <option value="None">Not spicy</option>
                        <option value="Mild">Mild</option>
                        <option value="Medium">Medium</option>
                        <option value="Hot">Hot</option>
                        <option value="Very">Very Spicy</option>
                    </select></td>
                    <td>Details:
                        <textarea rows="4" cols="20" name="details" placeholder="More Details Here"></textarea>
                    </td>
                    <td>Image Link 1:<input type="url" name="image" placeholder="Optional Image Url"><br>
                        Image Link 2:<input type="url" name="image2" placeholder="Optional Image Url">
                    </td>
                    <td><input type="submit" value="Submit"/></td>
                </tr>
            </table>
        </form>
        
        <?php
        
            if(!empty($_POST["name"])&&(preg_match("/[a-zA-Z ]/", $_POST["name"]))){
                $name=$_POST["name"];
            } else{
                echo "<p>Valid name: contains only letters and numbers</p><br>";
            }
        
            if(!empty($_POST["brand"])&&(preg_match("/[a-zA-Z ]/", $_POST["name"]))){
                $brand=$_POST["brand"];
            } else {
                echo "<p>Valid brand: contains only letters and numbers</p><br>";
            }
        
            if(isset($_POST["package"])){
                $package=$_POST["package"];
            } else {
                echo "<p>Soup type: soup or sauce (anything with no soup)</p><br>";
            }
        
            if(isset($_POST["hotness"])){
                $hotness=$_POST["hotness"];
            } else{
                echo "<p>Hotness leve: your opinion</p><br>";
            }
        
            if(!empty($_POST["details"])&&preg_match("/[a-zA-Z0-9.,;:!?()'\"%$\/ ]/", $_POST["details"])){
                $details=$_POST["details"];
            } else{
                echo "<p>Details: anything from country of origin to recommended recipes to calorie content. No symbols.</p><br>";
            }
        
            if(!empty($_POST["image"])){
                $image=$_POST["image"];
            } elseif (isset($_POST["image"]) && $_POST["image"]==""){
                $image='https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/img/notfound.jpg';
            } else{
                echo "";
            }
        
            if (!empty($_POST["image2"])){
                $image2=$_POST["image2"];
            } elseif (isset($_POST["image2"]) && $_POST["image2"]==""){
                $image2='https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/img/notfound.jpg';
            } else {
                echo "";
            }
            
            $added = "";
            if (isset($name) && isset($brand) && isset($package) && isset($hotness) && isset($details)){
                $myfile = fopen('data.txt', 'r') or die ("Unable to open file!");
                $added = "set";
                 while(!feof($myfile)){
                    $line = fgets($myfile);
                    $content = explode(";~;", $line);
                     if (($name==$content[0])&&($brand==$content[1])){
                        $added = "not";
                     } else {
                        $added = $added;
                     }
                 }
                fclose($myfile);
            }
        
            if ($added == "set"){
                $addtofile = fopen('data.txt', 'a') or die ("Unable to open file!");
                $row=array("\n$name;~;", "$brand;~;", "$package;~;", "$hotness;~;", "$details;~;", "$image;~;", "$image2;~;");
                file_put_contents('data.txt', $row, FILE_APPEND);
                echo "<p>$name has been added!!</p>";
                echo "<p><a href='https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/add.php'>Add another</a></p>";
                fclose($addtofile);
            } else if ($added == "not"){
                echo "<p>Sorry, $name already exists</p>";
            }
                
            
        ?>

    </body>
</html>