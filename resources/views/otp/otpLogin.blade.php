<h2>Login Here</h2>
@if (session('error'))
    <div style="color: red"> {{session('error')}}</div>
@endif
<form action="{{ route('otpgenerate')}}" method="POST">
    @csrf
    <input type="text" name="mobile_no" placeholder="Enter your number " value="{{old('mobile_no')}}">
    <br>
    @error('mobile_no')
    <strong style="color: red">{{$message}}</strong>
    @enderror <br>
    <button type="submit">OTP generate</button>

</form>