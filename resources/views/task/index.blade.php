<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>


    <div class="container">

        <form action= "{{url('add')}}" method = "POST">
            @csrf

        <div class="row">
            <div class="col-lg-11 text-center mb-4 mt-5">
                <input type="text" name="task">
                <button  type="submit">Add</button>
            </div>

        </form>
                
                <br>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                      To Do
                    </div>


                    <ul class="list-group list-group-flush">
                        @foreach($task as $t)
                        <a href='{{url("assign/$t->id")}}'> <li class="list-group-item">{{ $t->task }}</li></a> 
                     
                      @endforeach
                    </ul>
                  </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                      In Progress
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($is_inProgress as $i)
                       
                        <a href='{{url("assign/$i->id")}}'> <li class="list-group-item">{{ $i->task }}</li></a> 

                      
                  
                      @endforeach
                      
                        
                     
                    </ul>
                  </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                      Done
                    </div>
                    <ul class="list-group list-group-flush">
                      @foreach($is_done as $d)
                       
                      <a href='{{url("assign/$d->id")}}'> <li class="list-group-item">{{ $d->task }}</li></a> 

                    
                
                    @endforeach
                    </ul>
                  </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function()
      {
        alert("s")
      })
    </script>
</body>
</html>