<?php

/**
* Modal Untuk Hasil Kesimpulan Peritungan Apriori
* 
*/
function modalKesimpulan()
{
    ?>
    <form method="POST" action="">
        <div class="modal fade" id="kesimpulan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="imgcontainer">
                            <h4>DAFTAR HASIL ANALISA</h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <?php 
                        include_once "metode/database.php";
                        include_once "metode/kumpulan_function.php";
                        include_once "metode/mining.php";

                        $db_object = new database();
                        $sql = "SELECT * FROM process_log ";
                        $query=$db_object->db_query($sql);
                        $jumlah=$db_object->db_num_rows($query);

                        if($jumlah==0){
                            echo "Data kosong...";
                        }
                        else{
                            ?>
                            <table class='table table-bordered table-striped  table-hover'>
                                <tr>
                                    <th>No</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Min Support</th>
                                    <th>Min Confidence</th>
                                    <th>Lihat Analisa</th>
                                </tr>
                                <?php
                                $no=1;
                                while($row=$db_object->db_fetch_array($query)){
                                    echo "<tr>";
                                    echo " <input type='hidden' id='no' value=".$row['end_date'].">";
                                    echo "<td>".$no."</td>";
                                    echo "<td>".format_date2($row['start_date'])."</td>";
                                    echo "<td>".format_date2($row['end_date'])."</td>";
                                    echo "<td>".$row['min_support']."</td>";
                                    echo "<td>".$row['min_confidence']."</td>";
                                    // $view = "<a href='coba.php?&id_process=".$row['id']."'>View rule</a>";
                                    $view2 = "<a href='index.php?akses=manajer&kl=m2&id_process=".$row['id']."&awal=".$row['start_date']."&akhir=".$row['end_date']."&minSupport=".$row['min_support']."&minConfidence=".$row['min_confidence']."' class='btn btn-primary'><i class='icon fa fa-book'></i> Lihat Hasil</a>";
                                    echo "<td>".$view2."</td>";
                                    echo "</tr>";
                                    $no++; 

                                }
                                ?>

                            </table> 
                            <br>
                            <div id="hasilAnalisa">

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="modal-footer">      
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}


/**
 * alert popup javascript
 * @param string $msg pesan
 */
function phpAlert($msg){
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

/**
 * notifikasi error (merah)
 * @param string $msg pesan
 */
function display_error($msg){
    echo "<div class='alert alert-danger alert-dismissable'>

    <h4><i class='icon fa fa-ban'></i> Error! </h4>
    ".$msg."
    </div>";
}

/**
 * notifikasi warning (kuning)
 * @param string $msg pesan
 */
function display_warning($msg){
    echo "<div class='alert alert-warning alert-dismissable'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <h4><i class='icon fa fa-warning'></i> Warning! </h4>
    ".$msg."
    </div>";
}

/**
 * notifikasi informasi (biru)
 * @param string $msg pesan
 */
function display_information($msg){
    echo "<div class='alert alert-info alert-dismissable'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <h4><i class='icon fa fa-info'></i> Information </h4>
    ".$msg."
    </div>";
}

/**
 * notifikasi sukses (hijau)
 * @param string $msg pesan
 */
function display_success($msg){
    echo "<div class='alert alert-success alert-dismissable'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <h4><i class='icon fa fa-check'></i> Success. </h4>
    ".$msg."
    </div>";
}

/**
 * enter br with looping
 * @param int $a default=1
 */
function br($a=1){
	if($a>=1){
		$aa=0;
		while($aa<=$a){
			echo "<br>";
			$aa++;
		}
	}
}

/**
 * spasi &nbsp; with looping
 * @param int $a default=1
 */
function space($a=1){
	if($a>=1){
		$aa=0;
		while($aa<=$a){
			echo "&nbsp;";
			$aa++;
		}
	}
}

/**
 * start div
 * @param string $params default=''
 */
function start_div($params=''){
	echo "<div $params>";
}

/**
 * end div
 */
function end_div(){
	echo "</div>";
}

/**
 * start form
 * @param string $params default=''
 */
function start_form($params=''){
	echo "<form action='' method='post' $params>";
}

/**
 * end form
 */
function end_form(){
	echo "</form>";
}

/**
 * table start
 * @param string $params default=''
 */
function start_table($params=''){
	echo "<table $params>";
}

/**
 * end table
 */
function end_table(){
	echo "</table>";
}

/**
 * echo tr $params;
 * @param string $params default=''
 */
function start_row($params=''){
	echo "<tr $params>";
}

/**
 * echo /tr
 */
function end_row(){
	echo "</tr>";
}

/**
 * echo td $params;
 * @param string $params default=''
 */
function start_column($params=''){
	echo "<td $params>";
}

/**
 * echo /td
 */
function end_column(){
	echo "</td>";
}


/**
 * label text
 * @param string $label default=''
 * @param type $params parameter tambahan default=''
 */
function label($label='', $params=''){
	echo "<label for='name' $params >".$label;//.<!-- <span class="red">(required)</span> --></label>"
	echo "</label>";
}

/**
 * input text area
 * @param string $name
 * @param string $value
 * @param boolean $required
 * @param string $params default=''
 * @param boolean $texteditor text area dengan tinymce default=false
 */
function input_text_area($name,$value, $required=false, $params='', $texteditor=false){
    $tinymce = "mceNoEditor";
    if($texteditor){
        $tinymce = "mceEditor";
    }
    if(!$required){
        echo "<textarea name='$name' rows='10' cols='80' $params>".$value."</textarea>";
    }
    else{
        echo "<textarea name='$name' required='required' class='form-control $tinymce' $params>".$value."</textarea>";
    }
}

/**
 * input text area with label
 * @param type $label
 * @param type $name
 * @param type $value
 * @param type $required
 * @param type $params
 * @param boolean $texteditor textarea dengan tinymce default=false
 */

function input_free_text($name,$value, $required=true, $params=''){
	
	if(!$required){
		echo "<input type='text'  name='$name' 
       value='$value' class='form-control' $params/>";
   }
   else{
      echo "<input type='text' name='$name' 
      value='$value' required='required' class='form-control' $params/>";
  }
}

/**
 * input tipe file
 * @param type $name
 * @param type $required
 * @param type $params
 */
function input_file($name, $required=false, $params=''){
    if(!$required){
        echo "<input type='file' name='$name' $params>";
    }
    else{
        echo "<input type='file' name='$name' required='required' $params>";
    }
}

/**
 * input type amount (harga)
 * @param type $name
 * @param type $value
 * @param type $required
 * @param type $params
 */
function input_amount_text($name,$value, $required=true, $params=''){
	
    $value = price_format($value);
    if(!$required){
      echo "<input type='text'  name='$name' 
      value='$value' onkeyup=\"convertToPrice(this);\" class='form-control' $params/>";
  }
  else{
      echo "<input type='text' name='$name' 
      value='$value' onkeyup=\"convertToPrice(this);\" required='required' class='form-control' $params/>";
  }
}

/**
 * input type hidden
 * @param type $name
 * @param type $value
 * @param type $params default = ''
 */
function input_hidden($name, $value, $params=''){
	echo "<input type='hidden' id='$name' name='$name' value='$value' $params/>";
}

/**
 * input type date
 * @param type $name
 * @param type $value
 * @param type $tittle
 * @param type $id
 */
function input_date($name, $value, $tittle='', $id='date-picker'){
	echo "<input type='text' id='$id'  name='$name' size='10' maxlength='10' 
   value='$value' tittle ='$tittle' />";	
}

/**
 * submit button with reset button
 * @param type $name
 * @param type $value
 */
function submit_form_button($name, $value){
	echo "<input type='submit' name='$name' value='$value' >";
	echo "<input type='reset' value='Reset'>";
}

/**
 * submit button 
 * @param type $name
 * @param type $value
 * @param type $params default=''
 */
function submit_button($name, $value, $params=''){
	echo "<button name='$name' value='$value' $params >$value</button>";
	// echo "<input type='submit' name='$name' value='$value' >";
}

/**
 * link dengan popup new window open
 * @param type $label
 * @param type $link
 */
function link_new_window($label, $link){
	echo  "<a href='$link' target='_blank' onclick=\"window.open(this.href); return false;\" 
  onkeypress=\"window.open(this.href); return false;\">$label</a>";
}

/**
 * tulisan untuk link ke suatu halaman
 * @param type $link
 * @param type $label
 * @param type $params
 */
function link_text($link, $label, $params='')
{
	echo "<a href='$link' $params />$label</a>";
}

/**
 * format number 2 dibelakang koma (number_format($value,2)
 * @param type $value
 * @return type
 */
function price_format($value){
	return number_format($value,2, ',', '.');
}

/**
 * cetak link
 */
function print_cetak(){
    echo "<a href=\"javascript:window.print()\">Cetak</a>";
}

function format_date($date){
    $date_ex = explode("/", $date);
    return $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];
}

function format_date2($date){
    $date_ex = explode("-", $date);
    return $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
}

function format_date_db($date){
    $date_ex = explode("-", $date);
    return $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];
}

?>