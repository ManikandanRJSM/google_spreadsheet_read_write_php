<!--
    Code By MAnikandan.R
    DevOps
    -->
<html>
  <head></head>
  <body>
    
    <script>
    function makeApiCall(action='read') {
   // alert(action);return false;
      var ssid = 'XXX'; // your spreadsheet ID
            var rng = 'XXX'; // your spreadsheet name
            if(action=='write'){
              // alert('if');return false;
              var vals = new Array(6);
              for(var row = 0; row < 3; row++){
                vals[row] = new Array(3);
                for(var col =0; col <3; col++){
                vals[row][col] = document.getElementById(row+":"+col).value;
                }
              }
              var params = {
                spreadsheetId : ssid,
                range : rng,
                valueInputOption : 'RAW',
              };
              var valueRangeBody = { "values": vals };
              var request = gapi.client.sheets.spreadsheets.values.update(params, valueRangeBody);

              request.then(function(response){
                console.log(response.result);
                populateSheet(response.result)
              },function(reason){
              console.error('error: ' + reason.result.error.message);
              });
            }else{
              // alert('ele');return false;
              var params = {
                // The ID of the spreadsheet to retrieve data from.
                spreadsheetId: 'XXX',  // your spreadsheet ID

                // The A1 notation of the values to retrieve.
                range: 'XXX',  // your spreadsheet name
              };

                var request = gapi.client.sheets.spreadsheets.values.get(params);
                request.then(function(response) {
                  // TODO: Change code below to process the `response` object:
                  console.log(response.result);
                  populateSheet(response.result);
                }, function(reason) {
                  console.error('error: ' + reason.result.error.message);
                });
              }
      
  }

  function populateSheet(result) {
    for(var row=0; row<8; row++) {
      for(var col=0; col<3; col++) {
      document.getElementById(row+":"+col).value = result.values[row][col];
      }

    }
}
    

    function initClient() {
       var API_KEY = 'YYYY';  // TODO: Update placeholder with desired API key.

      var CLIENT_ID = 'YYY';  // TODO: Update placeholder with 

      // TODO: Authorize using one of the following scopes:
      //   'https://www.googleapis.com/auth/drive'
      //   'https://www.googleapis.com/auth/drive.file'
      //   'https://www.googleapis.com/auth/drive.readonly'
      //   'https://www.googleapis.com/auth/spreadsheets'
      //   'https://www.googleapis.com/auth/spreadsheets.readonly'
      var SCOPE = 'https://www.googleapis.com/auth/spreadsheets.readonly';

      gapi.client.init({
        'apiKey': API_KEY,
        'clientId': CLIENT_ID,
        'scope': SCOPE,
        'discoveryDocs': ['https://sheets.googleapis.com/$discovery/rest?version=v4'],
      }).then(function() {
        gapi.auth2.getAuthInstance().isSignedIn.listen(updateSignInStatus);
        updateSignInStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
      });
    }

    function handleClientLoad() {
      gapi.load('client:auth2', initClient);
    }

    function updateSignInStatus(isSignedIn) {
      if (isSignedIn) {
        makeApiCall();
      }
    }

    function handleSignInClick(event) {
      gapi.auth2.getAuthInstance().signIn();
    }

    function handleSignOutClick(event) {
      gapi.auth2.getAuthInstance().signOut();
    }


    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
    <button id="signin-button" onclick="handleSignInClick()">Sign in</button>
    <button id="signout-button" onclick="handleSignOutClick()">Sign out</button>
    <button id="save-button" onclick="makeApiCall(action='write')">Save</button>

    <div style="margin-left:auto; margin-right:auto; width:960px;">
    <?php
    for($row = 0; $row < 8; $row++) {
      echo "<div style='clear:both'>";
      for($col = 0; $col < 3; $col++) {
        echo "<input type='text' style='float:left;' name = '$row:$col' id='$row:$col'>";
      }
      echo "</div>";
    }
    ?>
  </body>
</html>
