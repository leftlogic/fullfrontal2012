<article id="locations">
  <h2>Locations</h2>

  <section class="locations">
    <h3>Conference</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.8336812,-0.1388816">
        <span class="address">Preston Circus, BN1 4BA</span>
        <a href="#"><span class="bullet">A.</span>Duke of York's Picturehouse</a>
        <p class="details">
          Full Frontal JavaScript Conference is being held at the historic
          Duke of York's Picturehouse in Brighton. It is centrally located on Preston Circus.
        </p>
      </li>
    </ul>

    <h3>Workshops</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.825828322287116, -0.13845831155776978">
        <span class="address">28 Kensington Street, BN1 4AJ</span>
        <a href="http://goo.gl/maps/GTYX"><span class="bullet">B.</span>Lighthouse</a>
        <p class="details">
          If you've signed up to one of our workshops, this is where they're run.
        </p>
      </li>
    </ul>


    <h3>(Unofficial) Pre Party</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.8254504924097, -0.13727009296417236">
        <span class="address">101 North Road, BN1 1YE</span>
        <a href="http://goo.gl/maps/6FH8"><span class="bullet">C.</span>Fountain Head</a>
        <p class="details">
          We've reserved some tables and spots, so come down from 7pm onwards and say 'hi' to your fellow <em>Full-Frontal-goer</em>!
        </p>
      </li>
    </ul>

    <h3>After Party</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.82181097001707,-0.14180302619934082">
        <span class="address">Preston Circus, BN1 4BA</span>
        <a href="#"><span class="bullet">B.</span>The Loft</a>
        <p class="details">
          Please join us at the Full Frontal After Party at The Loft from 7pm until late
        </p>
      </li>
    </ul>
  </section>

  <div id="map"></div>

  <section class="locations">
    <h3>Hotels</h3>
    <ul>
      <?php echo renderTemplate('/data/locations/hotels.json', '/includes/location.tmpl'); ?>
    </ul>

    <h3>Food &amp Drink</h3>
    <ul>
      <?php echo renderTemplate('/data/locations/food.json', '/includes/location.tmpl'); ?>
    </ul>
  </section>

</article>