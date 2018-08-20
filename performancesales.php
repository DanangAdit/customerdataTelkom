<?php

    function Loginissby(){
    $dbuser="issby";
    $dbpass="issby2017";
    $dbhost="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.96.2.233)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SID=dcspool)))";
    $conn=OCILogon($dbuser,$dbpass,$dbhost);
    return $conn;
}

$conn=Loginissby();
function OCIexec($sql){
    global $conn;
    $stmt=OCIparse($conn,$sql);
    OCIexecute($stmt);
    return $stmt;
}

    ?>
    <html>
        <link rel="shortcut icon" href="assets/img/logotelkom.png">
        <head>
            <title>Performance Sales</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
            <style type="text/css" media ="screen">
                <!--
                .style2 {font-family: Arial, Helvetica, sans-serif;
                         font-size: 14px;
                         color: #FFFFFF;
                }
                .style8 {color: #9AE73B}
                .style14 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
                .red { background-color: #ea2522; }

                -->
                html body .box1{ margin-top: 10px;  margin-left: 5px; margin-bottom: 40px;}
                html body .box2{ margin-top: 8%;  margin-right: 5px; margin-left: 5px;} 
                html body .bulan{ position: absolute; left: 30px; top: 25%; z-index: 3;}
                html body .tahun{ position: absolute; left: 280px; top: 25%; z-index: 3;}
                html body .cari {position: absolute; left: 530px; top: 25%; z-index: 3;}

            </style>
        </head>

        <body style="background-color: #e8e8e8">
            <img src="assets\img\telkom.png" alt="Image" style="width: 240px; height: 130px; margin-left: 15px; margin-top: 15px; z-index: 2;">
            <form name="A" method="post" action="performancesales.php">

                <?php

                if (isset($_POST['filter'])) {
                    $bulan = ($_POST['bulan']);
                    $tahun = ($_POST['tahun']);
                        $sql = "select order_date,last_update TGL_PS,substr(kcontact,24,7) KD_AVG,b.nama nama,order_id,jenis_psb,1 jml_ps, CASE when  to_char(order_date,'mm')='$bulan' and to_char(order_date,'yyyy')='$tahun' then '1' when  to_char(order_date,'mm')!=to_char(sysdate,'mm') then '0' end AS JML_PI from ISISKA.STARCLICK_PS a,issby.p_avenger b where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA') and to_char(last_update,'mm')='$bulan' and to_char(last_update,'yyyy')='$tahun' and substr(kcontact,24,7)=id order by KD_AVG";   
                 
//echo $sql1;
                    ?>  
                    <div class="box1">
                        <div class="bulan"><label>Bulan</label>
                        <select name="bulan">
                          <option><?php $sqlbulan = "select distinct to_char(order_date,'mm') as bulan from ISISKA.STARCLICK_PS where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA')"; 
                                $getbulan = OCIexec($sqlbulan);
                                while (OCIfetch($getbulan)) {
                                $bln = OCIresult($getbulan, 'BULAN');
                                echo '<option>'.$bln.'</option>';
                                }
                                ?></option>
                        </select>
                        </div>
                        <div class="tahun"><label>Tahun</label>
                        <select name="tahun">
                          <option><?php $sqltahun = "select distinct to_char(order_date,'yyyy') as tahun from ISISKA.STARCLICK_PS where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA')"; 
                                $gettahun = OCIexec($sqltahun);
                                while (OCIfetch($gettahun)) {
                                $thn = OCIresult($gettahun, 'TAHUN');
                                echo '<option>'.$thn.'</option>';
                                }
                                ?></option>
                        </select>
                        </div>
                                     
                        <div class="cari"><label>&nbsp;</label>
                            <input type="submit" name="filter" value="Filter" class="btn btn-danger"></div>
                    </div>
                    <div class="box2">
                        <hr>
                        <label style="margin-left: 150px;"><?php echo "Bulan ".$bulan . " Tahun " . $tahun; ?></label>
                        <table style="padding-right: 150px; padding-left: 150px;"  class="table table-bordered">
                            <tr bgcolor="#ea2522">
                                <td width="2%"><div align="center" class="style2">No</div></td>
                                <td width="10%"><div align="center" class="style2">Order Date</div></td>
                                <td width="10%"><div align="center" class="style2">Tanggal PS</div></td>
                                <td width="10%"><div align="center" class="style2">Kode Avenger</div></td>
                                <td width="20%"><div align="center" class="style2">Nama</div></td>
                                <td width="10%"><div align="center" class="style2">Order ID</div></td>
                                <td width="10%"><div align="center" class="style2">Jenis PSB</div></td>
                                <td width="5%"><div align="center" class="style2">Jml PS</div></td>
                                <td width="5%"><div align="center" class="style2">Jml PI</div></td>
                            </tr>
                            <?php
                            $get1 = OCIexec($sql);
                            $x = 0;
                            while (OCIfetch($get1)) {
                                $order_date = OCIresult($get1, 'ORDER_DATE');
                                $tgl_ps = OCIresult($get1, 'TGL_PS');
                                $kd_avg = OCIresult($get1, 'KD_AVG');
                                $nama = OCIresult($get1, 'NAMA');
                                $order_id = OCIresult($get1, 'ORDER_ID');
                                $jenis_psb = OCIresult($get1, 'JENIS_PSB');
                                $jml_ps = OCIresult($get1, 'JML_PS');
                                $jml_pi = OCIresult($get1, 'JML_PI');
                                

                                $x++;
                                if ($x % 2 == 0)
                                    $bg = "#f4f4f4";
                                else
                                    $bg = "#FFFFFF";
                                ?>

                                <tr bgcolor="<?= $bg ?>">
                                    <td><span class="style14"><?php echo $x; ?></span></td> <!--Nomor-->
                                    <td><span class="style14"><?php echo $order_date; ?></span></td> <!--ORDER DATE-->
                                    <td><span class="style14"><?php echo $tgl_ps; ?></span></td> <!--TGL_PS-->
                                    <td><span class="style14"><?php echo $kd_avg; ?></span></td> <!--KD_AVG-->
                                    <td><span class="style14"><?php echo $nama; ?></span></td> <!--NAMA-->
                                    <td><span class="style14"><?php echo $order_id; ?></span></td> <!--ORDER_ID-->
                                    <td><span class="style14"><?php echo $jenis_psb; ?></span></td> <!--JENIS_PSB-->
                                    <td><span class="style14"><?php echo $jml_ps; ?></span></td> <!--JML_PS-->
                                    <td><span class="style14"><?php echo $jml_pi; ?></span></td> <!--JML_PI-->                                   
                                </tr>
                        </div>
            <?php
        }


                } else {

                    $sql = "select order_date,last_update TGL_PS,substr(kcontact,24,7) KD_AVG,b.nama nama,order_id,jenis_psb,1 jml_ps, CASE when  to_char(order_date,'mm')=to_char(sysdate,'mm') then '1' when  to_char(order_date,'mm')!=to_char(sysdate,'mm') then '0' end AS JML_PI from ISISKA.STARCLICK_PS a,issby.p_avenger b where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA') and to_char(last_update,'mm')=to_char(sysdate,'mm') and substr(kcontact,24,7)=id order by KD_AVG";
                
//echo $sql1;
                    ?>
                      
                    <div class="box1">
                        <div class="bulan"><label>Bulan</label>
                        <select name="bulan">
                          <option><?php $sqlbulan = "select distinct to_char(order_date,'mm') as bulan from ISISKA.STARCLICK_PS where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA')"; 
                                $getbulan = OCIexec($sqlbulan);
                                while (OCIfetch($getbulan)) {
                                $bln = OCIresult($getbulan, 'BULAN');
                                echo '<option>'.$bln.'</option>';
                                }
                                ?></option>
                        </select>
                        </div>
                        <div class="tahun"><label>Tahun</label>
                        <select name="tahun">
                          <option><?php $sqltahun = "select distinct to_char(order_date,'yyyy') as tahun from ISISKA.STARCLICK_PS where kcontact like 'MI%' and (substr(kcontact,24,7) like 'CA%' or substr(kcontact,24,7) like 'SP%') and sto in (select mdf from isiska.p_mdf where witel='SURABAYA')"; 
                                $gettahun = OCIexec($sqltahun);
                                while (OCIfetch($gettahun)) {
                                $thn = OCIresult($gettahun, 'TAHUN');
                                echo '<option>'.$thn.'</option>';
                                }
                                ?></option>
                        </select>
                        </div>

                        <div class="cari"><label>&nbsp;</label>
                            <input type="submit" name="filter" value="Filter" class="btn btn-danger"></div>
                    </div>
                    <div class="box2">
                        <hr>
                        <table style="padding-right: 150px; padding-left: 150px;" class="table table-bordered">
                            <tr bgcolor="#ea2522">
                                <td width="2%"><div align="center" class="style2">No</div></td>
                                <td width="10%"><div align="center" class="style2">Order Date</div></td>
                                <td width="10%"><div align="center" class="style2">Tanggal PS</div></td>
                                <td width="10%"><div align="center" class="style2">Kode Avenger</div></td>
                                <td width="20%"><div align="center" class="style2">Nama</div></td>
                                <td width="10%"><div align="center" class="style2">Order ID</div></td>
                                <td width="10%"><div align="center" class="style2">Jenis PSB</div></td>
                                <td width="5%"><div align="center" class="style2">Jml PS</div></td>
                                <td width="5%"><div align="center" class="style2">Jml PI</div></td>
                            </tr>
                            <?php
                            $get1 = OCIexec($sql);
                            $x = 0;
                            while (OCIfetch($get1)) {
                                $order_date = OCIresult($get1, 'ORDER_DATE');
                                $tgl_ps = OCIresult($get1, 'TGL_PS');
                                $kd_avg = OCIresult($get1, 'KD_AVG');
                                $nama = OCIresult($get1, 'NAMA');
                                $order_id = OCIresult($get1, 'ORDER_ID');
                                $jenis_psb = OCIresult($get1, 'JENIS_PSB');
                                $jml_ps = OCIresult($get1, 'JML_PS');
                                $jml_pi = OCIresult($get1, 'JML_PI');
                                

                                $x++;
                                if ($x % 2 == 0)
                                    $bg = "#f4f4f4";
                                else
                                    $bg = "#FFFFFF";
                                ?>

                                <tr bgcolor="<?= $bg ?>">
                                    <td><span class="style14"><?php echo $x; ?></span></td> <!--Nomor-->
                                    <td><span class="style14"><?php echo $order_date; ?></span></td> <!--ORDER DATE-->
                                    <td><span class="style14"><?php echo $tgl_ps; ?></span></td> <!--TGL_PS-->
                                    <td><span class="style14"><?php echo $kd_avg; ?></span></td> <!--KD_AVG-->
                                    <td><span class="style14"><?php echo $nama; ?></span></td> <!--NAMA-->
                                    <td><span class="style14"><?php echo $order_id; ?></span></td> <!--ORDER_ID-->
                                    <td><span class="style14"><?php echo $jenis_psb; ?></span></td> <!--JENIS_PSB-->
                                    <td><span class="style14"><?php echo $jml_ps; ?></span></td> <!--JML_PS-->
                                    <td><span class="style14"><?php echo $jml_pi; ?></span></td> <!--JML_PI-->                                   
                                </tr>
                        </div>
            <?php
        }
}?>
            </table>
        </form>    
    </body>
    </html>