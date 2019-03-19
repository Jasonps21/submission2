<!DOCTYPE html>
<html>
 <head>
 <title>Azure Blog Storage Submission 2</title>
 <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
 </head>
 <nav class="navbar navbar-expand-sm navbar-dark bg-primary mb-3">
<div class="container">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data targer="#mobile-nav">
	<span class="navbar-toggle-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="mobile-nav">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a href="#" class="nav-link"></a>
			</li>
		</ul>
	</div>
</div>
</nav>
<body>
<div class="container">

<h1>Blog Storage</h1>
<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

//$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');
$connectionString = "DefaultEndpointsProtocol=https;AccountName=jasonwebapp;AccountKey=Oo1tgnNa7f4xg68/qM8ZaqK+xpZiXj5KEwu8oTcAolw8UGcMoqtCJ38tEeCMvYyWH46RVQRM0LaBaXd00g3rrA==;";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

//$fileToUpload = "HelloWorld.txt";
//$fileToUpload = "original.jpg";
$fileToUpload = "holiday.jpeg";

if (!isset($_GET["Cleanup"])) {
    // Create container options object.
    $createContainerOptions = new CreateContainerOptions();

    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

    // Set container metadata.
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");

    //$containerName = "blockblobs".generateRandomString();
    $containerName = "blockblobsczdwsp";

    try {
        // Create container.
        //$blobClient->createContainer($containerName, $createContainerOptions);

        // Getting local file so that we can upload it to Azure
        /*$myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
        fclose($myfile);
        
        # Upload file as a block blob
        echo "Uploading BlockBlob: ".PHP_EOL;
        echo $fileToUpload.". Container Name: ".$containerName;
        echo "<br />";
        
        $content = fopen($fileToUpload, "r");

        //Upload blob
        $blobClient->createBlockBlob($containerName, $fileToUpload, $content);*/

        // List blobs.
        $listBlobsOptions = new ListBlobsOptions();
        //$listBlobsOptions->setPrefix("HelloWorld");

        
?>
<table class="table">
		<thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>URL</th>
            <th>Opsi</th>
        </tr>
		</thead>
		<?php
        do{
            $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
			$no=1;
            foreach ($result->getBlobs() as $blob)
            {
				?>
		<tr>
            <td><?php echo $no ?></td>
            <td><?php echo $blob->getName() ?></td>
            <td><?php echo $blob->getUrl() ?></td>
            <td><a class="btn btn-sm btn-info" target="blank" href="vision.php?url=<?php echo $blob->getUrl()?>"><i class="fa fa-eye"></i></a></td>
        </tr>
                
        <?php   
			//echo $blob->getName().": ".$blob->getUrl()."<br />";
			$no++;
		}
        
            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());
        echo "<br />";
?>
</table>
<?php
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
} 
else 
{

    try{
        // Delete container.
        echo "Deleting Container".PHP_EOL;
        echo $_GET["containerName"].PHP_EOL;
        echo "<br />";
        $blobClient->deleteContainer($_GET["containerName"]);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
?>


<form method="post" action="phpQS.php?Cleanup&containerName=<?php echo $containerName; ?>">
    <button type="submit" class="btn btn-danger" name="submit">Press to clean up all resources created by this sample</button>
</form>

 </div>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 </body>
 </html>
