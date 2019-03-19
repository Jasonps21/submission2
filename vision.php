<?php
if (isset($_GET['url']))
{
   $url=$_GET['url'];
}
else
{
   header("Location:phpQS.php");
}
?>

<!DOCTYPE html>
<html>
 <head>
 <title>Analyze image</title>
 <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
 </head>
 <nav class="navbar navbar-expand-sm navbar-dark bg-primary mb-3">
<div class="container">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data targer="#mobile-nav">
	<span class="navbar-toggle-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="mobile-nav">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a href="index.php" class="nav-link">Kembali</a>
			</li>
		</ul>
	</div>
</div>
</nav>
<body>
<div class="container">
 
<script type="text/javascript">
    function processImage() { 
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "3fb8dc50343440b4ad90e9599b34eb61";
 
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase =
			"https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
 
        .done(function(data) {
			var obj = data['description']['captions'];
			document.getElementById("datahasil").innerHTML = obj[0].text;
            //$("#datahasil").val(data['requestId']);
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>
<div class="form-group">
    <label for="urlimage">URL Image</label>
    <input type="text" class="form-control" name="inputImage" id="inputImage" value="<?php echo $url; ?>">
</div>
<button class="btn btn-primary" onclick="processImage()">Analyze image</button>
<br><br>

<div id="wrapper" style="width:1020px; display:table;">
	<div id="imageDiv" style="width:420px; display:table-cell;">
        Source image:
        <br><br>
        <img id="sourceImage" width="400" />
    </div>
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        Response:
        <br><br>
		<p id="datahasil"></p>
    </div>
</div>
 </div>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 </body>
 </html>
