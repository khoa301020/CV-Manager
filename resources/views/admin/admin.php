<?php
if (!isset($_SESSION['admin'])) {
    redirect("");
}

require './app/Models/CVModel.php';
require './app/Models/PositionModel.php';
require './app/Models/UserModel.php';

// Check row count of CVs

if ((new CVModel())->getAllCVs()) :
    $cvs = (new CVModel())->getAllCVs(); ?>

  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Welcome, <?php echo $_SESSION['name']; ?></h3>
      <div class="table w-screen p-4">
        <table class="w-full border text-center">
          <thead>
            <tr class="bg-gray-100 border-b">
              <th class="p-3">CV ID</th>
              <th class="p-3">User</th>
              <th class="p-3">Position</th>
              <th class="p-3">CV</th>
              <th class="p-3">Status</th>
              <th class="p-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cvs as $cv) : ?>
              <tr class="border-b">
                <td class="p-3"><?php echo $cv->cv_id; ?></td>
                <td class="p-3"><?php
                                echo (new UserModel())->getUserById($cv->user_id)->name;
                ?></td>
                <td class="p-3"><?php
                                echo (new PositionModel())->getPositionById($cv->position_id)->position_name;
                ?></td>
                <td class="p-3">
                  <img class="w-32" src="<?php echo $cv->cv_file; ?>" alt="">
                </td>
                <td class="p-3"><?php echo $cv->review_status; ?></td>
                <!-- Actions -->
                <td class="p-3">

                  <button onclick=<?php
                                  echo ("window.open('http://cvmanager.test/" . explode("..", $cv->cv_file)[3] . "'); return false;") ?> class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 w-full rounded">Review</button>
                  <form action="../../../app/Http/Controllers/CVController.php" method="post">
                    <input type="hidden" name="type" value="approveCV">
                    <input type="hidden" name="id" value=<?php echo $cv->cv_id ?>>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 w-full rounded">Approve</button>
                  </form>
                  <form action="../../../app/Http/Controllers/CVController.php" method="post">
                    <input type="hidden" name="type" value="rejectCV">
                    <input type="hidden" name="id" value=<?php echo $cv->cv_id ?>>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 w-full rounded">Reject</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- logout -->
      <div class=" flex-auto float-right mt-4">
        <a href="../../../app/Http/Controllers/UserController.php?q=logout" class="text-sm text-red-600 hover:underline">Logout</a>
      </div>
    </div>
  </div>

<?php else : ?>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Welcome, <?php echo $_SESSION['name']; ?></h3>
      <h4 class="text-2xl font-bold text-center">No CVs found</h4>
      <!-- logout -->
      <div class=" flex-auto float-right mt-4">
        <a href="../../../app/Http/Controllers/UserController.php?q=logout" class="text-sm text-red-600 hover:underline">Logout</a>
      </div>
    </div>
  </div>
<?php endif; ?>