@extends('layouts.index')
@section('content')
    <div>
        <form class="w-[50%]" action="{{ Route('songStore') }}" method="POST">
            <div class="mb-5">
                <label for="nameSong" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name Song</label>
                <input type="text" name="nameSong" id="nameSong"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Name Song" required />
            </div>

            <div class="mb-5">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option genre</label>
                <select name="genreId" id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
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
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option album</label>
                <select name="albumId" id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a album</option>
                    <option value="">Null</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImage">Upload
                    file (MP3). </label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fileSong" type="file">
                <input type="text" name="songUrl" hidden id="songUrl">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImage">Upload
                    file Avartar song</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="fileImage" type="file">
                <input type="text" name="avatarUrl" hidden id="avatarUrl">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                    800x400px).</p>
            </div>
            <div class="mb-5">
                <img class="rounded-full w-20 h-20 avatarSong invisible" src="">
            </div>
            <div class="mb-5">
                <label for="lyrics" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Song
                    lyrics</label>
                <textarea id="lyrics" rows="4" name="lyrics"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."></textarea>

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
                            numDownloads
                        </th>
                        <th scope="col" class="px-6 py-3">
                            GENRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ARTIST
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ALBUM
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
                    @foreach ($songs as $song)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $song->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $song->name }}
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <img class="rounded-full w-10 h-10 avatarGenres"
                                        src="http://localhost:8000/storage/{{ $song->avatarUrl }}">
                                </div>

                            </td>
                            <td class="px-6 py-4">
                                {{ $song->numPlay }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $song->numDownloads }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $song->genre->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $song->artist->name }}
                            </td>
                            <td class="px-6 py-4 w-[100px]">
                                {{ $song->album->name }}
                            </td>
                            <td class="px-6 py-4">
                                <audio controls>
                                    <source src="http://localhost:8000/storage/{{ $song->songUrl }}" type="audio/mpeg">
                                
                                  </audio>
                            </td>
                            
                            <td class="px-6 py-4 ">
                                <button class="h-[100%] w-[100%] group" id="{{ $song->id }}"><i
                                        class="fa-solid fa-square-xmark group-hover:text-red-500 text-2xl"></i></button>

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>


    </div>
    <script type="module" src="/build/assets/js/song.js"></script>
@endsection
