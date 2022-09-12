<?php
include './_database/config.php';

error_reporting(E_ERROR | E_PARSE);

$beta = mysqli_query($koneksitest, "SELECT * from air where arah = 'masuk' order by 'date' desc limit 12");
$barchart = mysqli_query($koneksitest, "SELECT * from harian order by 'id' asc");
$kualitas = mysqli_query($koneksitest, "SELECT * from kualitas order by 'date' desc limit 1");

$arr = array();
$time = array();
$vol = array();
$volhari = array();
$VolTanggal = array();
$tds = array();
$tss = array();
$ph = array();
$arr = array();

$i = -1;
while ($angka = mysqli_fetch_assoc($beta) && $hari = mysqli_fetch_assoc($barchart)) {
    array_push($arr, $angka['debit']);
    array_push($time, $angka['date']);
    array_push($vol, $angka['volume']);

    array_push($volhari, $hari['volume']);
    array_push($VolTanggal, $hari['tanggal']);

    $i++;
}

while ($KualitasNow = mysqli_fetch_assoc($kualitas)) {
    array_push($tds, $KualitasNow['tds']);
    array_push($tss, $KualitasNow['tss']);
    array_push($ph, $KualitasNow['ph']);
}



?>


<html lang="en">
<!DOCTYPE html>
<style>
    .gauge {

        width: auto;
        height: 230px;
        margin: 0 auto;
    }
</style>

<!-- Style Kualitas Air -->
<style>
    .outer-wrapper {
        display: inline-block;
        margin: 5px 15px;
        padding: 25px 15px;
        background: #eee;
        min-width: 50px;
    }

    .column-wrapper {
        height: 200px;
        width: 20px;
        background: #CFD8DC;
        transform: rotate(180deg);
        margin: 0 auto;
    }

    /* Style Gauge pH */
    .column {
        /* position: relative;
  display: block;
  bottom: 0; */
        width: 20px;
        height: 0%;
        background: #90A4AE;
        /* transfrom: -moz-translateY(-10px); */
    }

    .percentage,
    .value {
        margin-top: 10px;
        padding: 5px 10px;
        color: #FFF;
        background: #263238;
        position: relative;
        border-radius: 4px;
        text-align: center;
    }

    .value {
        background: #7986CB;
    }

    /* Style Gauge TSS */
    .TSScolumn {
        /* position: relative;
  display: block;
  bottom: 0; */
        width: 20px;
        height: 0%;
        background: #90A4AE;
        /* transfrom: -moz-translateY(-10px); */
    }

    .TSSpercentage,
    .value {
        margin-top: 10px;
        padding: 5px 10px;
        color: #FFF;
        background: #263238;
        position: relative;
        border-radius: 4px;
        text-align: center;
    }

    .value {
        background: #7986CB;
    }

    /* Style Gauge TDS */
    .TDScolumn {
        /* position: relative;
  display: block;
  bottom: 0; */
        width: 20px;
        height: 0%;
        background: #90A4AE;
        /* transfrom: -moz-translateY(-10px); */
    }

    .TDSpercentage,
    .value {
        margin-top: 10px;
        padding: 5px 10px;
        color: #FFF;
        background: #263238;
        position: relative;
        border-radius: 4px;
        text-align: center;
    }

    .value {
        background: #7986CB;
    }
</style>


<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2/dist/chart.min.js"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src = "http://jquery.com/"></script>


</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">PT. Sinko Prima Alloy</a>
        <!-- Sidebar Toggle-->
        <!-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button> -->
        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form> -->
        <!-- Navbar-->
        <!-- <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul> -->
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Monitoring</div>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Penggunaan Masuk
                        </a>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Penggunaan Keluar
                        </a>
                        <!-- <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a> -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin PT. Sinko
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" a>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Debit Air Lewat (L/M)
                                </div>
                                <div class="card-body">
                                    <div id="gg1" class="gauge"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Air Masuk Tandon
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="47"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Total Air Masuk Minggu Ini (L)
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="71"></canvas></div>
                            </div>
                        </div>

                        <div class="col-xl-6" style=>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Kondisi Air
                                </div>

                                <div class="card-body" style="display:flex;justify-content: center;">
                                    <div class="outer-wrapper">
                                        <div class="column-wrapper">
                                            <div class="column"></div>
                                        </div>
                                        <div class="percentage">--</div>
                                        <div class="value">pH</div>
                                    </div>

                                    <div class="outer-wrapper">
                                        <div class="column-wrapper">
                                            <div class="TSScolumn"></div>
                                        </div>
                                        <div class="TSSpercentage">--</div>
                                        <div class="value">TSS</div>
                                    </div>

                                    <div class="outer-wrapper">
                                        <div class="column-wrapper">
                                            <div class="TDScolumn"></div>
                                        </div>
                                        <div class="TDSpercentage">--</div>
                                        <div class="value">TDS</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>$86,000</td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>
                                        <td>$433,060</td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008/11/28</td>
                                        <td>$162,700</td>
                                    </tr>
                                    <tr>
                                        <td>Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2012/12/02</td>
                                        <td>$372,000</td>
                                    </tr>
                                    <tr>
                                        <td>Herrod Chandler</td>
                                        <td>Sales Assistant</td>
                                        <td>San Francisco</td>
                                        <td>59</td>
                                        <td>2012/08/06</td>
                                        <td>$137,500</td>
                                    </tr>
                                    <tr>
                                        <td>Rhona Davidson</td>
                                        <td>Integration Specialist</td>
                                        <td>Tokyo</td>
                                        <td>55</td>
                                        <td>2010/10/14</td>
                                        <td>$327,900</td>
                                    </tr>
                                    <tr>
                                        <td>Colleen Hurst</td>
                                        <td>Javascript Developer</td>
                                        <td>San Francisco</td>
                                        <td>39</td>
                                        <td>2009/09/15</td>
                                        <td>$205,500</td>
                                    </tr>
                                    <tr>
                                        <td>Sonya Frost</td>
                                        <td>Software Engineer</td>
                                        <td>Edinburgh</td>
                                        <td>23</td>
                                        <td>2008/12/13</td>
                                        <td>$103,600</td>
                                    </tr>
                                    <tr>
                                        <td>Jena Gaines</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>30</td>
                                        <td>2008/12/19</td>
                                        <td>$90,560</td>
                                    </tr>
                                    <tr>
                                        <td>Quinn Flynn</td>
                                        <td>Support Lead</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2013/03/03</td>
                                        <td>$342,000</td>
                                    </tr>
                                    <tr>
                                        <td>Charde Marshall</td>
                                        <td>Regional Director</td>
                                        <td>San Francisco</td>
                                        <td>36</td>
                                        <td>2008/10/16</td>
                                        <td>$470,600</td>
                                    </tr>
                                    <tr>
                                        <td>Haley Kennedy</td>
                                        <td>Senior Marketing Designer</td>
                                        <td>London</td>
                                        <td>43</td>
                                        <td>2012/12/18</td>
                                        <td>$313,500</td>
                                    </tr>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>19</td>
                                        <td>2010/03/17</td>
                                        <td>$385,750</td>
                                    </tr>
                                    <tr>
                                        <td>Michael Silva</td>
                                        <td>Marketing Designer</td>
                                        <td>London</td>
                                        <td>66</td>
                                        <td>2012/11/27</td>
                                        <td>$198,500</td>
                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td>Chief Financial Officer (CFO)</td>
                                        <td>New York</td>
                                        <td>64</td>
                                        <td>2010/06/09</td>
                                        <td>$725,000</td>
                                    </tr>
                                    <tr>
                                        <td>Gloria Little</td>
                                        <td>Systems Administrator</td>
                                        <td>New York</td>
                                        <td>59</td>
                                        <td>2009/04/10</td>
                                        <td>$237,500</td>
                                    </tr>
                                    <tr>
                                        <td>Bradley Greer</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>41</td>
                                        <td>2012/10/13</td>
                                        <td>$132,000</td>
                                    </tr>
                                    <tr>
                                        <td>Dai Rios</td>
                                        <td>Personnel Lead</td>
                                        <td>Edinburgh</td>
                                        <td>35</td>
                                        <td>2012/09/26</td>
                                        <td>$217,500</td>
                                    </tr>
                                    <tr>
                                        <td>Jenette Caldwell</td>
                                        <td>Development Lead</td>
                                        <td>New York</td>
                                        <td>30</td>
                                        <td>2011/09/03</td>
                                        <td>$345,000</td>
                                    </tr>
                                    <tr>
                                        <td>Yuri Berry</td>
                                        <td>Chief Marketing Officer (CMO)</td>
                                        <td>New York</td>
                                        <td>40</td>
                                        <td>2009/06/25</td>
                                        <td>$675,000</td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Vance</td>
                                        <td>Pre-Sales Support</td>
                                        <td>New York</td>
                                        <td>21</td>
                                        <td>2011/12/12</td>
                                        <td>$106,450</td>
                                    </tr>
                                    <tr>
                                        <td>Doris Wilder</td>
                                        <td>Sales Assistant</td>
                                        <td>Sidney</td>
                                        <td>23</td>
                                        <td>2010/09/20</td>
                                        <td>$85,600</td>
                                    </tr>
                                    <tr>
                                        <td>Angelica Ramos</td>
                                        <td>Chief Executive Officer (CEO)</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2009/10/09</td>
                                        <td>$1,200,000</td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Joyce</td>
                                        <td>Developer</td>
                                        <td>Edinburgh</td>
                                        <td>42</td>
                                        <td>2010/12/22</td>
                                        <td>$92,575</td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td>Regional Director</td>
                                        <td>Singapore</td>
                                        <td>28</td>
                                        <td>2010/11/14</td>
                                        <td>$357,650</td>
                                    </tr>
                                    <tr>
                                        <td>Brenden Wagner</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>28</td>
                                        <td>2011/06/07</td>
                                        <td>$206,850</td>
                                    </tr>
                                    <tr>
                                        <td>Fiona Green</td>
                                        <td>Chief Operating Officer (COO)</td>
                                        <td>San Francisco</td>
                                        <td>48</td>
                                        <td>2010/03/11</td>
                                        <td>$850,000</td>
                                    </tr>
                                    <tr>
                                        <td>Shou Itou</td>
                                        <td>Regional Marketing</td>
                                        <td>Tokyo</td>
                                        <td>20</td>
                                        <td>2011/08/14</td>
                                        <td>$163,000</td>
                                    </tr>
                                    <tr>
                                        <td>Michelle House</td>
                                        <td>Integration Specialist</td>
                                        <td>Sidney</td>
                                        <td>37</td>
                                        <td>2011/06/02</td>
                                        <td>$95,400</td>
                                    </tr>
                                    <tr>
                                        <td>Suki Burks</td>
                                        <td>Developer</td>
                                        <td>London</td>
                                        <td>53</td>
                                        <td>2009/10/22</td>
                                        <td>$114,500</td>
                                    </tr>
                                    <tr>
                                        <td>Prescott Bartlett</td>
                                        <td>Technical Author</td>
                                        <td>London</td>
                                        <td>27</td>
                                        <td>2011/05/07</td>
                                        <td>$145,000</td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Cortez</td>
                                        <td>Team Leader</td>
                                        <td>San Francisco</td>
                                        <td>22</td>
                                        <td>2008/10/26</td>
                                        <td>$235,500</td>
                                    </tr>
                                    <tr>
                                        <td>Martena Mccray</td>
                                        <td>Post-Sales support</td>
                                        <td>Edinburgh</td>
                                        <td>46</td>
                                        <td>2011/03/09</td>
                                        <td>$324,050</td>
                                    </tr>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>Marketing Designer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/12/09</td>
                                        <td>$85,675</td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>Office Manager</td>
                                        <td>San Francisco</td>
                                        <td>51</td>
                                        <td>2008/12/16</td>
                                        <td>$164,500</td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>Secretary</td>
                                        <td>San Francisco</td>
                                        <td>41</td>
                                        <td>2010/02/12</td>
                                        <td>$109,850</td>
                                    </tr>
                                    <tr>
                                        <td>Vivian Harrell</td>
                                        <td>Financial Controller</td>
                                        <td>San Francisco</td>
                                        <td>62</td>
                                        <td>2009/02/14</td>
                                        <td>$452,500</td>
                                    </tr>
                                    <tr>
                                        <td>Timothy Mooney</td>
                                        <td>Office Manager</td>
                                        <td>London</td>
                                        <td>37</td>
                                        <td>2008/12/11</td>
                                        <td>$136,200</td>
                                    </tr>
                                    <tr>
                                        <td>Jackson Bradshaw</td>
                                        <td>Director</td>
                                        <td>New York</td>
                                        <td>65</td>
                                        <td>2008/09/26</td>
                                        <td>$645,750</td>
                                    </tr>
                                    <tr>
                                        <td>Olivia Liang</td>
                                        <td>Support Engineer</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2011/02/03</td>
                                        <td>$234,500</td>
                                    </tr>
                                    <tr>
                                        <td>Bruno Nash</td>
                                        <td>Software Engineer</td>
                                        <td>London</td>
                                        <td>38</td>
                                        <td>2011/05/03</td>
                                        <td>$163,500</td>
                                    </tr>
                                    <tr>
                                        <td>Sakura Yamamoto</td>
                                        <td>Support Engineer</td>
                                        <td>Tokyo</td>
                                        <td>37</td>
                                        <td>2009/08/19</td>
                                        <td>$139,575</td>
                                    </tr>
                                    <tr>
                                        <td>Thor Walton</td>
                                        <td>Developer</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2013/08/11</td>
                                        <td>$98,540</td>
                                    </tr>
                                    <tr>
                                        <td>Finn Camacho</td>
                                        <td>Support Engineer</td>
                                        <td>San Francisco</td>
                                        <td>47</td>
                                        <td>2009/07/07</td>
                                        <td>$87,500</td>
                                    </tr>
                                    <tr>
                                        <td>Serge Baldwin</td>
                                        <td>Data Coordinator</td>
                                        <td>Singapore</td>
                                        <td>64</td>
                                        <td>2012/04/09</td>
                                        <td>$138,575</td>
                                    </tr>
                                    <tr>
                                        <td>Zenaida Frank</td>
                                        <td>Software Engineer</td>
                                        <td>New York</td>
                                        <td>63</td>
                                        <td>2010/01/04</td>
                                        <td>$125,250</td>
                                    </tr>
                                    <tr>
                                        <td>Zorita Serrano</td>
                                        <td>Software Engineer</td>
                                        <td>San Francisco</td>
                                        <td>56</td>
                                        <td>2012/06/01</td>
                                        <td>$115,000</td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Acosta</td>
                                        <td>Junior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>43</td>
                                        <td>2013/02/01</td>
                                        <td>$75,650</td>
                                    </tr>
                                    <tr>
                                        <td>Cara Stevens</td>
                                        <td>Sales Assistant</td>
                                        <td>New York</td>
                                        <td>46</td>
                                        <td>2011/12/06</td>
                                        <td>$145,600</td>
                                    </tr>
                                    <tr>
                                        <td>Hermione Butler</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>47</td>
                                        <td>2011/03/21</td>
                                        <td>$356,250</td>
                                    </tr>
                                    <tr>
                                        <td>Lael Greer</td>
                                        <td>Systems Administrator</td>
                                        <td>London</td>
                                        <td>21</td>
                                        <td>2009/02/27</td>
                                        <td>$103,500</td>
                                    </tr>
                                    <tr>
                                        <td>Jonas Alexander</td>
                                        <td>Developer</td>
                                        <td>San Francisco</td>
                                        <td>30</td>
                                        <td>2010/07/14</td>
                                        <td>$86,500</td>
                                    </tr>
                                    <tr>
                                        <td>Shad Decker</td>
                                        <td>Regional Director</td>
                                        <td>Edinburgh</td>
                                        <td>51</td>
                                        <td>2008/11/13</td>
                                        <td>$183,000</td>
                                    </tr>
                                    <tr>
                                        <td>Michael Bruce</td>
                                        <td>Javascript Developer</td>
                                        <td>Singapore</td>
                                        <td>29</td>
                                        <td>2011/06/27</td>
                                        <td>$183,000</td>
                                    </tr>
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>2011/01/25</td>
                                        <td>$112,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="./js/raphael-2.1.4.min.js"></script>
    <script src="./js/justgage.js"></script>

    <script>
        var nilaiGauge;

        $(document).ready(function newData() {
            var gg1 = new JustGage({
                id: "gg1",
                value: updateData() + 'L/M',
                min: 0,
                max: 20,
                decimals: 2,
                gaugeWidthScale: 0.6,
                customSectors: [{
                    color: "#00ff00",
                    lo: 0,
                    hi: 5
                }, {
                    color: "#fc6f03",
                    lo: 5,
                    hi: 10
                }, {
                    color: "#ff0000",
                    lo: 10,
                    hi: 15
                }, {
                    color: "#fc03f0",
                    lo: 15,
                    hi: 20
                }],
                counter: true
            });

            //update data

            function updateData() {
                $.ajax({
                    type: "POST",
                    url: "./data.php",
                    data: "data='data'",
                    success: function(no) {
                        let arr = JSON.parse(no);
                        gg1.refresh(arr[22]);
                    }
                })
            }

            setInterval(function() {
                updateData();
            }, 1000);
        });
    </script>


    <!-- Control Area Chart Example -->




    <script type="text/javascript">
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        var Kosong = "Kosong";

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");

        var LineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php
                            for ($i = 0; $i <= 11; $i++) {
                                if ($time[$i] == NULL) {
                                    echo "Kosong" . ',';
                                } else {
                                    echo '"' . $time[$i] . '"' . ',';
                                }
                            } ?>],
                datasets: [{
                    label: "Debit (L/M)",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [<?php for ($i = 0; $i <= 11; $i++) {
                                if ($arr[$i] == NULL) {
                                    echo "0.0" . ',';
                                } else {
                                    echo $arr[$i] . ',';
                                }
                            } ?>],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 20,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });


        //pemanggilan dan pengulangan data

        function testin() {
            $.ajax({
                type: 'POST',
                url: 'data.php',
                data: 'data="data";',
                success: function(no) {
                    let arr = JSON.parse(no);

                    $a = -1;
                    $b = 0;

                    for ($i = 0; $i <= 24; $i++) {

                        if (arr[$i] != null) {
                            if ($i == 0) {
                                LineChart.data.datasets[0].data[$b] = arr[$i];
                                LineChart.data.labels[$a++] = arr[$i];
                            } else if ($i % 2 == 0) {
                                LineChart.data.datasets[0].data[$b++] = arr[$i];
                            } else if ($i % 2 == 1) {
                                LineChart.data.labels[$a++] = arr[$i];
                            } else {
                                LineChart.data.datasets[0].data[$i] = '0.0';
                                LineChart.data.labels[$a++] = 'Kosong';
                            }
                        }
                    }

                    LineChart.update();
                    
                },
            })

        }

        function testin2() {
            $.ajax({
                type: 'POST',
                url: 'backin.php',
                data: 'data="data";',
                success: function(no) {
                    let arr = JSON.parse(no);

                    BarChart.data.datasets[0].data[0] = arr[0];
                    BarChart.data.datasets[0].data[1] = arr[1];
                    BarChart.data.datasets[0].data[2] = arr[2];
                    BarChart.data.datasets[0].data[3] = arr[3];
                    BarChart.data.datasets[0].data[4] = arr[4];
                    BarChart.data.datasets[0].data[5] = arr[5];
                    BarChart.data.datasets[0].data[6] = arr[6];
                    
                    BarChart.update();

                },
            })

        }



        setInterval(function() {
            testin();
            testin2();
        }, 1000);
    </script>

    <script type="text/javascript">
        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var BarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    ["Senin", '<?php echo $VolTanggal[0]; ?>'],
                    ["Selasa", '<?php echo $VolTanggal[1]; ?>'],
                    ["Rabu", "<?php echo $VolTanggal[2]; ?>"],
                    ["Kamis", '<?php echo $VolTanggal[3]; ?>'],
                    ["Jum'at", '<?php echo $VolTanggal[4]; ?>'],
                    ["Sabtu", '<?php echo $VolTanggal[5]; ?>'],
                    ["Minggu", '<?php echo $VolTanggal[6]; ?>']
                ],
                datasets: [{
                    label: "Penggunaan",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [<?php
                            for ($i = 0; $i <= 6; $i++) {
                                echo $volhari[$i] . ',';
                            } ?>],
                }],
            },
            options: {

                scales: {
                    xAxes: [{
                        time: {
                            unit: 'day'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6,
                            autoSkip: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 50,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <!-- Javacript Style Kualitas Air -->
    <script>
        var PhsSens;

        function PhSens() {

            $.ajax({
                type: "POST",
                url: "./datakualitas.php",
                data: "data='data'",
                success: function(no) {
                    let arr = JSON.parse(no);

                    var pHmeter = arr[2];
                    var randPercent = (pHmeter / 14.00) * 100;
                    var FloorPhMeter = Math.floor(pHmeter * 100) / 100
                    //Generic column color
                    var color = '#90A4AE';

                    if (randPercent <= 100 && randPercent >= 80) {
                        color = '#9e00ff';
                    } else if (randPercent < 80 && randPercent >= 53) {
                        color = '#0013ff';
                    } else if (randPercent < 53 && randPercent >= 43) {
                        color = '#3aff00';
                    } else if (randPercent < 43 && randPercent >= 20) {
                        color = '#fbff00';
                    } else if (randPercent < 20 && randPercent >= 0) {
                        color = '#ff0000';
                    }

                    $('.column').css({
                        background: color
                    });

                    $('.column').animate({
                        height: randPercent + '%',
                    });


                    $('.percentage').text(FloorPhMeter);

                }
            })



        }

        function TSSSens() {

            $.ajax({
                type: "POST",
                url: "./datakualitas.php",
                data: "data='data'",
                success: function(no) {
                    let arr = JSON.parse(no);



                    var TSSmeter = arr[1];
                    var TSSrandPercent = (TSSmeter / 3000) * 100;
                    var floorTSS = Math.floor(TSSmeter);

                    //Generic column color
                    var color = '#90A4AE';

                    if (TSSrandPercent >= 90) {
                        color = '#FF3D00';
                    } else if (TSSrandPercent < 90 && TSSrandPercent >= 60) {
                        color = '#FF9800';
                    } else if (TSSrandPercent < 60 && TSSrandPercent >= 40) {
                        color = '#FFEB3B';
                    } else if (TSSrandPercent < 40 && TSSrandPercent >= 10) {
                        color = '#81C784';
                    } else if (TSSrandPercent < 10 && TSSrandPercent >= 0) {
                        color = '#00E676';
                    }

                    $('.TSScolumn').css({
                        background: color
                    });

                    $('.TSScolumn').animate({
                        height: TSSrandPercent + '%',
                    });


                    $('.TSSpercentage').text(floorTSS);
                }
            })



        }

        function TDSSens() {

            var tds;


            $.ajax({
                type: "POST",
                url: "./datakualitas.php",
                data: "data='data'",
                success: function(no) {
                    let arr = JSON.parse(no);
                    tds = arr[0];

                    var TDSmeter = tds;
                    var TDSrandPercent = (TDSmeter / 1000) * 100;
                    var floorTDS = Math.floor(TDSmeter);

                    //Generic column color
                    var color = '#90A4AE';

                    if (TDSrandPercent >= 90) {
                        color = '#FF3D00';
                    } else if (TDSrandPercent < 90 && TDSrandPercent >= 60) {
                        color = '#FF9800';
                    } else if (TDSrandPercent < 60 && TDSrandPercent >= 45) {
                        color = '#FFEB3B';
                    } else if (TDSrandPercent < 45 && TDSrandPercent >= 20) {
                        color = '#81C784';
                    } else if (TDSrandPercent < 20 && TDSrandPercent >= 0) {
                        color = '#00E676';
                    }

                    $('.TDScolumn').css({
                        background: color
                    });

                    $('.TDScolumn').animate({
                        height: TDSrandPercent + '%',
                    });


                    $('.TDSpercentage').text(floorTDS);

                }
            })






        }

        setInterval(function() {
            PhSens();
            TSSSens();
            TDSSens();
        }, 1000);
    </script>




    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

</body>

</html>