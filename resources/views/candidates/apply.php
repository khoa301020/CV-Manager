<?php
if (!isset($_SESSION['user'])) {
  redirect("");
}

//Check Pending

require_once './app/Models/CVModel.php';

if ((new CVModel)->checkIfPendingCVExists($_SESSION['user_id'])) : ?>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Welcome, <?php echo $_SESSION['name']; ?></h3>
      <h4 class="text-2xl font-bold text-center">You have a pending CV, please wait for the result</h4>
      <!-- logout -->
      <div class=" flex-auto float-right mt-4">
        <a href="../../../app/Http/Controllers/UserController.php?q=logout" class="text-sm text-red-600 hover:underline">Logout</a>
      </div>
    </div>
  </div>

<?php else :

  require './app/Models/PositionModel.php';

  $positions = (new PositionModel())->getAllPositions();

?>

  <!-- CV upload form -->
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Welcome, <?php echo $_SESSION['name']; ?></h3>
      <!-- logout -->
      <div class=" flex-auto float-right">
        <a href="../../../app/Http/Controllers/UserController.php?q=logout" class="text-sm text-red-600 hover:underline">Logout</a>
      </div>
      <form action="../../../app/Http/Controllers/CVController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" value="sendCV">

        <div class="mt-4">
          <label class="block">Position<label>
              <select name="position" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                <?php foreach ($positions as $position) : ?>
                  <option value="<?php echo $position->position_id; ?>"><?php echo $position->position_name; ?></option>
                <?php endforeach; ?>
              </select>
        </div>
        <div class="mt-4">
          <div>
            <label class="block">CV<label>
                <input type="file" name="cv_file" placeholder="CV" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
                <div class="text-xs text-red-600">*Max size 4MB</div>
          </div>
        </div>
        <div class="flex items-baseline justify-between">
          <button type="submit" class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900" style="margin-left: auto; margin-right: auto;">Submit</button>
        </div>
      </form>
    </div>
  </div>

<?php endif; ?>