<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Website Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-blue-100 via-white to-purple-100 p-6">

  <div class="w-full max-w-5xl bg-white/70 backdrop-blur-xl rounded-xl shadow-2xl p-10 space-y-12 border border-gray-200">
    <div class="text-center">
      <h1 class="text-4xl font-extrabold text-gray-800 mb-3">⚙️ Website Settings</h1>
      <p class="text-gray-600 text-sm">Update website information, logo, status, and more.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
      @csrf

      {{-- Section 1: Basic Information --}}
      <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-700 border-b pb-2">🌐 Basic Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Website Name</label>
            <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name) }}" class="input" placeholder="Website name...">
          </div>

          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">SEO Keywords</label>
            <input type="text" name="keywords" value="{{ old('keywords', $settings->keywords) }}" class="input" placeholder="Keywords...">
          </div>

          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Website Logo</label>
            <input type="file" name="logo" class="file-input">
          </div>

          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Favicon</label>
            <input type="file" name="favicon" class="file-input">
          </div>

          <div class="col-span-1 md:col-span-2">
            <label class="text-sm font-medium text-gray-600">Website Description</label>
            <textarea name="site_description" rows="4" class="input" placeholder="Short description of the website...">{{ old('site_description', $settings->site_description) }}</textarea>
          </div>
        </div>
      </div>

      {{-- Section 2: Contact Information --}}
      <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-700 border-b pb-2">📞 Contact Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" value="{{ old('email', $settings->email) }}" class="input" placeholder="Contact email...">
          </div>

          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone', $settings->phone) }}" class="input" placeholder="Phone number...">
          </div>

          <div class="col-span-1 md:col-span-2">
            <label class="text-sm font-medium text-gray-600">Address</label>
            <input type="text" name="address" value="{{ old('address', $settings->address) }}" class="input" placeholder="Business address...">
          </div>

          <div class="col-span-1 md:col-span-2">
            <label class="text-sm font-medium text-gray-600">Business Information</label>
            <textarea name="business_info" rows="3" class="input" placeholder="Business introduction...">{{ old('business_info', $settings->business_info) }}</textarea>
          </div>
        </div>
      </div>

      {{-- Section 3: System Settings --}}
      <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-700 border-b pb-2">🛠️ System Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <div>
            <label class="text-sm font-medium text-gray-600 block mb-2">Website Mode</label>
            <div class="flex items-center gap-6">
              <label class="flex items-center gap-2">
                <input type="radio" name="maintenance_mode" value="0" {{ !$settings->maintenance_mode ? 'checked' : '' }} class="radio">
                <span>Active</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" name="maintenance_mode" value="1" {{ $settings->maintenance_mode ? 'checked' : '' }} class="radio">
                <span>Maintenance</span>
              </label>
            </div>
          </div>

          <div>
            <label class="text-sm font-medium text-gray-600 block mb-2">Website Type</label>
            <div class="flex items-center gap-6">
              <label class="flex items-center gap-2">
                <input type="radio" name="site_type" value="full" {{ $settings->site_type == 'full' ? 'checked' : '' }} class="radio">
                <span>Full (With Shopping Cart)</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" name="site_type" value="simple" {{ $settings->site_type == 'simple' ? 'checked' : '' }} class="radio">
                <span>Simple</span>
              </label>
            </div>
          </div>

        </div>
      </div>

      {{-- Save Button --}}
      <div class="text-center">
        <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full shadow-md transition-all">
          💾 Save Changes
        </button>
      </div>

    </form>
  </div>

  <style>
    .input {
      @apply border border-gray-300 bg-white/70 rounded-lg px-4 py-2 text-sm placeholder-gray-400 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition;
    }

    .file-input {
      @apply block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100;
    }

    .radio {
      @apply w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 rounded-full;
    }
  </style>

</body>
</html>
