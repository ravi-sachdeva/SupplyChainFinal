<?php 

	session_start();


 ?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Welcome <?php echo $_SESSION['username'] ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style type="text/css">
    .navbar-brand{
    font-family: 'Pacifico', cursive;
    font-size: 2.6rem;
    }




    </style>
 </head>


<body>

	<?php include('navbar.php'); ?>

	<div class="container">
		
		<form>
			<div class="form-group">
				<label>Product Name</label>
				<input type="text" name="name" id="prod_name" placeholder="name">
			</div>

			<div class="form-group">
				<label>Product Description</label>
				<textarea id="desc"></textarea>
			</div>
			
			<input type="text" id="username" hidden="true" value="<?php echo $_SESSION['username'] ?>">
			<button id="submit" class="btn btn-success">Submit</button>
		</form>

		<table class="table table-striped">
  			<thead>
  					<tr>
  							<th>ID</th>
  							<th>Product Name</th>
  							<th>Description</th>
  							<th>Date</th>
  					</tr>
  			</thead>
  			<tbody id="target">
  					
  			</tbody>
		</table>
	</div>




		






		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/web3.min.js"></script>
		<script src="js/truffle-contract.js"></script>
		<script src="js/connectweb3.js"></script>
		<script>
			
			






			var contracts = {};

		  $.ajaxSetup({async: false});  


			$.getJSON('build/contracts/Supplychain.json', function(data) {
			  
			  var SupplychainArtifact = data;
			  contracts.Supplychain = TruffleContract(SupplychainArtifact);

			  
			  contracts.Supplychain.setProvider(web3Provider);
			  console.log(contracts);
			  
			});




			 $(document).ready(function(){
            $("button").click(function(event){

              console.log("clicked");
              event.preventDefault();
              var name = $('#prod_name').val();
              var desc = $('#desc').val();
              var author = $('#username').val();
              
              var today = new Date();
        			var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();


              var supplychainInstance ;
              web3.eth.getAccounts(function(error,accounts){
                  if(error){
                    console.log(error);
                  }

                  var account = accounts[0];

                  contracts.Supplychain.deployed().then(function(instance){
                      supplychainInstance = instance;
                      console.log(supplychainInstance.address);
                      return supplychainInstance.addItem(name,author,desc,thisdate,{from:account})
                  }).catch(function(err){
                      console.log(err.message);
                  }).then(function(){
                  		contracts.Supplychain.deployed().then(function(instance){
                  		supplychainInstance = instance;
                  	  supplychainInstance.get.call().then(function(num){
                  			var id = num.toNumber();
                  			for(var i =0;i<id;i++)
                  			{	
                  					var inHtml = "";
                  					
                  					supplychainInstance.searchProduct.call(i).then(function(details){
                  							
                  							var info = details.split("/");
                  							inHtml = inHtml + "<tr><td>"+info[0]+"</td><td>"+info[1]+"</td><td>"+info[2]+"</td><td>"+info[3]+"</td></tr>";
                  							document.getElementById("target").innerHTML = inHtml;
                  							console.log(details);


                  					}).then(function(result){
                  						// document.getElementById("info").innerHTML = inHtml;

                  					})
                  			}
                  	  })
                  	
                  })
                  })

                  
                  


            });
        });
          });

		</script>



</body>
</html>

