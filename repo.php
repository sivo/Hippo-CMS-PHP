<?php
echo "<pre>This is repo.php\n</pre>";

require_once("java/Java.inc");

// Get a session. This session is for the local repository. The session object 
// behaves no different when you connect to another repository
$repofac = new Java("org.hippoecm.repository.HippoRepositoryFactory");
$repo = $repofac->getHippoRepository();
$session = $repo->login("admin", array('a','d','m','i','n'));

// Get the workspace and query manager, to be able to execut queries
$ws = $session->getWorkspace();
$qm = $ws->getQueryManager();

$folder = '/jcr:root/content/documents/hippogogreen/products';

if(!isset($_GET['product'])) {
  // To show a link to all products, a query is executed, returning all
  // product documents under the products content root
  $xpath = "$folder//element(*,hippogogreen:product)";
  $q = $qm->createQuery($xpath, 'xpath');
  $qr = $q->execute();
  $nodes = $qr->getNodes();

  // Iterate over the found nodes ($nodes is a NodeIterator) to create links
  while(java_values($nodes->hasNext())) {
    $node = $nodes->nextNode();
    echo "<a href='?product={$node->getName()}'>";
    echo $node->getProperty('hippogogreen:title')->getString();
    echo "</a><br />\n";
  }
} else {
  // When a product is specified, get that product from the repository,
  // and output some information
  $xpath = "$folder//element(". $_GET['product'] .",hippogogreen:product)";
  $q = $qm->createQuery($xpath, 'xpath');
  $qr = $q->execute();
  $nodes = $qr->getNodes();
  
  while(java_values($nodes->hasNext())) {
    $node = $nodes->nextNode();
    echo "<h1>". $node->getProperty('hippogogreen:title')->getString() ."</h1>\n";
    echo "<div>Price: $ ". $node->getProperty('hippogogreen:price')->getString() ."</div>\n";
    echo "<div><em>". $node->getProperty('hippogogreen:summary')->getString() ."</em></div>\n";
    echo "<div>". $node->getNode('hippogogreen:description')->getProperty('hippostd:content')->getString() ."</div>\n";
  }
}
?>
