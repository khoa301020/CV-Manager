<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Implement Tailwind CSS -->
  <link href="./resources/css/styles.css" rel="stylesheet">
  <title>Login Page</title>
</head>

<body>

  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Login to your account</h3>
      <form action="">
        <div class="mt-4">
          <div>
            <label class="block" for="email">Username<label>
                <input type="text" placeholder="Username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
          </div>
          <div class="mt-4">
            <label class="block">Password<label>
                <input type="password" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
          </div>
          <!-- Login button & Forgot password? -->
          <div class="flex items-baseline">
            <button class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Login</button>
            <!-- Register button -->
          </div>
          <div class="flex items-baseline justify-between mt-4">
            <a href="/register" class="text-sm text-blue-600 hover:underline">Don't have an account?</a>
            <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
          </div>
      </form>
    </div>
</body>

</html>