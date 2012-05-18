<?php
  $thanks = false;
  $error = false;
  $email = '';

  function validEmail($e) {
    return (preg_match("/^([_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))$/", $e));
  }

  if (isset($_POST['email']) && $_POST['email'] && validEmail($_POST['email'])) {
    $email = $_POST['email'];
    $fp = fopen('emails.txt', 'a+');
    fwrite($fp, $email . "\n");
    fclose($fp);
    $thanks = true;
  } elseif (isset($_POST['email'])) {
    $error = true;
  } 
?>
<!DOCTYPE html> 
<html class="noJS">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full Frontal 2012 - JavaScript Conference</title>
  
  <link rel="stylesheet" href="fullfrontal.css">
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

<!--[if IE 8]><body class="ie <?= $thanks || $error ? ' submitted' : '' ?>"><![endif]-->
<!--[if gt IE 8]><body<?= $thanks || $error ? ' class="submitted"' : '' ?>><![endif]-->
<!--[if !IE]><!--><body<?= $thanks || $error ? ' class="submitted"' : '' ?>><!--<![endif]-->

  <header>
    <div class="ponch"></div><div class="chips"></div><!-- know your TV cop characters -->
    <div class="wrapper">
      <img class="logo" src="/images/logo.png" width="140" height="130" alt="Full Frontal">
      <p>tickets go live&hellip;</p>
      <time id="countdown" datetime="2012-07-02T10:00:00+01:00">
        <div class="days">
          <span class="value">02</span>
          <span class="label">days</span>
        </div>
        <div class="hour">
          <span class="value">ND</span>
          <span class="label">hour</span>
        </div>
        <div class="mins">
          <span class="value">JU</span>
          <span class="label"><abbr title="minutes">mins</abbr></span>
        </div>
        <div class="secs">
          <span class="value">LY</span>
          <span class="label"><abbr title="seconds">secs</abbr></span>
        </div>
      </time>
    </div>
  </header>

  <div class="main"><div class="wrapper">
    <p class="lede vevent">
      <strong class="summary">Full Frontal 2012</strong> is a one day <strong>JavaScript Conference</strong> 
      <br>at the <span class="location">Duke of York&rsquo;s Picturehouse in Brighton, UK </span>
      <br>on the <time class="dtstart" title="2012-11-09T09:00" datetime="2012-11-09T09:00">
        <strong>9th November 2012</strong>
      </time>
    </p>

    <div class="tabs">
      <section class="tab-content tab-register">
        <a href="#register" class="tab <?= $thanks || $error ? ' tab-selected' : '' ?>">
          <h2>Register your interest</h2>
        </a>
        <div id="register" class="wrapper">
          <?php if ($thanks) : ?>
            <p>Thank you for registering your interest in Full Frontal 2012</p>
          <?php else: ?>
            <p>
              Give us your email address* and we&rsquo;ll keep you up to date with all of
              the latest news about Full Frontal, including ticket release, speakers and more.
            </p>
            <?php if ($error) : ?>
              <p class="error">There was an error collecting your email address, please try again.</p>
            <?php endif; ?>
            <form class="register-interest" action="/" method="post">
                <input type="email" name="email" placeholder="ecm@script.com" required <?php echo isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : ''; ?>>
                <button type="submit">Register</button>
            </form>
            <small>* We wont share your email address with anyone. Promise.</small>
          <?php endif; ?>
        </div>
      </section>

      <section class="tab-content tab-talk">
        <a href="#talk" class="tab"><h2>Propose a talk/speaker</h2></a>
        <div id="talk" class="wrapper">
          <p>
            Want to speak at Full Frontal 2011? We'd love to give you the platform
            to speak to hundreds of developers and designers, so what are you waiting for,
            <a href="mailto:events@leftlogic.com?subject=FF2012%20Speaking%20Proposal">get in touch!</a>
          </p>
          <p>Here are some topics Remy would love to hear at this years conference - and if yours isn't one of these - that's cool too!</p>
          <p><em>
            Browser testing &amp; debugging for all browsers (and beyond inspector). 
            Is HTML dead? 
            What does the future hold for JavaScript outside of the Web? 
            WebGL - what tha' hell! 
            Maths is cool - we should have paid more attention in school.
          </em></p>
        </div>
      </section>

      <section class="tab-content tab-sponsor">
        <a href="#sponsor" class="tab"><h2>Become a <br> sponsor</h2></a>
        <div id="sponsor" class="wrapper">
          <p>
            Find out how your company can sponsor Full Frontal by reviewing our
            <a href="/sponsorship.html">sponsorship packages</a> and
            <a href="mailto:events@leftlogic.com?subject=FF2012%20Sponsorship">get in touch</a>
            with us to discuss how we can work together.
          </p>
        </div>
      </section>

    </div>

    <div class="date-twitter">
      <time class="date" datetime="2012-11-09T09:00"><strong>09.11.12</strong></time>
      <a class="twitter" href="https://twitter.com/fullfrontalconf" title="Follow Full Frontal on Twitter">@fullfrontalconf</a>
    </div>

  </div></div>

  <footer>
    <p class="previous">
      Previous years<br>
      <a href="http://2011.full-frontal.org/">2011</a>,
      <a href="http://2010.full-frontal.org/">2010</a>,
      <a href="http://2009.full-frontal.org/">2009</a>
    </p>
    <a class="left-logic" href="http://leftlogic.com">Left Logic</a>
  </footer>

  <script src="/js/jquery.js"></script>
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