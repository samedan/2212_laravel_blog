<x-layout>
<?php

  function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

?>
    <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{ $post->title }}</h2>
        {{-- Pass can Update Policy --}}
        @can('update', $post)
        <span class="pt-2">
          <a href="/post/{{$post->id}}/edit" class="text-primary mr-2" 
            data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <form class="delete-post-form d-inline" 
              action="/post/{{$post->id}}" method="POST">
              @csrf
              @method('DELETE')
                <button class="delete-post-button text-danger" 
                data-toggle="tooltip" data-placement="top" 
                title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </span>
        @endcan

      </div>

      <p class="text-muted small mb-4">
        <a href="#">
          {{-- //  $view_variable = $post->user_id; ?>

          //  console_log($view_variable); ?> --}}
          {{-- <img class="avatar-tiny" src="{{$post->user->avatar}}" /> --}}
          {{-- <img class="avatar-tiny" src="{{$avatar}}" /> --}}
        </a>
        {{-- 'getUserData' function on the 'User' model loads the 'user' and spits the 'username' --}}
        Posted by <a href="#">{{ $post->getUserData->username }}</a> on {{ $post->created_at->format('n/j/Y') }}
      </p>

      <div class="body-content">
        {{-- show/render HTML --}}
        {!! $post->body !!}
      </div>
    </div>

</x-layout>
