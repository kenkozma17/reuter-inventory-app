<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mb-3">
            <a href="{{url()->previous()}}">< Back</a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$slot}}
        </h2>
    </div>
</header>