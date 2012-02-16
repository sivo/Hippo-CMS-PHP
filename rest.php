<?php
echo '<h1>Using REST API</h1>';

if($_GET['detail'] == null) {
  $url = 'http://www.demo.onehippo.com/restapi/topproducts?_type=xml&sortby=hippogogreen%3Arating&sortdir=descending&max=4';
  
  // Using cURL to get the response
  $session = curl_init($url);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($session);
  curl_close($session);
  
  // Parse the XML response
  $topProducts = new SimpleXMLElement($response);

  // Output
  echo "<table>\n<th colspan='3' bgcolor='#33ff33'>Products</th>\n";
  echo "<tr bgcolor='#dddddd'><td>Name</td><td>Price</td><td>Rating</td></tr>\n";
  
  foreach($topProducts->product as $product) {
    echo "<tr><td>\n";
    echo "<a href='?detail=$product->productLink'>";
    echo $product->localizedName;
    echo "</a></td>\n";
    echo "<td>\$$product->price</td>";
    echo "<td>$product->rating</td></tr>\n";
  }

  echo "</table>\n";
} else {
  $url = $_GET['detail'];
  $url = $url . "?_type=xml";

  // Using cURL to get the response
  $session = curl_init($url);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($session);
  curl_close($session);

  // Parse the XML response
  $product = new SimpleXMLElement($response);

  // Output
  echo "<table width='600px'>\n";
  echo "<th colspan='2' bgColor='#dddddd'>Product</th>";

  echo "<tr>\n";
  echo "<td>Name</td><td>$product->localizedName</td>\n";
  echo "</tr>\n";
  
  echo "<tr>\n";
  echo "<td>Summary</td><td>$product->summary</td>\n";
  echo "</tr>\n";

  echo "<tr>\n";
  echo "<td>Description</td><td>$product->description</td>\n";
  echo "</tr>\n";
  
  echo "<tr>\n";
  echo "<td>Link</td><td><a href='$product->productLink'>$product->productLink</a></td>\n";
  echo "</tr>\n";
}

?>
