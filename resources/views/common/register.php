<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Implement Tailwind CSS -->
  <link href="./resources/css/styles.css" rel="stylesheet">
  <title>Register</title>
</head>

<body>
  <!-- Register form -->
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
      <div class="flex justify-center mb-4">
        <a href="http://cvmanager.test/">
          <img class="fill-current h-full w-32 mr-2" src="https://morsoftware.com/wp-content/themes/mor/assets/images/logo-mor-coloring.svg" alt="">
        </a>
      </div>
      <h3 class="text-2xl font-bold text-center">Create a new account</h3>
      <form action="">
        <div class="mt-4">
          <div>
            <label class="block">Username<label>
                <input type="text" placeholder="Username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
          </div>
          <div class="mt-4">
            <label class="block">Full Name<label>
                <input type="text" placeholder="Full name" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
          </div>
          <div class="mt-4">
            <label class="block">Gender<label>
                <select class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="dunno">Secret</option>
                </select>
          </div>
          <div class="mt-4">
            <label class="block">Email<label>
                <input type="text" placeholder="Email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" required>
          </div>
          <div class="mt-4">
            <label class="block">Phone Number<label>
                <input type="text" placeholder="Phone Number" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="0[0-9]{9}" required>
          </div>
          <div class="mt-4">
            <label class="block">Password<label>
                <input type="password" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
          </div>
          <div class="mt-4">
            <label class="block">Confirm Password<label>
                <input type="password" placeholder="Confirm Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
          </div>
          <div class="flex items-baseline justify-between">
            <button class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Register</button>
            <a href="/login" class="text-sm text-blue-600 hover:underline">Already have an account?</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>