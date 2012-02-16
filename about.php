<?php
echo "<pre>This is about.php\n</pre>";

require_once("../java/Java.inc");

// Get the context
$context = java_context();
$servlet = $context->getServlet();
$request = $context->getHttpServletRequest();
$response = $context->getHttpServletResponse();

// The document is a org.example.beans.TextDocument (a HippoBean). This is provided by the org.example.components.Detail component.
$document = $request->getAttribute('document');

echo "<div id='about'>\n";
echo "<h2 class='title'>$document->title</h2>\n";
echo "<p class='intro'>$document->summary</p>\n";

// Execute this tag on the html part: <hst:html var="html" hippohtml="${document.html}"/>
$factory = new Java("org.apache.jasper.runtime.JspFactoryImpl");
$pageContext = $factory->getPageContext($servlet, $request, $response, null, true, 2048, false);

$tag = new Java('org.hippoecm.hst.tag.HstHtmlTag');
$tag->setPageContext($pageContext);
$tag->setVar('html');
$tag->setHippohtml($document->html);
$tag->doStartTag();
$tag->doEndTag();

echo $pageContext->getAttribute('html');
echo "</div>\n";
?>

