@extends('layouts.index')
@section('content')
    <div class="flex">
        <form class="w-[35%]" action="{{ Route('albumStore') }}" method="POST">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name album</label>
                <input type="text" name="nameAlbum"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Name Album" required />
            </div>
            <div class="mb-5">


                <label for="artistId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    artist</label>
                <select name="artistId" id="artistId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Chọn ca sĩ</option>
                    @foreach ($artists as $artist)
                         
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option> 
                    @endforeach
                </select>

            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImage">Upload
                    file</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fileImage" type="file">
                <input type="text" name="avatarUrl" hidden id="avatarUrl">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                    800x400px).</p>
            </div>
            <div class="mb-5">
                <img class="rounded-full w-32 h-32 avatarGenres invisible" src="">
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            @csrf
        </form>


        <div class="overflow-x-auto w-[65%] ml-6">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            AVATAR
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Artist</th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Option
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($listAlbums as $listAlbum)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$listAlbum->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$listAlbum->name}}
                        </td>
                        
                        <td class="px-6 py-4">
                            <div>
                                <img class="rounded-full w-10 h-10 avatarGenres" src="http://localhost:8000/storage/{{$listAlbum->avatarUrl}}">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{$listAlbum->artist->name}}
                        </td>
                        <td class="px-6 py-4 ">
                            <button class="h-[100%] w-[100%] group" id="{{$listAlbum->id}}"><i class="fa-solid fa-square-xmark group-hover:text-red-500 text-2xl"></i></button>
                        </td>
                    </tr>
                @endforeach


            </tbody>
            </table>
        </div>


    </div>

    <script type="module" src="/build/assets/js/album.js"></script>
@endsection
