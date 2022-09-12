<?php
if (empty($_GET['selector']) || empty($_GET['validator'])) {
  echo '<p>Could not validate your request!</p>';
} else {
  $selector = $_GET['selector'];
  $validator = $_GET['validator'];

  if (ctype_xdigit($selector) && ctype_xdigit($validator)) : ?>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
        <div class="flex justify-center mb-4">
          <a href="http://cvmanager.test/">
            <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
          </a>
        </div>
        <h3 class="text-2xl font-bold text-center">Set your new password</h3>
        <form action="../../../app/Http/Controllers/ResetPasswordController.php" method="POST">
          <input type="hidden" name="type" value="resetPassword">
          <input type="hidden" name="selector" value="<?php echo $selector ?>" />
          <input type="hidden" name="validator" value="<?php echo $validator ?>" />
          <div class="mt-4">
            <div class="mb-4">
              <label class="block" for="password">Password<label>
                  <input type="password" name="pass" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
              <label class="block" for="confirmPassword">Confirm password<label>
                  <input type="password" name="pass-confirm" placeholder="Confirm password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
            </div>
            <div class="flex items-baseline">
              <button type="submit" class="px-6 py-2 mt-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Set</button>
            </div>
            <div class="flex items-baseline justify-between mt-4">
              <a href="/register" class="text-sm text-blue-600 hover:underline">Don't have an account?</a>
              <a href="/login" class="text-sm text-blue-600 hover:underline">Login</a>
            </div>
        </form>
      </div>
    </div>

  <?php else : ?>
    <p>Could not validate your request!</p>
<?php endif;
} ?>