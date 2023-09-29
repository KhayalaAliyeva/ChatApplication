@extends('layouts.app')

@section('content')

<div id="app">
  <div class="row chat-row">
    <users-list :users="{{ $users }}"></users-list>

    <div class="col-md-9">
      <h1>Message Section</h1>
      <p class="lead">
        Select a user from the list to begin a conversation.
      </p>
    </div>
  </div>
</div>
@endsection
@push("scripts")
<script>

    $(function(){
        let user_id='{{auth()->user()->id}}';
        let ip_address="127.0.0.1";
        let socket_port='8005';
        let socket=io(ip_address+":"+ socket_port);
        socket.on('connect', function(){
            socket.emit("user-connected",user_id);
        });
        socket.on('updateUserStatus',(data)=>{
            $.each(data, function(key, val){

                if (val === null) {
                    console.log(key);
                    let $userIcon = $(".user-icon-" + key);
                    $userIcon.removeClass("text-success");
                    $userIcon.attr("title", "Offline");
                } else {
                    console.log(key + ' is online');
                    let $userIcon = $(".user-icon-" + key);
                    $userIcon.addClass("text-success");
                    $userIcon.attr("title", "Online");
                }
            });
        });
    });
</script>
@endpush
