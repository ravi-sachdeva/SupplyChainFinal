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
    <div>
      <input type="number" name="id" id="prod_id" placeholder="product id">
    </div>
    <div>
      <textarea id="desc" placeholder="Shipment status"></textarea>
    </div>
    <input type="text" id="username" hidden="true" value="<?php echo $_SESSION['username'] ?>">
    <button id="submit" class="btn btn-success">Update Status</button>


    <h2 id="heading"></h2>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Update</th>
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
              var id = $('#prod_id').val();
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
                      supplychainInstance.get.call().then(function(items){
                          var nos = items.toNumber();
                          if(id<nos && id>=0){
                              supplychainInstance.addState(id,desc,author,{from:account}).then(function(result){
                                  supplychainInstance.searchProduct.call(id).then(function(result){
                                      var info= result.split("/");
                                      var heading = "ID ->" + info[0] + "   Product Name -> : " + info[1] + "    Description  ->  " +info[2] + "    Date  ->  " + info[3] + " ";
                                      document.getElementById("heading").innerHTML=heading;

                                      var states = info[4].split("$");
                                      var nos = states.length;
                                      

                                      var inHtml = "";
                                      for(var i=0;i<nos-1;i++)
                                      {
                                          var state = states[i].split("*");
                                          var inHtml = inHtml + "<tr><td>"+state[0]+"</td><td>"+state[1]+"</td></tr>";

                                      }
                                      document.getElementById("target").innerHTML=inHtml;




                                  })
                              })
                          }
                          else{
                            console.log("Invalid ID");
                          }
                      })
                  })

                  
                  


            });
        });
          });

    </script>



</body>
</html>

