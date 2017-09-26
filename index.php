<?php
/**
 * Created by PhpStorm.
 * User: tasfin
 * Date: 25/09/17
 * Time: 14:29
 */

require_once "GoogleApi.php";
require_once "DataParser.php";

set_time_limit(0);

$success  = "";
$error    = "";
$sheetArr = ["testcase" => "testcase", "steps" => "steps", "step" => "step"];

//echo "<pre>";

if(isset($_POST['btSubmitCache'])){
    //print_r($_POST); die;
    $fileName  = trim($_POST['sheet_name']);
    $sheetName = trim($_POST['work_sheet_name']);
    $fromCache = true;

    if($fileName && $sheetName){
        $googleApi = new \project\GoogleApi\GoogleApi();
        $googleApi->fetch($fileName, $sheetName,  $fromCache);
        $success = "File: <span style='font-weight: bold;'>".$fileName."</span> and Sheet: <span style='font-weight: bold;'>".$sheetName."</span> have been cached successfully.";
    }
    else{
        $error = "Please enter the spread sheet name and work sheet/ tab name correctly.";
    }
}

if(isset($_POST['btSubmitCreateSheet'])){
    //echo "<pre>";
    //print_r($_POST); die;
    $fileName  = trim($_POST['sheet_name']);
    //$sheetName = trim($_POST['work_sheet_name']);
    $fromCache = intval($_POST['file_load_type']) == 1 ? true : false;
    $tabName   = trim($_POST['tab_start_from']);
    $noOfTab   = intval($_POST['no_of_tab']);


    if($fileName && $tabName){
        $googleApi = new \project\GoogleApi\GoogleApi();

        $testCaseData   = $googleApi->fetch($fileName, $sheetArr["testcase"],  $fromCache);
        $stepMapData    = $googleApi->fetch($fileName, $sheetArr["steps"],     $fromCache);
        $stepResData    = $googleApi->fetch($fileName, $sheetArr["step"],      $fromCache);

        //print_r($stepResData); //die;

        $tabData = mergeData($testCaseData, $stepMapData, $stepResData);
        //print_r($tabData); DIE;

        $googleApi->writeDataInSpreadSheet($fileName, $tabData, $tabName, $noOfTab);

        $success = "Spread sheet has been created successfully.";
    }
    else{
        $error = "Please enter the spread sheet name and tab name correctly.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="media/images/favicon.ico" sizes="16x16 32x32 48x48 64x64" type="image/vnd.microsoft.icon">
    <title>FN:: Google Sheet</title>

    <link href="media/css/bootstrap.min.css" rel="stylesheet">
    <link href="media/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="media/js/html5shiv.min.js"></script>
    <script src="media/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="media/images/logo.png" alt="logo" title="FN" border="0" /></a>
        </div>
        <!--<div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar/">Default</a></li>
                <li><a href="../navbar-static-top/">Static top</a></li>
                <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>-->
    </div>
</nav>

<div class="container">

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <!--<h3>Google Sheet</h3>-->
        <?php if(!empty($error)){ ?>
        <div class="row bg-danger" style="margin-top: 10px; padding: 15px; margin-right: 0px; margin-left: 0px;">
            <?php echo $error; ?>
        </div>
        <?php } ?>
        <?php if(!empty($success)){ ?>
        <div class="row bg-success" style="margin-top: 10px; padding: 15px; margin-right: 0px; margin-left: 0px;">
            <?php echo $success; ?>
        </div>
        <?php } ?>
        <div style="padding: 10px 0px 10px 0px; font-weight: bold">Make cache</div>
        <div class="row bg-info" style="padding: 15px; margin-right: 0px; margin-left: 0px;">
            <form name="frmCache" action="" method="post">
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="sheet_name">File Name: </label>
                        <input type="text" value="" class="form-control" name="sheet_name" id="sheet_name" placeholder="Backup_test_cases_xlsx_1_2">
                    </div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="work_sheet_name">Work Sheet Name/ Tab Name</label>
                        <select class="form-control" name="work_sheet_name">
                            <?php
                            if($sheetArr){
                                foreach ($sheetArr as $sheet){
                                    echo '<option value="'.$sheet.'">'.$sheet.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="btSubmitCache">&nbsp; </label>
                        <button onclick="return confirm('Do you want to cache the Spread Sheet?');"  type="submit" class="form-control btn btn-success" name="btSubmitCache" id="btSubmitCache" class="btn btn-default">Make Cache</button>
                    </div>
                </div>
            </form>
        </div>

        <div style="padding: 10px 0px 10px 0px; font-weight: bold">Create Spread Sheet</div>
        <div class="row bg-warning" style="padding: 15px; margin-right: 0px; margin-left: 0px;">
            <form name="frmCache" action="" method="post">
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="sheet_name">File Name: </label>
                        <input type="text" value="" class="form-control" name="sheet_name" id="sheet_name" placeholder="Backup_test_cases_xlsx_1_2">
                    </div>
                </div>
                <!--<div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="work_sheet_name">Work Sheet Name/ Tab Name</label>
                        <select class="form-control" name="work_sheet_name">
                            <?php
/*                            if($sheetArr){
                                foreach ($sheetArr as $sheet){
                                    echo '<option value="'.$sheet.'">'.$sheet.'</option>';
                                }
                            }
                            */?>
                        </select>
                    </div>
                </div>-->
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="tab_start_from">Start from (Tab Name)</label>
                        <input type="text" class="form-control" name="tab_start_from" id="tab_start_from" placeholder="Signup (Exact name without space)">
                    </div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="work_sheet_name">File Load Type</label>
                        <select class="form-control" name="file_load_type">
                            <option value="1">Load from Cache</option>
                            <option value="2">Load from Live</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="no_of_tab">No. of Tab want to create (-1 = all tab)</label>
                        <input type="text" value="-1" class="form-control" name="no_of_tab" id="no_of_tab" placeholder="-1 for all">
                    </div>
                </div>

                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label for="btSubmitCreateSheet">&nbsp; </label>
                        <button onclick="return confirm('Do you want to create Spread Sheet?');" type="submit" class="form-control btn btn-success" name="btSubmitCreateSheet" id="btSubmitCreateSheet" class="btn btn-default">Create Spread Sheet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- /container -->

<script src="media/js/jquery.min.js"></script>
<script src="media/js/bootstrap.min.js"></script>
</body>
</html>


