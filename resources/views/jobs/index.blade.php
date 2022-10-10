<html>

<a href="{{url('/create')}}"><button>Add new </button> </a>
 <table>
    <thead>
    <th>Name</th>

    <th>Detail</th>
    <th>Edit</th>
    <th>Delete</th>
</thead>
<tbody>
    @foreach($job as $j)
    <tr>

        <td>{{$j->name}}</td>
        <td>{{$j->detail}}</td>
        <td><a href='{{ url("edit/{$j->id}") }}'><button>Edit</button></a></td>
        <td></td>
    </tr>

    @endforeach
</tbody>
 </table>


</html>