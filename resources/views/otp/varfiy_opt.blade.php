@if (session('success'))
    <div style="color: green">{{session('success')}}</div>
@endif
@if (session('error'))
    <div style="color: red">{{session('error')}}</div>
@endif
<form action="{{route('otp.getlogin')}}" method="POST">
@csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <label for="">OTP</label><br>
    <input type="text" name="mobile_otp" placeholder="Enter your otp here" value="{{old('mobile_otp')}}">
    <br>
    @error('mobile_otp')
        <strong style="color: red">{{$message}}</strong>
    @enderror
    <button type="submit">verify</button>

</form>