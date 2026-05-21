@include('dashboard.posts.create',[
'posts' =>$post,
'action'=>route('posts.update', $post->id),
'method'=>'PUT'
])