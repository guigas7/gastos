@if (Session::has('success'))
	<flash-message type="success" message="{{ Session::get('success') }}"></flash-message>
@endif

@if (Session::has('danger'))
	<flash-message type="danger" message="{{ Session::get('danger') }}"></flash-message>
@endif

@if (Session::has('warning'))
	<flash-message type="warning" message="{{ Session::get('warning') }}"></flash-message>
@endif

@if($errors->all())
    @foreach ($errors->all() as $error)
      <flash-message type="danger" message="{{ $error }}"></flash-message>
    @endforeach
@endif

<flash-box></flash-box>