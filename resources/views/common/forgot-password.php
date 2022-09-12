<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
    <div class="flex justify-center mb-4">
      <a href="http://cvmanager.test/">
        <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
      </a>
    </div>
    <h3 class="text-2xl font-bold text-center">Reset your password</h3>
    <form action="../../../app/Http/Controllers/ResetPasswordController.php" method="POST">
      <input type="hidden" name="type" value="sendResetMail">
      <div class="mt-4">
        <div class="mb-4">
          <label class="block">Username<label>
              <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
        </div>
        <div class="mb-4">
          <label class="block">Email<label>
              <input type="text" name="email" placeholder="Email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        </div>
        <div class="mb-4">
          <label class="block">Phone number<label>
              <input type="text" name="phone" placeholder="Phone number" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="0[0-9]{9}" required>
        </div>
        <div class="flex items-baseline">
          <button type="submit" class="px-6 py-2 mt-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Reset</button>
        </div>
        <div class="flex items-baseline justify-between mt-4">
          <a href="/register" class="text-sm text-blue-600 hover:underline">Don't have an account?</a>
          <a href="/login" class="text-sm text-blue-600 hover:underline">Login</a>
        </div>
    </form>
  </div>

</div>