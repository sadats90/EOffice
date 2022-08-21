<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

            

        <div class="card text-center " >
        
            <div class="card-body">
                <h3>{{$task->task}}</h3>

                <form action='{{url("change_to_done/{$task->id}")}}' method="POST"> 
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                      <button type="submit"  style="border: none; background-color:transparent;">
                          <i class="fas fa-like"><span class="btn btn-primary">Done</span></i>
              
                      </button>
                    </form>


                    <form action='{{url("change_to_inProgress/{$task->id}")}}' method="POST"> 
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                          <button type="submit"  style="border: none; background-color:transparent;">
                              <i class="fas fa-like"><span class="btn btn-primary">In Progress</span></i>
                  
                          </button>
                        </form>



                
             
            </div>
          </div>
    
</body>
</html>