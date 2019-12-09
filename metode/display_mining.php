<?php
function display_process_hasil_mining($db_object, $id_process) {
       
    $sql1 = "SELECT * FROM confidence "
                . " WHERE id_process = ".$id_process
                . " AND from_itemset=3 ";
    $query1 = $db_object->db_query($sql1);
    ?>
    Confidence dari itemset 3
    <table class='table table-bordered table-striped  table-hover'>
        <tr style="background-color: #131368;">
        <th style='color:white;'>No</th>
        <th style='color:white;'>X => Y</th>
        <th style='color:white;'>Support X U Y</th>
        <th style='color:white;'>Support X </th>
        <th style='color:white;'>Confidence</th>
        <th style='color:white;'>Keterangan</th>
        </tr>
        <?php
            $no=1;
            $data_confidence = array();
            while($row=$db_object->db_fetch_array($query1)){
                    echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['kombinasi1']." => ".$row['kombinasi2']."</td>";
                    echo "<td>".price_format($row['support_xUy'])."</td>";
                    echo "<td>".price_format($row['support_x'])."</td>";
                    echo "<td>".price_format($row['confidence'])."</td>";
                    $keterangan = ($row['confidence'] <= $row['min_confidence'])?"Tidak Lolos":"Lolos";
                    echo "<td>".$keterangan."</td>";
                echo "</tr>";
                $no++;
                if($row['lolos']==1){
                $data_confidence[] = $row;
                }
            }
            ?>
    </table>
    
    
    <?php
    $sql1 = "SELECT * FROM confidence "
                . " WHERE id_process = ".$id_process
                . " AND from_itemset=2 "
                ;//. " ORDER BY lolos DESC";
    $query1 = $db_object->db_query($sql1);
    ?>
    Confidence dari itemset 2
    <table class='table table-bordered table-striped  table-hover'>
        <tr style="background-color: #131368;">
        <th style='color:white;'>No</th>
        <th style='color:white;'>X => Y</th>
        <th style='color:white;'>Support X U Y</th>
        <th style='color:white;'>Support X </th>
        <th style='color:white;'>Confidence</th>
        <th style='color:white;'>Keterangan</th>
        </tr>
        <?php
            $no=1;
            //$data_confidence = array();
            while($row=$db_object->db_fetch_array($query1)){
                    echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['kombinasi1']." => ".$row['kombinasi2']."</td>";
                    echo "<td>".price_format($row['support_xUy'])."</td>";
                    echo "<td>".price_format($row['support_x'])."</td>";
                    echo "<td>".price_format($row['confidence'])."</td>";
                    $keterangan = ($row['confidence'] <= $row['min_confidence'])?"Tidak Lolos":"Lolos";
                    echo "<td>".$keterangan."</td>";
                echo "</tr>";
                $no++;
                if($row['lolos']==1){
                $data_confidence[] = $row;
                }
            }
            ?>
    </table>

    <strong>Rule Asosiasi yang terbentuk:</strong>
    <table class='table table-bordered table-striped  table-hover'>
        <tr style="background-color: #131368;">
            <th style='color:white;'>No</th>
            <th style='color:white;'>X => Y</th>
            <th style='color:white;'>Confidence</th>
            <th style='color:white;'>Nilai Uji lift</th>
            <th style='color:white;'>Korelasi rule</th>
        </tr>
        <?php
        
        $no = 1;
        foreach($data_confidence as $key => $val){
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $val['kombinasi1']." => ".$val['kombinasi2'] . "</td>";
            echo "<td>" . price_format($val['confidence']) . "</td>";
            echo "<td>" . price_format($val['nilai_uji_lift']) . "</td>";
            echo "<td>" . ($val['korelasi_rule']) . "</td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </table>
<?php }?>