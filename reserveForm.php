<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap link -->
    <link rel="stylesheet" href="js/bootstrap.min.js"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Anton&display=swap" rel="stylesheet">

    <title>Room Reservation Form</title>

     <style>
        .form-group label{
            color: white;
        }

        .border{
            border: 1px solid blue;
            width: 50%;
            
        }
        label{
            margin-left: 40px;
        }

        .form-control{
            width: 80%;
            font-family: 'Acme', sans-serif;
            margin-left: 40px;
        }

       
     </style>
    
</head>
<body style="margin-left: 35%;
           background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(https://i.imgur.com/ed3PvuG.jpeg);
           background-size: cover;
           background-repeat: no-repeat;"> 
  
    <br>
    
        <Caption><h2 style="margin-left: 30px; font-family: 'Anton', sans-serif; color: white; font-size: xx-large;"> Room Reservation Form </h2><form action="index.php" method="GET">
    <button type="submit" class="btn btn-primary btn-block" style="background: red; width: 15%; margin-left: 35%;">Cancel</button>
</form></Caption>
    <div class="border">
     
        <form>
           <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" placeholder="Enter Name" class="form-control">
            </div>
            <div class="form-group">
                    <label for="">Email:</label>
                    <input type="email" name="email" placeholder="Enter Email" class="form-control">
            </div>

            <div class="form-group">
                    <label>Room Type:</label>
                    <select id="inputState" class="form-control">
                        <option value="">Select room type</option>
                      <option>AC</option>
                      <option>Non-AC</option>
                      <option>Attached</option>
                      <option>Non-Attached</option>
                    </select>
            </div>
            <div class="form-group">
                    <label>Arrival Date:</label>
                    <input type="date" placeholder="" class="form-control">
            </div>
                
            <div class="form-group">
                    <label>Departure Date:</label>
                    <input type="date" placeholder="" class="form-control">
            </div>

            <div class="form-group">
                    <label>No. of guests:</label>
                    <input type="number" placeholder="5" class="form-control">
            </div>

            <div class="form-group">
                    <label>Special Request:</label>
                    <textarea class="form-control" rows="4" placeholder="Type here..." cols="8"></textarea>
            </div>
            <br>
           <button type="submit" class="btn btn-primary btn-block" style="width: 80%; margin-left: 40px;">Submit</button>
            <br>
       </form>
    
    </div>
    <br><br>

</body>
</html>