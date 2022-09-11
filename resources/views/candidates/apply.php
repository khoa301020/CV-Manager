<!-- CV upload form -->
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
    <div class="flex justify-center mb-4">
      <a href="http://cvmanager.test/">
        <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
      </a>
    </div>
    <h3 class="text-2xl font-bold text-center">Welcome, <?php if (isset($_SESSION['name'])) {
                                                          echo explode(" ", $_SESSION['name'])[0];
                                                        } else {
                                                          echo 'Guest';
                                                        }
                                                        ?> </h3>
    <!-- logout -->
    <div class=" flex-auto float-right">
      <a href="../../../app/Http/Controllers/UserController.php?q=logout" class="text-sm text-red-600 hover:underline">Logout</a>
    </div>
    <form action="" method="POST">
      <div class="mt-4">
        <label class="block">Position<label>
            <select class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="dunno">Secret</option>
            </select>
      </div>
      <div class="mt-4">
        <div>
          <label class="block">CV<label>
              <input type="file" placeholder="CV" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
        </div>
      </div>
      <div class="flex items-baseline justify-between">
        <button class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900" style="margin-left: auto; margin-right: auto;">Submit</button>
      </div>
    </form>
  </div>
</div>