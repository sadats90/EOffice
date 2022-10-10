<html>
    <form action="{{url('/store') }}" method="Post">
        @csrf

        <label for="Name">Name</label>
        <input type="text" name="name">

        <label for="detail">Detail</label>
        <input type="text" name="detail">

        <button type="submit"> Add </button>
    </form>

</html>