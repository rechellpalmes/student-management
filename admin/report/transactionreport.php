<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
 
</style>
       
<div id="fullscreen_bg" class="fullscreen_bg"></div>
<form class="form-signin" action="" method="POST">
<div class="container">
    <div class="row">
        <div class="">
        
        <div class="panel panel-default">
        
        <div class="panel panel-primary">
        
            
            <div class="text-center">
                <h3 style="color:#2C3E50" >Financial Reports</h3>
                                      
                <h5><label for="Choose Report" style="color:#E74C3C"> Time :</label>
                             <input id="a" type="radio" name="transdate" value="Daily">Daily 
                             <input id="b" type="radio" name="transdate" value="Weekly">Weekly
                             <input id="c" type="radio" name="transdate" value="Monthly">Monthly</h5>
                                
                                <div class="customer" >
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input type="text" id="date_picker" name="daily" class="form-control" placeholder="Date" />
                                    </div>
                                </div>
                </br><button type="submit" name="submit" class="btn btn-primary btn-lg btn3d"><span class="glyphicon glyphicon-search"></span> View</button> 
            </div>                 
        <div class="panel-body">    
 
  <table class="table table-striped table-condensed">
                  <thead>
                  <tr> 
                      <th class="text-center" width="115px">Name</th>
                      <th class="text-center" width="115px">Money</th>
                      <th class="text-center" width="115px">Date</th>
                      <th class="text-center" width="115px">Details</th>
                  </tr>
              </thead>   
              <tbody> 
               
                <?php 
                    $total=0; 
                    if (isset($_POST['submit'])) {
                        // Check if transdate is set and not empty
                        if (isset($_POST['transdate']) && !empty($_POST['transdate'])) {
                            switch ($_POST['transdate']) {
                                case 'Daily':
                                    $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                            WHERE f.`EXPENSEID` = e.`EXPENSEID` 
                                            AND DATE(TRANSDATE) = '".date_format(date_create($_POST['daily']), "Y-m-d")."'";
                                    break;
                                case 'Weekly':
                                    $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                            WHERE f.`EXPENSEID` = e.`EXPENSEID` 
                                            AND WEEK(TRANSDATE) = WEEK(NOW())";
                                    break;
                                case 'Monthly':
                                    $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                            WHERE f.`EXPENSEID` = e.`EXPENSEID` 
                                            AND MONTH(TRANSDATE) = MONTH(NOW())";
                                    break;
                                default:
                                    $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                            WHERE f.`EXPENSEID` = e.`EXPENSEID`";
                                    break;
                            }
                        } else {
                            echo '<div class="text-center"><p style="color:red;">Please select a report type.</p></div>';
                            $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                    WHERE f.`EXPENSEID` = e.`EXPENSEID`";
                        }
                    } else {
                        $sql = "SELECT * FROM `tblfees` f, `tblexpenses` e 
                                WHERE f.`EXPENSEID` = e.`EXPENSEID`"; 
                    }
               
                    $mydb->setQuery($sql);
                    $cur = $mydb->loadResultList();

                    foreach ($cur as $result) {
                        echo '<tr>';
                        echo '<td class="text-center">'.$result->DESCRIPTION.'</td>';
                        echo '<td class="text-center">'.$result->PAYMENT.'</td>';
                        echo '<td class="text-center">'.date_format(date_create($result->TRANSDATE), "m/d/Y").'</td>';
                        echo '<td class="text-center">'.$result->REMARKS.'</td>';
                        echo '</tr>';

                        $total += $result->PAYMENT;
                    }
                ?>
                    
              </tbody>
              </table>
     <div class="text-center">
            <h4> <label style="color:#E74C3C" for="Total">Total :</label><?php echo $total;?></h4> 
     </div>

  </div>
       </div>
        </div>
    </div>
</div>
</form>
