<?php  
 if(!empty($_FILES["qn_file"]["name"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "root", "qpgs");  
      $output = ''; 
      $allowed_ext = array("csv");  
      $extension = end(explode(".",$_FILES["qn_file"]["name"]));  
      if(in_array($extension, $allowed_ext))  
      {  
           $file_data = fopen($_FILES["qn_file"]["tmp_name"], 'r');
           fgetcsv($file_data);
           while($row = fgetcsv($file_data)) 
           {  
                $Qn_id = mysqli_real_escape_string($connect, $row[0]); 
                $Question = mysqli_real_escape_string($connect, $row[1]);  
                $difficulty = mysqli_real_escape_string($connect, $row[2]);  
                $course = mysqli_real_escape_string($connect, $row[3]);  
                $semester = mysqli_real_escape_string($connect, $row[4]); 
                $subject = mysqli_real_escape_string($connect, $row[5]);
                $modules = mysqli_real_escape_string($connect, $row[6]); 
                $query = "  
                INSERT INTO qndata  
                     (Question, difficulty, course, semester, subject, modules)  
                     VALUES ('$Question', '$difficulty', '$course', '$semester', '$subject' , '$modules')  
                ";  
                mysqli_query($connect, $query);  
           }  
           $select = "SELECT * FROM qndata ORDER BY Qn_id DESC";  
           $result = mysqli_query($connect, $select);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr>  
                          <th width="5%">Qn_id</th>  
                          <th width="25%">Question</th>  
                          <th width="35%">difficulty</th>  
                          <th width="10%">course</th>  
                          <th width="20%">semester</th>  
                          <th width="5%">subject</th>
                          <th width="5%">modules</th>  
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>'.$row["Qn_id"].'</td>  
                          <td>'.$row["Question"].'</td>  
                          <td>'.$row["difficulty"].'</td>  
                          <td>'.$row["course"].'</td>  
                          <td>'.$row["semester"].'</td>  
                          <td>'.$row["subject"].'</td>
                          <td>'.$row["modules"].'</td>    
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
           echo $output;  
      } 
      else  
      {  
           echo 'Error1';  
      }  
 }  
 else  
 {  
      echo "Error2";  
 }  
 ?>  
