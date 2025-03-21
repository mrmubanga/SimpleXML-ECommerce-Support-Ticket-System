<?php
/**
 * Created by PhpStorm.
 * User: princymascarenhas
 * Date: 2018-03-27
 * Time: 12:49 PM
 */

session_start();


$tickets = simplexml_load_file("tickets.xml");

$users = simplexml_load_file("users.xml");

$userIdLogged = $_SESSION['loggedInUserId']; // getting id from session variable
$userIdLoggedName = $_SESSION['loggedInUserName']; // getting name of the user from session variable

if(getUserRole($userIdLogged) == 'client')
{
    header("Location: error.php"); // redirect user to error page if the client tries to access this page
}

function getUserRole($userId)
{
    $users = simplexml_load_file("users.xml");
    $user = $users->xpath("/users/user[@id=$userId]")[0];
    echo $user;
    return $user->attributes()->role; // return the role of the userId
}

?>

<html>
<head>
    <title>Support System Home Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
</head>

<body>
<div class="container">
<a class="btn btn-primary" href="logout.php" role="button">Logout</a>
<h3 class="text-center">Welcome, <?php echo $userIdLoggedName; ?> from the support staff!</h3>

<p class="text-center">The following tickets are in queue right now from clients</p>


    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Ticket #ID</th>
            <th scope="col">Issue Date</th>
            <th scope="col">Ticket Status</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets->ticket as $ticketElement) :?>
            <tr>

                <td><?php echo $ticketElement->attributes(); ?></td> <!-- users->user[$userIdLogged] -->
                <td><?php echo $ticketElement->issueDate; ?></td>
                <td><?php echo $ticketElement->status; ?></td>
                <td><?php echo $ticketElement->issueCategory; ?></td>
                <td><a class="btn btn-primary" href="viewTicketStaff.php?id=<?php echo $ticketElement->attributes(); ?>" role="button">
                        View and Add Message</a></td>
                <td><a class="btn btn-primary" href="updateTicketStatus.php?id=<?php echo $ticketElement->attributes(); ?>" role="button">
                        Update Status</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>





