<?php
ob_start();
session_start();
ob_end_clean();
if (isset($_SESSION["username"])) {
    ?>
    <?php
    include ("include.php");
    ?>
    <html>
        <link rel="shortcut icon" href="assets/img/logotelkom.png">
        <head>
            <title>Cek Alamat</title>
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
                html body .kelurahan{ position: absolute; left: 30px; top: 25%; z-index: 3;}
                html body .alamat{ position: absolute; left: 280px; top: 25%; z-index: 3;}
                html body .nomor{position: absolute; left: 530px; top: 25%; z-index: 3;}
                html body .cari {position: absolute; left: 780px; top: 25%; z-index: 3;}

            </style>
        </head>

        <body style="background-color: #e8e8e8">
            <img src="assets\img\telkom.png" alt="Image" style="width: 240px; height: 130px; margin-left: 15px; margin-top: 15px; z-index: 2;">
            <form name="A" method="post" action="verifikasi.php">           

                <?php
                if (isset($_POST['submit'])) {
                    $kel = ($_POST['kel']);
                    $jl = ($_POST['jl']);
                    $no = ($_POST['no']);
                    $upkel = strtoupper($kel);
                    $upjl = strtoupper($jl);
                    $upno = strtoupper($no);
                    $sql2 = "select nama,lvoie||' <b>'||nvoie||'</b> '||bat alamat,lquartier,lcom,nd,nd_reference,rp_tagihan,decode(tunda_cabut,1,'Cabut','') cabut from i_dossier_datek where (lquartier like '%$upkel%' and lvoie like '%$upjl%' and (nvoie like '$upno%' or nvoie is null) and witel='SURABAYA') and (nd_reference is null or nd like '1%') order by lvoie";
//echo $sql1;
                    ?>
                    <a href="logoutverifikasi.php" style="position: absolute; right: 2%; top: 37%;" class="btn" value="Keluar">Keluar</a>   
                    <div class="box1">
                        <div class="kelurahan"><label>Kelurahan</label>
                            <input name="kel" type="text" value="<?php echo $kel; ?>"></div>
                        <div class="alamat"><label>Alamat</label>
                            <input name="jl" type="text" value="<?php echo $jl; ?>"></div>
                        <div class="nomor"><label>Nomor</label>
                            <input name="no" type="text" value="<?php echo $no; ?>"></div>               
                        <div class="cari"><label>&nbsp;</label>
                            <input type="submit" name="submit" value="CARI" class="btn btn-danger"></div>
                        <a href="pencarianlanjut.php" style="color: black; text-decoration: underline; position: absolute; left: 30px; top: 31.5%; z-index: 3;">Pencarian Lanjut</a>
                    </div>
                    <div class="box2">
                        <hr>
                        <label style="margin-left: 30px;"><b>Alamat : </b><?php echo $upjl . " " . $upno . " " . $upkel; ?></label>
                        <table width="100%"  class="table table-bordered">
                            <tr bgcolor="#ea2522">
                                <td ><div align="center" class="style2">No</div></td>
                                <td width="14%"><div align="center" class="style2">Nama</div></td>
                                <td width="11%"><div align="center" class="style2">Alamat</div></td>
                                <td width="12%"><div align="center" class="style2">Kelurahan</div></td>
                                <td width="7%"><div align="center" class="style2">Kota</div></td>
                                <td width="10%"><div align="center" class="style2">INET</div></td>
                                <td width="8%"><div align="center" class="style2">Tagihan INET</div></td>
                                <td width="4%"><div align="center" class="style2">Cabut INET</div></td>
                                <td width="6%"><div align="center" class="style2">Tgl Bayar INET</div></td>
                                <td width="10%"><div align="center" class="style2">POTS</div></td>                            
                                <td width="8%"><div align="center" class="style2">Tagihan POTS</div></td>
                                <td width="4%"><div align="center" class="style2">Cabut POTS</div></td>
                                <td width="6%"><div align="center" class="style2">Tgl Bayar POTS</div></td>
                            </tr>
                            <?php
                            $get2 = OCIexec($sql2);
                            $x = 0;
                            while (OCIfetch($get2)) {
                                $nama = OCIresult($get2, 'NAMA');
                                $alm = OCIresult($get2, 'ALAMAT');
                                $lurah = OCIresult($get2, 'LQUARTIER');
                                $kota = OCIresult($get2, 'LCOM');
                                $nd = OCIresult($get2, 'ND');
                                $ndref = OCIresult($get2, 'ND_REFERENCE');
                                $tag = OCIresult($get2, 'RP_TAGIHAN');


                                $cbt = OCIresult($get2, 'CABUT');

                                $sql3 = "select payment_date from trems_payment a where telp='$nd' and nper =(select max(nper) from trems_payment where telp=a.telp)";
                                $get3 = OCIexec($sql3);

                                if (OCIfetch($get3)) {
                                    $byr2 = OCIresult($get3, 'PAYMENT_DATE');
                                    $th = substr($byr2, 0, 4);
                                    $bl = substr($byr2, 4, 2);
                                    $tg = substr($byr2, 6, 2);
                                }

                                $tagpots = "select nama,lvoie||' <b>'||nvoie||'</b> '||bat alamat,lquartier,lcom,nd,nd_reference,rp_tagihan,decode(tunda_cabut,1,'Cabut','') cabut from i_dossier_datek where lquartier like '%$upkel%' and lvoie like '%$upjl%' and (nvoie like '$upno%' or nvoie is null) and witel='SURABAYA' and (nd='$ndref' or nd_reference='$ndref') order by lvoie";
                                $getpots = OCIexec($tagpots);
                                if (OCIfetch($getpots)) {
                                    $tagihanpots = OCIresult($getpots, 'RP_TAGIHAN');
                                    $cbtpots = OCIresult($getpots, 'CABUT');
                                    $sqlpots = "select payment_date from trems_payment a where telp='$ndref' and nper =(select max(nper) from trems_payment where telp=a.telp)";
                                    $getsqlpots = OCIexec($sqlpots);
                                    if (OCIfetch($getsqlpots)) {

                                        $byrpots = OCIresult($getsqlpots, 'PAYMENT_DATE');
                                        $thp = substr($byrpots, 0, 4);
                                        $blp = substr($byrpots, 4, 2);
                                        $tgp = substr($byrpots, 6, 2);
                                    }
                                }

                                $x++;
                                if ($x % 2 == 0)
                                    $bg = "#f4f4f4";
                                else
                                    $bg = "#FFFFFF";
                                ?>



                                <tr bgcolor="<?= $bg ?>">
                                    <td><span class="style14"><?php echo $x; ?></span></td> <!--Nomor-->
                                    <td><span class="style14"><?php echo $nama; ?></span></td> <!--Nama-->
                                    <td><span class="style14"><?php echo $alm; ?></span></td> <!--Alamat-->
                                    <td><span class="style14"><?php echo $lurah; ?></span></td> <!--Kelurahan-->
                                    <td><span class="style14"><?php echo $kota; ?></span></td> <!--Kota-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo "";} else {echo $nd;} ?></span></td> <!--INET-->
                                    <td align="right"><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo "";} else {echo number_format($tag);} ?></span></td> <!--Tagihan INET-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo "";} else {echo $cbt;} ?></span></td> <!--Cabut INET-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo "";} else {echo $th . "-" . $bl . "-" . $tg;} ?></span></td> <!--Tgl INET-->
                                    <!--==================================================================================================================================================================================-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo $nd;} elseif (($ndref == null) || (substr($ndref, 0, 1) == 1)) {echo "";} else {echo $ndref;} ?></span></td> <!--POTS-->
                                    <td align="right"><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo number_format($tag);} elseif (($ndref == null) || (substr($ndref, 0, 1) == 1)) {echo "";} else {echo number_format($tagihanpots);} ?></span></td> <!--Tagihan POTS-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo $cbt;} elseif (($ndref == null) || (substr($ndref, 0, 1) == 1)) {echo "";} else {echo $cbtpots;} ?></span></td> <!--Cabut POTS-->
                                    <td><span class="style14"><?php if ((substr($nd, 0, 1) == 0) || ($nd == null)) {echo $th . "-" . $bl . "-" . $tg;} elseif (($ndref == null) || (substr($ndref, 0, 1) == 1)) {echo "";} else {echo $thp . "-" . $blp . "-" . $tgp;} ?></span></td> <!--Tgl POTS-->
                                </tr>
                        </div>
            <?php
        }
    } else {
        ?>
                    <a href="logoutverifikasi.php" style="position: absolute; right: 2%; top: 15%;" class="btn" value="Keluar">Keluar</a>
                    <div class="box1">
                        <div class="kelurahan"><label>Kelurahan</label>
                            <input name="kel" type="text" ></div>
                        <div class="alamat"><label>Alamat</label>
                            <input name="jl" type="text" ></div>
                        <div class="nomor"><label>Nomor</label>
                            <input name="no" type="text" ></div>               
                        <div class="cari"><label>&nbsp;</label>
                            <input type="submit" name="submit" value="CARI" class="btn btn-danger"></div>
                        <a href="pencarianlanjut.php" style="color: black; text-decoration: underline; position: absolute; left: 30px; top: 32%; z-index: 3;">Pencarian Lanjut</a>
                        <hr>
                    </div>

                    <img src="assets\img\telkombuilding.png" alt="Image" style="position: absolute; bottom: 0%; z-index: 1;">
                    <a href="http://danangaditya.co.nf/" style="font-size: 11px; color: grey; position: absolute; bottom: 0%; right: 1%; z-index: 2;">DEV</a>
    <?php }
    ?>
            </table>
        </form>
    </body>
    </html>
    <?php
} else {
    echo header("location:loginverifikasi.php");
}
?>
