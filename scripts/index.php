<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type ="text/css" href= "https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/style.css"> 
        <title>Ramen</title>
        
    </head>
    
    <body>
        <h1>Ramen Catalogue:</h1>
        
        <p id='navi'>
            <a href='https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/add.php'>Add Your Own</a>
            <a href='https://info2300.coecis.cornell.edu/users/cjh286sp17/www/p2/scripts/index.php'>Refresh</a>
        </p>
        
        
        <!-- Search -->
        <form id="search" method="post">
            Name: <input type="text" name="name" placeholder="Name of Ramen">
            Brand: <input type="text" name="brand" placeholder="Brand">
            Hotness: 
            <select name="hotness">
                <option value="n/a">N/A</option>
                <option value="None">Not spicy</option>
                <option value="Mild">Mild</option>
                <option value="Medium">Medium</option>
                <option value="Hot">Hot</option>
                <option value="Very">Very Spicy</option>
            </select>
            <input type="submit" value="Search">
        </form> <br>
        
        <?php 
            if (isset($_POST["name"])){
                $name = $_POST["name"];
            } else {
                $name = NULL;
            }
        
            if (isset($_POST["brand"])){
                $brand = $_POST["brand"];
            } else {
                $brand = NULL;
            }
        
            if (isset($_POST['hotness']) && ($_POST['hotness'] != 'n/a')){
                $hotness = $_POST['hotness'];
            } else{
                $hotness = NULL;
            }
        ?>
        
        
        <!-- Catalogue Display -->
        <?php if(($name==NULL)&&($brand==NULL)&&($hotness==NULL)){?>
            <table>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Base</th>
                    <th>Hotness</th>
                    <th>Details</th>
                </tr>
            <?php $file_nosearch = fopen('data.txt', 'r');
                                                                   
                while(!feof($file_nosearch)){
                    
                    $line = fgets($file_nosearch);
                    $content = explode(";~;", $line);?>
                
                <tr>
                    <td><img class='indeximage' alt='img1' src='<?php echo "$content[5]" ?>' width="100" onmouseover="this.src='<?php echo "$content[6]" ?>';" onmouseout="this.src='<?php echo "$content[5]" ?>';"></td>
                    <td><?php echo "$content[0]"; ?></td>
                    <td><?php echo "$content[1]"; ?></td>
                    <td><?php echo "$content[2]"; ?></td>
                    <td><?php echo "$content[3]"; ?></td>
                    <td class="detailstable"><?php echo "$content[4]"; ?></td>
                </tr>
             
                <?php } ?>
            </table>
            
            <p>hover over images</p>
        
            <?php fclose($file_nosearch); ?>

        <!--Table Displaying Search Results -->
        <?php } else{
    
            $search_results = array();
            $file_search = fopen('data.txt', 'r');
    
            while(!feof($file_search)){
                
                $line = fgets($file_search);
                $content = explode(";~;", $line);
                
                if(($name!=NULL)&&($brand!=NULL)&&($hotness!=NULL)){
                    if((preg_match("/$name/", $content[0]))&&(preg_match("/$brand/", $content[1]))&&($hotness==$content[3])){
                        array_push($search_results,$content);
                    }
                } else if(($name!=NULL)&&($brand!=NULL)&&($hotness==NULL)){
                    if((preg_match("/$name/", $content[0]))&&(preg_match("/$brand/", $content[1]))){
                        array_push($search_results,$content);
                    }
                } else if(($name!=NULL)&&($brand==NULL)&&($hotness!=NULL)){
                    if((preg_match("/$name/", $content[0]))&&($hotness==$content[3])){
                        array_push($search_results,$content);
                    }
                } else if(($name==NULL)&&($brand!=NULL)&&($hotness!=NULL)){
                    if((preg_match("/$brand/", $content[1]))&&($hotness==$content[3])){
                        array_push($search_results,$content);
                    }
                } else if(($name!=NULL)&&($brand==NULL)&&($hotness==NULL)){
                    if(preg_match("/$name/", $content[0])){
                        array_push($search_results,$content);
                    }
                } else if(($name==NULL)&&($brand!=NULL)&&($hotness==NULL)){
                    if (preg_match("/$brand/", $content[1])){
                        array_push($search_results,$content);
                    }
                } else if(($name==NULL)&&($brand==NULL)&&($hotness!=NULL)){
                    if($hotness==$content[3]){
                        array_push($search_results,$content);
                    }
                }
                    
            }
            
    
            if (count($search_results)!=0){?>
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Base</th>
                        <th>Hotness</th>
                        <th>Details</th>
                    </tr>
                <?php foreach ($search_results as $value){ ?>
                    <tr>
                        <td><img class='indeximage' alt='img2' src='<?php echo "$value[5]" ?>' width="100" onmouseover="this.src='<?php echo "$value[6]" ?>';" onmouseout="this.src='<?php echo "$value[5]" ?>';"></td>
                        <td><?php echo "$value[0]"; ?></td>
                        <td><?php echo "$value[1]"; ?></td>
                        <td><?php echo "$value[2]"; ?></td>
                        <td><?php echo "$value[3]"; ?></td>
                        <td class="detailstable"><?php echo "$value[4]"; ?></td>
                    </tr>
                <?php } ?>
                </table>
        
                <p>hover over images</p>
               
            <?php } else{
                echo "<p>no results found</p>";?>
            <?php
            }
                fclose($file_search);
        } ?>
          
    </body>
</html>