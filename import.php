<html>
  <head>
    <style>
      #main {
        position: relative;
        width: 500px;
        left: 50%;
        margin-left: -250px;

        background-color: #FFEEEE;

        border: 1px dashed;
        height: 750px;
      }

      #banner {
        clear: both;
        background-color: #EEFFEE;
        height: 250px;
      }

      #columns {
        float: left;
        clear: both;
        background-color: #EEEEFF;
        height: 500px;
        width: 100%;
      }

      #column1 {
        float: left;
        position: relative;
        background-color: #EFCEEF;

        height: 100%;
        width: 100px;
        left: 0px;
      }

      #column3 {
        float: left;
        position: relative;
        background-color: #EFEECF;

        height: 100%;
        width: 100px;
        right: 0px;
      }

      #column2 {
        float: left;
        background-color: #CFEEFF;
        height: 100%;
        width: 300px;
      }


    </style>
  </head>
  <body>
    <div id="main">
      <div id="banner">Banner</div>
      <div id="columns">
        <div id="column1" class="column">Column 1</div>
        <div id="column2" class="column">
          <?php
            // Import the column using cURL
            $url = "http://localhost:8080/site/column";
            $session = curl_init($url);
            curl_exec($session);
            curl_close($session);
          ?>
        </div>
        <div id="column3" class="column">Column 3</div>
      </div>
    </div>
  </body>
</html>

