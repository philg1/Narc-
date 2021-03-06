<?php

require '../src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '294448483953041',
  'secret' => '287e4669bb9d867f407eee4f40cc4f4c',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($user) { ?>
      Your user profile is
      <pre>
        <?php print htmlspecialchars(print_r($user_profile, true)) ?>
      </pre>
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>

<img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large">
<p>Hey <?php echo $user_profile["name"]; ?></p>
<p>Birthday: <?php echo $user_profile["birthday"]; ?></p>
<p>Email: <?php echo $user_profile["email"]; ?></p>
<p>Location: <?php echo $user_profile["location"]; ?></p>
<p>Work: <?php echo $user_profile["work"]; ?></p>
<p>Hometown: <?php echo $user_profile["hometown.name"]; ?></p>
<p>Education: <?php echo $user_profile["education"]; ?></p>
<p>Gender: <?php echo $user_profile["gender"]; ?></p>
<p>Message: <?php echo $user_profile["message"]; ?></p>
<p>Data: <?php echo $user_profile["data"]; ?></p>


    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
</html>
