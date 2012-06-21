<?php
  require('mustache.php');
  require('markdown.php');
  $mustache = new Mustache;

  function convertMarkdown(&$array) {
    // Credit: http://www.php.net/manual/en/function.array-walk.php#71901
    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $res[$key] = convertMarkdown(&$value);
      } else {
        if (array_pop(explode('_', $key)) == 'md') {
          $res[$key] = Markdown($value);
        } else {
          $res[$key] = $value;
        }
      }
    }
    return $res;
  }

  function renderTemplate($data, $template, $markdown) {
    global $mustache;
    // TODO validate the file exists - and error handle properly
    $data = convertMarkdown(json_decode(file_get_contents($data), true));
    $view = file_get_contents($template);
    $render = $mustache->render($view, $data);
    return $render;
  }
?>
<!DOCTYPE html> 
<html class="noJS">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full Frontal 2012 - JavaScript Conference</title>
  
  <script>
    document.documentElement.className = '';
  </script>

  <link rel="stylesheet" href="/fullfrontal.css">
  <link rel="shortcut icon" href="/favicon.ico">
  
  <!--[if lt IE 9]>
    <script>
      (function(g,b){function k(){var a=e.elements;return"string"==typeof a?a.split(" "):a}function l(a){var c={},f=a.createElement,b=a.createDocumentFragment,d=b();a.createElement=function(a){if(!e.shivMethods)return f(a);var b;b=c[a]?c[a].cloneNode():m.test(a)?(c[a]=f(a)).cloneNode():f(a);return b.canHaveChildren&&!n.test(a)?d.appendChild(b):b};a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+k().join().replace(/\w+/g,function(a){f(a);
      d.createElement(a);return'c("'+a+'")'})+");return n}")(e,d)}function h(a){var c;if(a.documentShived)return a;if(e.shivCSS&&!i){c=a.createElement("p");var b=a.getElementsByTagName("head")[0]||a.documentElement;c.innerHTML="x<style>article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}</style>";c=!!b.insertBefore(c.lastChild,b.firstChild)}j||(c=!l(a));if(c)a.documentShived=c;return a}var d=g.html5||{},n=/^<|^(?:button|form|map|select|textarea|object|iframe|option|optgroup)$/i,
      m=/^<|^(?:a|b|button|code|div|fieldset|form|h1|h2|h3|h4|h5|h6|i|iframe|img|input|label|li|link|ol|option|p|param|q|script|select|span|strong|style|table|tbody|td|textarea|tfoot|th|thead|tr|ul)$/i,i,j;(function(){var a=b.createElement("a");a.innerHTML="<xyz></xyz>";i="hidden"in a;if(!(a=1==a.childNodes.length))a:{try{b.createElement("a")}catch(c){a=!0;break a}a=b.createDocumentFragment();a="undefined"==typeof a.cloneNode||"undefined"==typeof a.createDocumentFragment||"undefined"==typeof a.createElement}j=
      a})();var e={elements:d.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:!1!==d.shivCSS,shivMethods:!1!==d.shivMethods,type:"default",shivDocument:h};g.html5=e;h(b)})(this,document);
  </script>
  <![endif]-->

</head>

<!--[if IE 8]><body class="ie"><![endif]-->
<!--[if gt IE 8]><body><![endif]-->
<!--[if !IE]><!--><body><!--<![endif]-->

<div id="dressing-gown">

  <header>
    <div class="ponch"></div><div class="chips"></div><!-- know your TV cop characters -->
    <div class="wrapper">

      <nav>
        <ul>
          <li><a href="#speakers">Speakers</a></li>
          <li><a href="#schedule">Schedule</a></li>
          <li><a href="#workshops">Workshops</a></li>
          <li><a href="#locations">Locations</a></li>
          <li><a href="#fringe">Fringe</a></li>
          <li><a href="#sponsors">Sponsors</a></li>
        </ul>

        <span id="show-menu">Pull down to show menu&hellip;</span>
      </nav>

      <img class="logo" src="/images/logo.png" width="140" height="130" alt="Full Frontal">
      
      
      <h1>
        <time datetime="2012-11-09T09:00">09/11/12</time>
        <span>Full Frontal 2012
          <span hidden>
            <!-- Force the above line to justify -->
            It's the best JavaScript conference ever, justfiyable hackable
          </span>
        <span>
      </h1>
      
      <a class="button buy-tickets" href="#">
        <span class="buy">Buy</span> Tickets
        <span class="price"><img src="/images/pound-symbol.gif" alt="&pound;">250</span>
      </a>

    </div>
  </header>

  <div class="main"><div class="wrapper">
    
    <p class="lede vevent">
      <strong class="summary">Full Frontal 2012</strong> is a one day
      <br class="superflous-br"><strong>JavaScript Conference</strong> 
      <br>at the <span class="location">Duke of York&rsquo;s Picturehouse
      <br class="extra-br">in Brighton, UK </span>
      <br>on the <time class="dtstart" title="2012-11-09T09:00" datetime="2012-11-09T09:00">
        <strong>9th November 2012</strong>
      </time>
    </p>

    <hr>

    <?php require('includes/schedule.php'); ?>

    <hr>

    <?php require('includes/speakers.php'); ?>

    <hr>

    <?php require('includes/workshops.php'); ?>

    <hr>

    <?php require('includes/locations.php'); ?>

    <hr>

    <?php require('includes/fringe.php'); ?>

    <hr>

    <?php require('includes/sponsors.php'); ?>

    <hr>

  </div></div>

  <footer>
    <div class="date-twitter">
      <time class="date" datetime="2012-11-09T09:00"><strong>09<span>/</span>11<span>/</span>12</strong></time>
      <a class="twitter" href="https://twitter.com/fullfrontalconf" title="Follow Full Frontal on Twitter">@fullfrontalconf</a>
    </div>
    <p class="previous">
      Previous years<br>
      <a href="http://2011.full-frontal.org/">2011</a>,
      <a href="http://2010.full-frontal.org/">2010</a>,
      <a href="http://2009.full-frontal.org/">2009</a>
    </p>
    <a class="left-logic" href="http://leftlogic.com">Left Logic</a>
  </footer>

</div>

  <script>
    //if (!location.hash) document.getElementById('show-menu').scrollIntoView();
  </script>
  
  <script src="/js/jquery.js"></script>
  <script src="/js/jquery-ui.js"></script>

  <script src="http://maps.googleapis.com/maps/api/js?&amp;sensor=false"></script>
  <script src="http://maps.stamen.com/js/tile.stamen.js"></script>
  <script src="/js/fullfrontal.js"></script>
  <script>
    // // Google Analytics
    // var _gaq = _gaq || [], d = document, n = 'className', g = 'getElementById', i = 'time';
    // _gaq.push(['_setAccount', 'UA-1656750-25']);
    // _gaq.push(['_trackPageview']);
    // (function() {
    //   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    //   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    // })();
  </script>

</body> 
</html>