@extends('layouts.index')
@section('content')
    <div>
        <form class="w-[50%]" action="{{ Route('musicVideoStore') }}" method="POST">
            <div class="mb-5">
                <label for="nameMv" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name Mv</label>
                <input type="text" name="nameMv" id="nameMv"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Name Mv" required />
            </div>


            <div class="mb-5">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option artist</label>
                <select name="artistId" id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a artist</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImage">Upload
                    file (MP4). </label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fileMv" type="file">
                <input type="text" name="mvUrl" hidden id="mvUrl">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImage">Upload
                    file Avartar Music Video</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fileImage" type="file">
                <input type="text" name="avatarUrl" hidden id="avatarUrl">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                    800x400px).</p>
            </div>
            <div class="mb-5">
                <img class="rounded-full w-20 h-20 avatarMv invisible" src="">
            </div>



            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            @csrf
        </form>


        <div class="overflow-x-auto mt-6">
            <table class="text-sm text-center text-gray-500 dark:text-gray-400">
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
                            numPlay
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ARTIST
                        </th>

                        <th scope="col" class="px-6 py-3 text-center">
                           AUDIO
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Option
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($musicVideos as $musicVideo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $musicVideo->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $musicVideo->name }}
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <img class="rounded-full w-10 h-10 avatarGenres"
                                        src="http://localhost:8000/storage/{{ $musicVideo->avatarUrl }}">
                                </div>

                            </td>
                            <td class="px-6 py-4">
                                {{ $musicVideo->numPlay }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $musicVideo->artist->name }}
                            </td>
                            <td class="px-6 py-4">
                                <video controls class="w-[200px] h-[200px] object-cover"
                                    src="http://localhost:8000/storage/{{ $musicVideo->videoUrl }}" type="video/mp4">
                                 
                                </video>
                            
                            </td>
                            
                            <td class="px-6 py-4 ">
                                <button class="h-[100%] w-[100%] group" id="{{ $musicVideo->id }}"><i
                                        class="fa-solid fa-square-xmark group-hover:text-red-500 text-2xl"></i></button>

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>


    </div>
    <script type="module" src="/build/assets/js/musicvideo.js"></script>
@endsection
