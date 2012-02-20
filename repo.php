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

$folder = '/jcr:root/content/documents/myhippoproject/news';

if(!isset($_GET['item'])) {
  // To show a link to all news items, a query is executed, returning all
  // news documents under the news content root
  $xpath = "$folder//element(*,myhippoproject:newsdocument)";
  $q = $qm->createQuery($xpath, 'xpath');
  $qr = $q->execute();
  $nodes = $qr->getNodes();

  // Iterate over the found nodes ($nodes is a NodeIterator) to create links
  while(java_values($nodes->hasNext())) {
    $node = $nodes->nextNode();
    echo "<a href='?item={$node->getName()}'>";
    echo $node->getProperty('myhippoproject:title')->getString();
    echo "</a><br />\n";
  }
} else {
  // When a news item is specified, get that item from the repository,
  // and output some information
  $xpath = "$folder//element(". $_GET['item'] .",myhippoproject:newsdocument)";
  $q = $qm->createQuery($xpath, 'xpath');
  $qr = $q->execute();
  $nodes = $qr->getNodes();
  
  while(java_values($nodes->hasNext())) {
    $node = $nodes->nextNode();
    echo "<h1>". $node->getProperty('myhippoproject:title')->getString() ."</h1>\n";
    echo "<div><em>". $node->getProperty('myhippoproject:summary')->getString() ."</em></div>\n";
    echo "<div>". $node->getNode('myhippoproject:body')->getProperty('hippostd:content')->getString() ."</div>\n";
  }
}
?>
