<div class="list-group">
  @foreach($posts as $post)
  {{-- hideAuthor comes from post.blade.php --}}
  <x-post :post="$post" hideAuthor/> 
  @endforeach
</div>
