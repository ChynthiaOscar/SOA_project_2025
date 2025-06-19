<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event Menus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-6xl mx-auto border rounded-3xl p-6 bg-white">
    <h1 class="text-3xl font-bold text-center mb-10">EVENT MENUS</h1>

    <div class="space-y-12">

      <!-- Appetizer Section -->
      <div>
        <h2 class="text-2xl font-semibold mb-4">Appetizer</h2>
        <div class="flex space-x-6 overflow-x-auto pb-2">
          <!-- 7 Appetizers -->
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Dumplings" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Dumplings</h3>
              <p class="text-sm text-gray-600">Steamed meat dumplings</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 17K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/steamed_buns.png') }}" alt="Steamed Buns" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Mini Steamed Buns</h3>
              <p class="text-sm text-gray-600">Soft buns with chicken filling</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 16K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Spring Rolls" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Spring Rolls</h3>
              <p class="text-sm text-gray-600">Crispy veggie rolls</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 14K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/steamed_buns.png') }}" alt="Tofu Bites" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Tofu Bites</h3>
              <p class="text-sm text-gray-600">Fried tofu with dip</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 13K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Seaweed Salad" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Seaweed Salad</h3>
              <p class="text-sm text-gray-600">Chilled seasoned seaweed</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 15K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/steamed_buns.png') }}" alt="Chicken Satay" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Chicken Satay</h3>
              <p class="text-sm text-gray-600">Grilled skewers with sauce</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 18K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Mini Wontons" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Mini Wontons</h3>
              <p class="text-sm text-gray-600">Soup wontons</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 15K</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Course Section -->
      <div>
        <h2 class="text-2xl font-semibold mb-4">Main Course</h2>
        <div class="flex space-x-6 overflow-x-auto pb-2">
          <!-- 7 Main Course -->
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/charsiu.png') }}" alt="Char Siu" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Char Siu</h3>
              <p class="text-sm text-gray-600">BBQ pork with rice</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 30K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/egg fried rice.png') }}" alt="Egg Fried Rice" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Egg Fried Rice</h3>
              <p class="text-sm text-gray-600">Fried rice with egg</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 25K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/braised pork belly.png') }}" alt="Braised Pork Belly" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Braised Pork Belly</h3>
              <p class="text-sm text-gray-600">Slow-cooked pork with sauce</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 35K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/charsiu.png') }}" alt="Sweet & Sour Pork" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Sweet & Sour Pork</h3>
              <p class="text-sm text-gray-600">Pork with tangy sauce</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 32K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/egg fried rice.png') }}" alt="Yangzhou Fried Rice" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Yangzhou Fried Rice</h3>
              <p class="text-sm text-gray-600">Mix of meats and peas</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 28K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/braised pork belly.png') }}" alt="Mapo Tofu" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Mapo Tofu</h3>
              <p class="text-sm text-gray-600">Spicy tofu with minced pork</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 27K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/egg fried rice.png') }}" alt="Chicken Chow Mein" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Chicken Chow Mein</h3>
              <p class="text-sm text-gray-600">Stir-fried noodles with chicken</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 29K</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Dessert Section -->
      <div>
        <h2 class="text-2xl font-semibold mb-4">Dessert</h2>
        <div class="flex space-x-6 overflow-x-auto pb-2">
          <!-- 7 Desserts -->
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/steamed_buns.png') }}" alt="Red Bean Bun" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Red Bean Bun</h3>
              <p class="text-sm text-gray-600">Sweet bun with red bean paste</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 15K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/egg fried rice.png') }}" alt="Egg Tart" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Egg Tart</h3>
              <p class="text-sm text-gray-600">Creamy egg custard tart</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 18K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Mango Pudding" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Mango Pudding</h3>
              <p class="text-sm text-gray-600">Chilled mango dessert</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 16K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/charsiu.png') }}" alt="Fried Milk" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Fried Milk</h3>
              <p class="text-sm text-gray-600">Sweet fried custard cubes</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 17K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/steamed_buns.png') }}" alt="Sesame Balls" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Sesame Balls</h3>
              <p class="text-sm text-gray-600">Glutinous rice with sesame</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 15K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/braised pork belly.png') }}" alt="Almond Jelly" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Almond Jelly</h3>
              <p class="text-sm text-gray-600">Chilled almond-flavored jelly</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 14K</p>
            </div>
          </div>
          <div class="min-w-[220px] bg-white shadow-md rounded-xl overflow-hidden border">
            <img src="{{ asset('images/dumplings.png') }}" alt="Lychee Ice" class="h-48 w-full object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold">Lychee Ice</h3>
              <p class="text-sm text-gray-600">Icy dessert with lychee</p>
              <p class="text-sm font-semibold text-red-600 mt-1">IDR 13K</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
