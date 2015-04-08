<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include("../connection.php");
    include("../security.php");

    if (!isset($_POST['module']))
    {
        die();
    }
    
    switch ($_POST['module'])
    {
        case 'selectProperty':
            selectObject();
            break;
        
        case 'searchProperty':
            searchText();
            break;
            
    }
   
  
    
    
    
    
    Function selectObject()
    {
            global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
            $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
            
            if (mysqli_connect_error())
            {
                echo "Connection Error";
                die();
            }
            
            switch ($_POST['module'])
            {
                case 'selectProperty':

                    $sql='SELECT Property_Number,Property_inventoryTag,Property_Description,Property_Model,Acquisition_Date,Acquisition_Cost,Brand_Name FROM Property JOIN M_Brand on Property.fkBrand_Id = M_Brand.Brand_Id';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                    <tr><th>Prop Tag</th><th>Description</th><th>Brand</th><th>Model</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedClassification(\"".$row['Property_inventoryTag']."\",\"".$row['Property_Description']."\");'>
                            <td>".$row['Property_inventoryTag']."</td>
                            <td>".$row['Property_Description']."</td>
                            <td>".$row['Brand_Name']."</td>
                            <td>".$row['Property_Model']."</td>
                        </tr>";
                    }
                    echo ' </table> ';
                    break;
            }
            
                               
                   
        mysqli_close($conn);
    }
    Function searchText()
    {
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
        
         switch ($_POST['module'])
            {
                case 'searchProperty':
                    $sql='SELECT Property_Number,Property_inventoryTag,Property_Description,Property_Model,Acquisition_Date,Acquisition_Cost,Brand_Name
                        FROM Property JOIN M_Brand on Property.fkBrand_Id = M_Brand.Brand_Id WHERE Property_inventoryTag LIKE "%'.$_POST['search_string'].'%" OR
                        Property_Description LIKE "%'.$_POST['search_string'].'%" OR Property_Model LIKE "%'.$_POST['search_string'].'%" OR 
                        Brand_Name LIKE "%'.$_POST['search_string'].'%" ORDER BY Property_Number ASC';
                    
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                        <tr><th>Property Tag</th><th>Description</th><th>Brand</th><th>Model</th><th>Acq Date</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedBrand(\"".$row['Property_Number']."\",\"".$row['Property_inventoryTag']."\");'>
                            <td>".$row['Property_inventoryTag']."</td>
                            <td>".$row['Property_inventoryTag']."</td>   
                            <td>".$row['Brand_Name']."</td>
                            <td>".$row['Property_Model']."</td>
                            <td>".$row['Acquisition_Date']."</td>
                        </tr>";
                    }
                    echo '</table>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
                    break;
                    
                    
                    
            }
            
        mysqli_close($conn);
    }