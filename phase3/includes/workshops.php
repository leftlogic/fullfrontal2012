<article id="workshops">
  <h2>Workshops</h2>

  <?php 
  $workshopData = array();
  if ($handle = opendir(ROOT . '/data/workshops/')) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
      if (stripos($entry, '.json') !== false) {
        array_push($workshopData, json_decode(file_get_contents(ROOT . '/data/workshops/' . $entry), true));
      }
    }

    closedir($handle);
  }

  echo renderTemplate(array('workshops' => $workshopData), '/includes/workshop.tmpl'); 

  ?>
</article>