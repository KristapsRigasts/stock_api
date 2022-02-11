<?php

require_once('vendor/autoload.php');

$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c832e22ad3ie4lt0c1dg');
$client = new Finnhub\Api\DefaultApi(
    new GuzzleHttp\Client(),
    $config
);

$search = $_GET['search'] ?? '';

$companyAapl = 'AAPL';
$companyTsla = 'TSLA';
$companyAmzn = 'AMZN';
$companyMsft = 'MSFT';

$companies = [$companyAapl, $companyTsla, $companyAmzn, $companyMsft];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock</title>

    <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 25%;
            padding: 10px;
            border: 2px solid black;

        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        h2 {
            text-align: center;
        }

        p {
            font-size: 20px;
        }
    </style>
</head>
<body>

<form method="get" action="/">
    <input name="search" value=""/>
    <button type="submit">Submit</button>
</form>

<h2>Company stocks</h2>

<?php if (strlen($search) < 1) { ?>

<div class="row">
    <?php foreach ($companies as $company) { ?>
        <div class="column" style="background-color:#FFE4B5;">
            <h2> <?php echo $client->companyProfile2($company)->getName(); ?></h2>
            <h3> <?php echo "Current price: " . $client->quote($company)->getC(); ?></h3>
            <?php if ($client->quote($company)->getD() >= 0) { ?>
            <p style="color:green">
                <?php } else { ?>
            <p style="color:red"> <?php } ?>
                <?php
                echo round($client->quote($company)->getD(), 2) . " " .
                    "(" . round($client->quote($company)->getDP(), 2) . "%)"; ?>
            </p>

        </div>
    <?php }
    }
    else {
        ?>
        <div class="column" style="background-color:#FFE4B5;">
            <h2> <?php echo $client->companyProfile2($search)->getName(); ?></h2>
            <h3> <?php echo "Current price: " . $client->quote($search)->getC(); ?></h3>
            <?php if ($client->quote($search)->getD() >= 0) { ?>
            <p style="color:green"> <?php
                } else { ?>
            <p style="color:red"> <?php } ?>
                <?php
                echo round($client->quote($search)->getD(), 2) . " " .
                    "(" . round($client->quote($search)->getDP(), 2) . "%)"; ?>
            </p>
        </div>
    <?php } ?>
</div>
</body>
</html>



